<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class TimelineModel
{
    public static function getByCase(int $caseId, ?string $tactic = null, ?string $severity = null): array
    {
        $sql = "SELECT t.*, c.case_number 
                FROM timeline_events t
                JOIN cases c ON t.case_id = c.id
                WHERE t.case_id = :case_id";
        $params = ['case_id' => $caseId];

        if ($tactic) {
            $sql .= " AND t.mitre_tactic LIKE :tactic";
            $params['tactic'] = "%{$tactic}%";
        }

        if ($severity) {
            $sql .= " AND t.severity = :severity";
            $params['severity'] = $severity;
        }

        $sql .= " ORDER BY t.timestamp ASC";
        return Database::fetchAll($sql, $params);
    }

    public static function getAll(int $limit = 100): array
    {
        $sql = "SELECT t.*, c.case_number, c.title as case_title
                FROM timeline_events t
                JOIN cases c ON t.case_id = c.id
                ORDER BY t.timestamp DESC LIMIT :limit";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO timeline_events (case_id, timestamp, source_artifact, actor_or_source, mitre_tactic, event_summary, severity, is_ioc)
                VALUES (:case_id, :timestamp, :source_artifact, :actor_or_source, :mitre_tactic, :event_summary, :severity, :is_ioc)";
        Database::query($sql, [
            'case_id' => $data['case_id'],
            'timestamp' => $data['timestamp'] ?? date('Y-m-d H:i:s'),
            'source_artifact' => $data['source_artifact'],
            'actor_or_source' => $data['actor_or_source'],
            'mitre_tactic' => $data['mitre_tactic'],
            'event_summary' => $data['event_summary'],
            'severity' => $data['severity'] ?? 'INFO',
            'is_ioc' => (int)($data['is_ioc'] ?? 0)
        ]);
        return (int)Database::lastInsertId();
    }

    public static function delete(int $id): bool
    {
        Database::query("DELETE FROM timeline_events WHERE id = :id", ['id' => $id]);
        return true;
    }
}
