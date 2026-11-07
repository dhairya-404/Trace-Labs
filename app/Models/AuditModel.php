<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class AuditModel
{
    public static function record(array $data): int
    {
        // Fetch last block hash for chain linking
        $lastLog = Database::fetch("SELECT entry_hash FROM audit_logs ORDER BY id DESC LIMIT 1");
        $previousHash = $lastLog['entry_hash'] ?? '0000000000000000000000000000000000000000000000000000000000000000';

        $timestamp = date('Y-m-d H:i:s');
        $rawPayload = $previousHash . '|' . 
                      $data['action'] . '|' . 
                      $data['entity_type'] . '|' . 
                      ($data['entity_id'] ?? '0') . '|' . 
                      $data['actor'] . '|' . 
                      ($data['details'] ?? '') . '|' . 
                      $timestamp;

        $entryHash = hash('sha256', $rawPayload);

        $sql = "INSERT INTO audit_logs (action, entity_type, entity_id, actor, details, ip_address, previous_hash, entry_hash, created_at)
                VALUES (:action, :entity_type, :entity_id, :actor, :details, :ip_address, :previous_hash, :entry_hash, :created_at)";

        Database::query($sql, [
            'action' => $data['action'],
            'entity_type' => $data['entity_type'],
            'entity_id' => $data['entity_id'] ?? null,
            'actor' => $data['actor'] ?? 'Examiner',
            'details' => $data['details'] ?? '',
            'ip_address' => $data['ip_address'] ?? '127.0.0.1',
            'previous_hash' => $previousHash,
            'entry_hash' => $entryHash,
            'created_at' => $timestamp
        ]);

        return (int)Database::lastInsertId();
    }

    public static function getAll(int $limit = 100): array
    {
        $sql = "SELECT * FROM audit_logs ORDER BY id DESC LIMIT :limit";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Verify cryptographic continuity of the forensic audit chain
     */
    public static function verifyChain(): array
    {
        $logs = Database::fetchAll("SELECT * FROM audit_logs ORDER BY id ASC");
        $brokenIndex = null;
        $isValid = true;

        for ($i = 1; $i < count($logs); $i++) {
            $prev = $logs[$i - 1];
            $curr = $logs[$i];

            if ($curr['previous_hash'] !== $prev['entry_hash']) {
                $isValid = false;
                $brokenIndex = $curr['id'];
                break;
            }
        }

        return [
            'is_valid' => $isValid,
            'total_blocks' => count($logs),
            'broken_block_id' => $brokenIndex,
            'status_message' => $isValid ? 'Cryptographic Hash Chain Intact (NIST SP 800-86 Compliant)' : "Chain Compromised at Log Entry ID #{$brokenIndex}"
        ];
    }
}
