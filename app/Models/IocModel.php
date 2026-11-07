<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class IocModel
{
    public static function getAll(?string $type = null): array
    {
        $sql = "SELECT i.*, c.case_number, c.title as case_title 
                FROM iocs i
                JOIN cases c ON i.case_id = c.id";
        $params = [];

        if ($type) {
            $sql .= " WHERE i.type = :type";
            $params['type'] = $type;
        }

        $sql .= " ORDER BY i.confidence_score DESC, i.first_observed DESC";
        return Database::fetchAll($sql, $params);
    }

    public static function getByCase(int $caseId): array
    {
        $sql = "SELECT * FROM iocs WHERE case_id = :case_id ORDER BY confidence_score DESC, first_observed DESC";
        return Database::fetchAll($sql, ['case_id' => $caseId]);
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO iocs (case_id, type, indicator, threat_actor, confidence_score, first_observed, notes)
                VALUES (:case_id, :type, :indicator, :threat_actor, :confidence_score, :first_observed, :notes)";
        Database::query($sql, [
            'case_id' => $data['case_id'],
            'type' => $data['type'],
            'indicator' => trim($data['indicator']),
            'threat_actor' => $data['threat_actor'] ?? 'UNC-Identified',
            'confidence_score' => (int)($data['confidence_score'] ?? 80),
            'first_observed' => $data['first_observed'] ?? date('Y-m-d H:i:s'),
            'notes' => $data['notes'] ?? ''
        ]);
        return (int)Database::lastInsertId();
    }

    public static function delete(int $id): bool
    {
        Database::query("DELETE FROM iocs WHERE id = :id", ['id' => $id]);
        return true;
    }

    /**
     * Export IOCs in STIX 2.1 Threat Intel format
     */
    public static function exportSTIX(int $caseId): array
    {
        $iocs = self::getByCase($caseId);
        $case = CaseModel::findById($caseId);

        $objects = [
            [
                'type' => 'report',
                'spec_version' => '2.1',
                'id' => 'report--' . bin2hex(random_bytes(16)),
                'name' => 'Forensic Threat Report: ' . ($case['case_number'] ?? 'TL-CASE'),
                'published' => date('c'),
                'description' => $case['description'] ?? ''
            ]
        ];

        foreach ($iocs as $ioc) {
            $pattern = match(true) {
                str_contains($ioc['type'], 'IPv4') => "[ipv4-addr:value = '{$ioc['indicator']}']",
                str_contains($ioc['type'], 'Domain') => "[domain-name:value = '{$ioc['indicator']}']",
                str_contains($ioc['type'], 'Hash') => "[file:hashes.'SHA-256' = '{$ioc['indicator']}']",
                default => "[artifact:payload_bin = '{$ioc['indicator']}']"
            };

            $objects[] = [
                'type' => 'indicator',
                'spec_version' => '2.1',
                'id' => 'indicator--' . bin2hex(random_bytes(16)),
                'pattern' => $pattern,
                'pattern_type' => 'stix',
                'confidence' => (int)$ioc['confidence_score'],
                'created' => date('c', strtotime($ioc['first_observed']))
            ];
        }

        return [
            'type' => 'bundle',
            'id' => 'bundle--' . bin2hex(random_bytes(16)),
            'objects' => $objects
        ];
    }
}
