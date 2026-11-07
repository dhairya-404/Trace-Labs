<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class CaseModel
{
    public static function getAll(?string $status = null, ?string $priority = null): array
    {
        $sql = "SELECT c.*, 
                (SELECT COUNT(*) FROM evidence WHERE case_id = c.id) as evidence_count,
                (SELECT COUNT(*) FROM timeline_events WHERE case_id = c.id) as timeline_count,
                (SELECT COUNT(*) FROM iocs WHERE case_id = c.id) as ioc_count
                FROM cases c WHERE 1=1";
        $params = [];

        if ($status) {
            $sql .= " AND c.status = :status";
            $params['status'] = $status;
        }

        if ($priority) {
            $sql .= " AND c.priority = :priority";
            $params['priority'] = $priority;
        }

        $sql .= " ORDER BY c.priority = 'CRITICAL' DESC, c.incident_date DESC";
        return Database::fetchAll($sql, $params);
    }

    public static function findById(int $id): ?array
    {
        $sql = "SELECT c.*, 
                (SELECT COUNT(*) FROM evidence WHERE case_id = c.id) as evidence_count,
                (SELECT COUNT(*) FROM timeline_events WHERE case_id = c.id) as timeline_count,
                (SELECT COUNT(*) FROM iocs WHERE case_id = c.id) as ioc_count
                FROM cases c WHERE c.id = :id";
        return Database::fetch($sql, ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO cases (case_number, title, description, classification, priority, status, lead_investigator, incident_date)
                VALUES (:case_number, :title, :description, :classification, :priority, :status, :lead_investigator, :incident_date)";
        Database::query($sql, [
            'case_number' => $data['case_number'],
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'classification' => $data['classification'],
            'priority' => $data['priority'] ?? 'HIGH',
            'status' => $data['status'] ?? 'ACTIVE INVESTIGATION',
            'lead_investigator' => $data['lead_investigator'],
            'incident_date' => $data['incident_date'] ?? date('Y-m-d H:i:s')
        ]);
        return (int)Database::lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        foreach (['title', 'description', 'classification', 'priority', 'status', 'lead_investigator', 'incident_date'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[$field] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = "updated_at = CURRENT_TIMESTAMP";
        $sql = "UPDATE cases SET " . implode(', ', $fields) . " WHERE id = :id";
        Database::query($sql, $params);
        return true;
    }

    public static function delete(int $id): bool
    {
        Database::query("DELETE FROM cases WHERE id = :id", ['id' => $id]);
        return true;
    }

    public static function getStats(): array
    {
        $totalCases = Database::fetch("SELECT COUNT(*) as count FROM cases")['count'] ?? 0;
        $activeCases = Database::fetch("SELECT COUNT(*) as count FROM cases WHERE status != 'CLOSED / REPORTED'")['count'] ?? 0;
        $criticalCases = Database::fetch("SELECT COUNT(*) as count FROM cases WHERE priority = 'CRITICAL'")['count'] ?? 0;
        $totalEvidence = Database::fetch("SELECT COUNT(*) as count FROM evidence")['count'] ?? 0;
        $totalIocs = Database::fetch("SELECT COUNT(*) as count FROM iocs")['count'] ?? 0;

        return [
            'total_cases' => (int)$totalCases,
            'active_cases' => (int)$activeCases,
            'critical_cases' => (int)$criticalCases,
            'total_evidence' => (int)$totalEvidence,
            'total_iocs' => (int)$totalIocs,
        ];
    }
}
