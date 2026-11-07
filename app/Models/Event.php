<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class Event
{
    public static function getByInvestigation(int $invId, array $filters = []): array
    {
        $sql = "SELECT e.*, rf.filename, rf.sha256_hash,
                (SELECT COUNT(*) FROM findings WHERE event_id = e.id) as is_flagged,
                (SELECT rule_name FROM findings WHERE event_id = e.id LIMIT 1) as flag_rule
                FROM events e
                JOIN raw_files rf ON e.file_id = rf.id
                WHERE e.investigation_id = :inv_id";
        $params = ['inv_id' => $invId];

        if (!empty($filters['account'])) {
            $sql .= " AND e.account LIKE :account";
            $params['account'] = "%{$filters['account']}%";
        }

        if (!empty($filters['ip'])) {
            $sql .= " AND e.ip_address LIKE :ip";
            $params['ip'] = "%{$filters['ip']}%";
        }

        if (!empty($filters['action'])) {
            $sql .= " AND e.action LIKE :action";
            $params['action'] = "%{$filters['action']}%";
        }

        $sql .= " ORDER BY e.timestamp ASC";
        return Database::fetchAll($sql, $params);
    }

    public static function findById(int $id): ?array
    {
        $sql = "SELECT e.*, rf.filename, rf.sha256_hash, rf.file_format,
                f.rule_name, f.severity, f.plain_english_reason, f.ml_anomaly_score
                FROM events e
                JOIN raw_files rf ON e.file_id = rf.id
                LEFT JOIN findings f ON f.event_id = e.id
                WHERE e.id = :id";
        return Database::fetch($sql, ['id' => $id]);
    }

    /**
     * Formats normalized events for vis-timeline JavaScript library
     */
    public static function getVisTimelineItems(int $invId): array
    {
        $events = self::getByInvestigation($invId);
        $items = [];

        foreach ($events as $ev) {
            $isAnomaly = ($ev['is_flagged'] > 0);
            $className = $isAnomaly ? 'vis-item-anomaly' : 'vis-item-normal';

            $label = htmlspecialchars($ev['action']) . ' <small>(' . htmlspecialchars($ev['account']) . ')</small>';
            if ($isAnomaly) {
                $label = '⚠️ <strong>' . $label . '</strong>';
            }

            $items[] = [
                'id' => $ev['id'],
                'content' => $label,
                'start' => $ev['timestamp'],
                'className' => $className,
                'title' => "Event #{$ev['id']}: {$ev['action']} by {$ev['account']} from {$ev['ip_address']} [{$ev['timestamp']}]",
                'account' => $ev['account'],
                'ip' => $ev['ip_address'],
                'device' => $ev['device_id'],
                'status' => $ev['status'],
                'details' => $ev['details'],
                'is_flagged' => $isAnomaly,
                'flag_rule' => $ev['flag_rule']
            ];
        }

        return $items;
    }
}
