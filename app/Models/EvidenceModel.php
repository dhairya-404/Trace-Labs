<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class EvidenceModel
{
    public static function getAll(?int $caseId = null): array
    {
        $sql = "SELECT e.*, c.case_number, c.title as case_title,
                (SELECT COUNT(*) FROM chain_of_custody WHERE evidence_id = e.id) as custody_events_count
                FROM evidence e
                JOIN cases c ON e.case_id = c.id";
        $params = [];

        if ($caseId) {
            $sql .= " WHERE e.case_id = :case_id";
            $params['case_id'] = $caseId;
        }

        $sql .= " ORDER BY e.acquired_at DESC";
        return Database::fetchAll($sql, $params);
    }

    public static function findById(int $id): ?array
    {
        $sql = "SELECT e.*, c.case_number, c.title as case_title
                FROM evidence e
                JOIN cases c ON e.case_id = c.id
                WHERE e.id = :id";
        return Database::fetch($sql, ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO evidence (case_id, evidence_tag, item_type, source_host, sha256_hash, md5_hash, size_bytes, storage_location, custodian, integrity_status, acquired_at)
                VALUES (:case_id, :evidence_tag, :item_type, :source_host, :sha256_hash, :md5_hash, :size_bytes, :storage_location, :custodian, :integrity_status, :acquired_at)";
        Database::query($sql, [
            'case_id' => $data['case_id'],
            'evidence_tag' => $data['evidence_tag'],
            'item_type' => $data['item_type'],
            'source_host' => $data['source_host'],
            'sha256_hash' => strtolower(trim($data['sha256_hash'])),
            'md5_hash' => strtolower(trim($data['md5_hash'])),
            'size_bytes' => (int)($data['size_bytes'] ?? 0),
            'storage_location' => $data['storage_location'],
            'custodian' => $data['custodian'],
            'integrity_status' => $data['integrity_status'] ?? 'VERIFIED MATCH',
            'acquired_at' => $data['acquired_at'] ?? date('Y-m-d H:i:s')
        ]);
        return (int)Database::lastInsertId();
    }

    public static function verifyHash(int $id, string $submittedHash): array
    {
        $evidence = self::findById($id);
        if (!$evidence) {
            return ['status' => 'error', 'message' => 'Evidence record not found'];
        }

        $submittedClean = strtolower(trim($submittedHash));
        $matchesSha256 = ($submittedClean === strtolower($evidence['sha256_hash']));
        $matchesMd5 = ($submittedClean === strtolower($evidence['md5_hash']));

        $isMatch = ($matchesSha256 || $matchesMd5);
        $status = $isMatch ? 'VERIFIED MATCH' : 'TAMPER ALERT';

        Database::query("UPDATE evidence SET integrity_status = :status WHERE id = :id", [
            'status' => $status,
            'id' => $id
        ]);

        return [
            'is_match' => $isMatch,
            'status' => $status,
            'algorithm' => $matchesSha256 ? 'SHA-256' : ($matchesMd5 ? 'MD5' : 'Unknown / Non-Matching'),
            'expected_sha256' => $evidence['sha256_hash'],
            'expected_md5' => $evidence['md5_hash'],
            'submitted' => $submittedClean
        ];
    }

    public static function addCustodyRecord(int $evidenceId, array $data): int
    {
        $sql = "INSERT INTO chain_of_custody (evidence_id, transferred_by, received_by, purpose, timestamp, notes)
                VALUES (:evidence_id, :transferred_by, :received_by, :purpose, :timestamp, :notes)";
        Database::query($sql, [
            'evidence_id' => $evidenceId,
            'transferred_by' => $data['transferred_by'],
            'received_by' => $data['received_by'],
            'purpose' => $data['purpose'],
            'timestamp' => $data['timestamp'] ?? date('Y-m-d H:i:s'),
            'notes' => $data['notes'] ?? ''
        ]);

        // Update current custodian on evidence record
        Database::query("UPDATE evidence SET custodian = :custodian WHERE id = :id", [
            'custodian' => $data['received_by'],
            'id' => $evidenceId
        ]);

        return (int)Database::lastInsertId();
    }

    public static function getCustodyChain(int $evidenceId): array
    {
        $sql = "SELECT * FROM chain_of_custody WHERE evidence_id = :evidence_id ORDER BY timestamp ASC";
        return Database::fetchAll($sql, ['evidence_id' => $evidenceId]);
    }
}
