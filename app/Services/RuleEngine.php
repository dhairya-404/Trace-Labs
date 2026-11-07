<?php
declare(strict_types=1);

namespace Tracelabs\Services;

use Tracelabs\Core\Database;

class RuleEngine
{
    /**
     * Run all explainable detection rules on an investigation's events
     */
    public static function analyze(int $investigationId): array
    {
        $events = Database::fetchAll(
            "SELECT * FROM events WHERE investigation_id = :inv_id ORDER BY timestamp ASC",
            ['inv_id' => $investigationId]
        );

        $findings = [];

        // Run Rule 1: Brute Force / Credential Stuffing
        $findings = array_merge($findings, self::checkBruteForce($investigationId, $events));

        // Run Rule 2: Off-Hours Sensitive Operation
        $findings = array_merge($findings, self::checkOffHoursSensitiveOps($investigationId, $events));

        // Run Rule 3: Destructive Persistence & Anti-Forensics
        $findings = array_merge($findings, self::checkDestructiveActivity($investigationId, $events));

        return $findings;
    }

    /**
     * Rule 1: 5 failed logins within 2 minutes followed by a success
     */
    private static function checkBruteForce(int $invId, array $events): array
    {
        $findings = [];
        $failuresByAccount = [];

        foreach ($events as $ev) {
            $account = $ev['account'];
            $status = strtolower($ev['status']);
            $action = strtolower($ev['action']);
            $ts = strtotime($ev['timestamp']);

            $isFailed = (str_contains($status, 'fail') || str_contains($action, 'failed'));
            $isSuccess = (str_contains($status, 'success') && str_contains($action, 'login'));

            if ($isFailed) {
                if (!isset($failuresByAccount[$account])) {
                    $failuresByAccount[$account] = [];
                }
                $failuresByAccount[$account][] = $ev;
            } elseif ($isSuccess) {
                if (isset($failuresByAccount[$account])) {
                    // Check if recent failures within 120 seconds
                    $recentFailures = array_filter(
                        $failuresByAccount[$account],
                        fn($f) => ($ts - strtotime($f['timestamp'])) <= 120 && ($ts >= strtotime($f['timestamp']))
                    );

                    if (count($recentFailures) >= 3) { // 3 to 5 rapid failures
                        $count = count($recentFailures);
                        $reason = "Brute Force Pattern: Account '{$account}' experienced {$count} authentication failures within 2 minutes from IP {$ev['ip_address']}, immediately followed by a successful login. Matches automated credential stuffing.";
                        
                        $findings[] = self::recordFinding($invId, (int)$ev['id'], 'RULE_BASED', 'RULE-01: Brute-Force & Credential Stuffing', 'CRITICAL', $reason);
                    }
                    // Reset failure buffer for this account
                    unset($failuresByAccount[$account]);
                }
            }
        }

        return $findings;
    }

    /**
     * Rule 2: Off-Hours Activity & External IP Spike
     */
    private static function checkOffHoursSensitiveOps(int $invId, array $events): array
    {
        $findings = [];
        $sensitiveActions = ['privilege_escalation', 'data_export', 'shadow_copy_delete', 'service_restart'];

        foreach ($events as $ev) {
            $hour = (int)date('G', strtotime($ev['timestamp']));
            $isOffHours = ($hour >= 21 || $hour < 6);
            $action = strtolower($ev['action']);

            $isSensitive = in_array($action, $sensitiveActions, true) || 
                           str_contains(strtolower($ev['details']), 'admin') || 
                           str_contains(strtolower($ev['details']), 'dump');

            $isExternalIp = !str_starts_with($ev['ip_address'], '10.') && 
                            !str_starts_with($ev['ip_address'], '192.168.') && 
                            !str_starts_with($ev['ip_address'], '172.16.') &&
                            $ev['ip_address'] !== '127.0.0.1' &&
                            $ev['ip_address'] !== '0.0.0.0';

            if ($isOffHours && ($isSensitive || $isExternalIp)) {
                $reason = "Off-Hours Anomaly: Event '{$ev['action']}' was executed at " . date('H:i:s', strtotime($ev['timestamp'])) . " by '{$ev['account']}' from external IP {$ev['ip_address']}. Standard activity should occur within 08:00–18:00 local time.";
                $severity = $isSensitive ? 'HIGH' : 'MEDIUM';

                $findings[] = self::recordFinding($invId, (int)$ev['id'], 'RULE_BASED', 'RULE-02: Anomalous Off-Hours Activity', $severity, $reason);
            }
        }

        return $findings;
    }

    /**
     * Rule 3: Destructive Persistence & Anti-Forensics
     */
    private static function checkDestructiveActivity(int $invId, array $events): array
    {
        $findings = [];

        foreach ($events as $ev) {
            $action = strtolower($ev['action']);
            $details = strtolower($ev['details']);

            $isVssPurge = str_contains($action, 'shadow') || str_contains($details, 'vssadmin') || str_contains($details, 'delete shadows');
            $isExfil = str_contains($action, 'export') && (str_contains($details, 'gb') || str_contains($details, 'bulk'));

            if ($isVssPurge) {
                $reason = "Anti-Forensics Alert: Volume Shadow Copy deletion detected on host '{$ev['device_id']}'. Threat actors commonly purge restore points prior to deploying ransomware payloads to prevent data recovery.";
                $findings[] = self::recordFinding($invId, (int)$ev['id'], 'RULE_BASED', 'RULE-03: Anti-Forensic Tampering (Shadow Copy Purge)', 'CRITICAL', $reason);
            } elseif ($isExfil) {
                $reason = "Data Exfiltration Indicator: Large volume bulk data transfer ({$ev['details']}) initiated by '{$ev['account']}'. Potential intellectual property or sensitive database staging.";
                $findings[] = self::recordFinding($invId, (int)$ev['id'], 'RULE_BASED', 'RULE-03: Data Exfiltration Indicator', 'HIGH', $reason);
            }
        }

        return $findings;
    }

    private static function recordFinding(int $invId, int $eventId, string $source, string $ruleName, string $severity, string $reason, float $mlScore = 0.0): array
    {
        // Avoid duplicate findings
        $existing = Database::fetch(
            "SELECT id, event_id, rule_name, severity, plain_english_reason FROM findings WHERE investigation_id = :inv_id AND event_id = :ev_id AND rule_name = :rule",
            ['inv_id' => $invId, 'ev_id' => $eventId, 'rule' => $ruleName]
        );

        if ($existing) {
            return $existing;
        }

        $sql = "INSERT INTO findings (investigation_id, event_id, detection_source, rule_name, severity, plain_english_reason, ml_anomaly_score, created_at)
                VALUES (:inv_id, :ev_id, :src, :rule, :sev, :reason, :ml_score, CURRENT_TIMESTAMP)";
        Database::query($sql, [
            'inv_id' => $invId,
            'ev_id' => $eventId,
            'src' => $source,
            'rule' => $ruleName,
            'sev' => $severity,
            'reason' => $reason,
            'ml_score' => $mlScore
        ]);

        return [
            'id' => (int)Database::lastInsertId(),
            'event_id' => $eventId,
            'rule_name' => $ruleName,
            'severity' => $severity,
            'plain_english_reason' => $reason
        ];
    }
}
