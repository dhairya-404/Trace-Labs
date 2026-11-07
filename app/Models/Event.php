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
     * Formats normalized events for vis-timeline JavaScript library with swimlane groups & clean chip styling
     */
    public static function getVisTimelineItems(int $invId): array
    {
        $events = self::getByInvestigation($invId);
        $items = [];

        foreach ($events as $ev) {
            $isAnomaly = ($ev['is_flagged'] > 0);
            $action = strtolower($ev['action']);
            $status = strtolower($ev['status']);
            $isFailed = str_contains($status, 'fail') || str_contains($action, 'fail') || str_contains($action, 'blocked') || str_contains($action, 'deny');

            // Categorize into forensic domain swimlanes
            $category = 'SYSTEM';
            if (
                str_contains($action, 'login') ||
                str_contains($action, 'logout') ||
                str_contains($action, 'auth') ||
                str_contains($action, 'password') ||
                str_contains($action, 'session')
            ) {
                $category = 'AUTH';
            } elseif (
                str_contains($action, 'firewall') ||
                str_contains($action, 'connection') ||
                str_contains($action, 'network') ||
                str_contains($action, 'egress') ||
                str_contains($action, 'traffic') ||
                str_contains($action, 'port') ||
                str_contains($action, 'dns') ||
                str_contains($action, 'packet')
            ) {
                $category = 'NETWORK';
            }

            // Styled compact chip badge
            if ($isAnomaly || $isFailed) {
                $icon = '<i class="bi bi-shield-fill-x text-danger me-1"></i>';
                $chipClass = 'tl-chip tl-chip-danger';
                $className = 'vis-item-anomaly vis-pill-danger';
            } elseif ($category === 'AUTH') {
                $icon = '<i class="bi bi-person-check-fill text-primary me-1"></i>';
                $chipClass = 'tl-chip tl-chip-auth';
                $className = 'vis-item-normal vis-pill-auth';
            } elseif ($category === 'NETWORK') {
                $icon = '<i class="bi bi-hdd-network-fill text-warning me-1"></i>';
                $chipClass = 'tl-chip tl-chip-network';
                $className = 'vis-item-normal vis-pill-network';
            } else {
                $icon = '<i class="bi bi-terminal-fill text-info me-1"></i>';
                $chipClass = 'tl-chip tl-chip-system';
                $className = 'vis-item-normal vis-pill-system';
            }

            $safeAction = htmlspecialchars($ev['action']);
            $actorStr = ($ev['account'] !== 'unknown' && $ev['account'] !== 'anonymous') ? $ev['account'] : $ev['ip_address'];
            $safeActor = htmlspecialchars($actorStr);

            $chipHtml = "<div class=\"{$chipClass}\">{$icon}<span class=\"tl-act\">{$safeAction}</span><span class=\"tl-sep\">&bull;</span><span class=\"tl-who\">{$safeActor}</span></div>";

            $items[] = [
                'id' => $ev['id'],
                'group' => $category,
                'category' => $category,
                'content' => $chipHtml,
                'start' => $ev['timestamp'],
                'className' => $className,
                'title' => "Event #{$ev['id']}: {$ev['action']} by {$ev['account']} from {$ev['ip_address']} [{$ev['timestamp']}]",
                'account' => $ev['account'],
                'ip' => $ev['ip_address'],
                'device' => $ev['device_id'],
                'action' => $ev['action'],
                'status' => $ev['status'],
                'details' => $ev['details'],
                'is_flagged' => $isAnomaly,
                'flag_rule' => $ev['flag_rule']
            ];
        }

        return $items;
    }
}
