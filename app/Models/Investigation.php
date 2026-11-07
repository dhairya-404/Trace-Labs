<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class Investigation
{
    public static function getAll(): array
    {
        $sql = "SELECT i.*, 
                (SELECT COUNT(*) FROM raw_files WHERE investigation_id = i.id) as file_count,
                (SELECT COUNT(*) FROM events WHERE investigation_id = i.id) as event_count,
                (SELECT COUNT(*) FROM entities WHERE investigation_id = i.id) as entity_count,
                (SELECT COUNT(*) FROM findings WHERE investigation_id = i.id) as finding_count
                FROM investigations i ORDER BY i.created_at DESC";
        return Database::fetchAll($sql);
    }

    public static function findById(int $id): ?array
    {
        $sql = "SELECT i.*, 
                (SELECT COUNT(*) FROM raw_files WHERE investigation_id = i.id) as file_count,
                (SELECT COUNT(*) FROM events WHERE investigation_id = i.id) as event_count,
                (SELECT COUNT(*) FROM entities WHERE investigation_id = i.id) as entity_count,
                (SELECT COUNT(*) FROM findings WHERE investigation_id = i.id) as finding_count
                FROM investigations i WHERE i.id = :id";
        return Database::fetch($sql, ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO investigations (title, description, lead_analyst, status, created_at, updated_at)
                VALUES (:title, :description, :lead_analyst, :status, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        Database::query($sql, [
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'lead_analyst' => $data['lead_analyst'] ?? 'Lead Investigator',
            'status' => $data['status'] ?? 'Active'
        ]);
        return (int)Database::lastInsertId();
    }

    public static function getFiles(int $investigationId): array
    {
        return Database::fetchAll(
            "SELECT * FROM raw_files WHERE investigation_id = :inv_id ORDER BY uploaded_at DESC",
            ['inv_id' => $investigationId]
        );
    }

    public static function getFindings(int $investigationId): array
    {
        $sql = "SELECT f.*, e.timestamp, e.account, e.ip_address, e.device_id, e.action, e.raw_line_number, rf.filename, rf.sha256_hash
                FROM findings f
                JOIN events e ON f.event_id = e.id
                JOIN raw_files rf ON e.file_id = rf.id
                WHERE f.investigation_id = :inv_id
                ORDER BY f.severity = 'CRITICAL' DESC, f.severity = 'HIGH' DESC, e.timestamp ASC";
        return Database::fetchAll($sql, ['inv_id' => $investigationId]);
    }
}
