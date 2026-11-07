<?php
declare(strict_types=1);

namespace Tracelabs\Services;

use Tracelabs\Core\Database;

class LogNormalizer
{
    /**
     * Process an uploaded file, calculate SHA-256 hash, normalize records,
     * populate events, and extract entity relationships.
     */
    public static function process(int $investigationId, string $filePath, string $originalFilename): array
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Uploaded file not found at {$filePath}");
        }

        $fileContent = file_get_contents($filePath);
        $sha256 = hash('sha256', $fileContent);
        $fileSize = filesize($filePath);
        $extension = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));

        // 1. Register raw file record
        $fileId = self::registerRawFile($investigationId, $originalFilename, $extension, $sha256, $fileSize);

        // 2. Parse records depending on format
        $parsedRecords = [];
        if ($extension === 'json') {
            $parsedRecords = self::parseJson($fileContent);
        } else {
            $parsedRecords = self::parseCsv($filePath);
        }

        // 3. Normalize each record into unified event schema
        $normalizedEvents = [];
        $lineNumber = 1;

        foreach ($parsedRecords as $record) {
            $norm = self::normalizeSingleRecord($record);
            $norm['investigation_id'] = $investigationId;
            $norm['file_id'] = $fileId;
            $norm['raw_line_number'] = $lineNumber++;
            $norm['raw_data_json'] = json_encode($record, JSON_UNESCAPED_SLASHES);

            $eventId = self::insertEvent($norm);
            $norm['id'] = $eventId;
            $normalizedEvents[] = $norm;

            // 4. Extract Entities & Build Entity Graph Links
            self::extractEntitiesAndLinks($investigationId, $eventId, $norm);
        }

        // Update raw_file count
        Database::query("UPDATE raw_files SET raw_event_count = :count WHERE id = :id", [
            'count' => count($normalizedEvents),
            'id' => $fileId
        ]);

        return [
            'file_id' => $fileId,
            'filename' => $originalFilename,
            'sha256_hash' => $sha256,
            'total_events' => count($normalizedEvents),
            'events' => $normalizedEvents
        ];
    }

    private static function registerRawFile(int $invId, string $filename, string $format, string $sha256, int $size): int
    {
        $sql = "INSERT INTO raw_files (investigation_id, filename, file_format, sha256_hash, file_size, uploaded_at)
                VALUES (:inv_id, :filename, :format, :sha256, :size, CURRENT_TIMESTAMP)";
        Database::query($sql, [
            'inv_id' => $invId,
            'filename' => $filename,
            'format' => strtoupper($format),
            'sha256' => $sha256,
            'size' => $size
        ]);
        return (int)Database::lastInsertId();
    }

    private static function parseCsv(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle);
            if (!$headers) return [];

            // Clean header strings
            $headers = array_map(fn($h) => strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h))), $headers);

            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) === count($headers)) {
                    $rows[] = array_combine($headers, $data);
                }
            }
            fclose($handle);
        }
        return $rows;
    }

    private static function parseJson(string $content): array
    {
        $data = json_decode($content, true);
        if (!is_array($data)) {
            return [];
        }
        return isset($data[0]) ? $data : [$data];
    }

    private static function normalizeSingleRecord(array $raw): array
    {
        // 1. Standardize Timestamp
        $rawTs = $raw['timestamp'] ?? $raw['time'] ?? $raw['datetime'] ?? $raw['date'] ?? date('c');
        $normalizedTs = self::standardizeDate((string)$rawTs);

        // 2. Standardize Account / User
        $account = $raw['account'] ?? $raw['user'] ?? $raw['username'] ?? $raw['user_name'] ?? $raw['src_user'] ?? 'anonymous';

        // 3. Standardize IP
        $ip = $raw['ip_address'] ?? $raw['ip'] ?? $raw['src_ip'] ?? $raw['client_ip'] ?? $raw['source_ip'] ?? '0.0.0.0';

        // 4. Standardize Device
        $device = $raw['device_id'] ?? $raw['device'] ?? $raw['host'] ?? $raw['hostname'] ?? $raw['workstation'] ?? 'DEV-UNKNOWN';

        // 5. Standardize Action
        $action = strtolower((string)($raw['action'] ?? $raw['event'] ?? $raw['event_type'] ?? $raw['activity'] ?? 'generic_event'));

        // 6. Standardize Status
        $status = strtolower((string)($raw['status'] ?? $raw['result'] ?? $raw['outcome'] ?? 'success'));

        // 7. Details / Message
        $details = $raw['details'] ?? $raw['message'] ?? $raw['msg'] ?? $raw['description'] ?? 'Event record captured';

        return [
            'timestamp' => $normalizedTs,
            'account' => trim((string)$account),
            'ip_address' => trim((string)$ip),
            'device_id' => trim((string)$device),
            'action' => trim($action),
            'status' => trim($status),
            'details' => trim((string)$details)
        ];
    }

    private static function standardizeDate(string $rawDate): string
    {
        try {
            $dt = new \DateTime($rawDate);
            return $dt->format('Y-m-d H:i:s');
        } catch (\Exception) {
            return date('Y-m-d H:i:s');
        }
    }

    private static function insertEvent(array $norm): int
    {
        $sql = "INSERT INTO events (investigation_id, file_id, raw_line_number, timestamp, account, ip_address, device_id, action, status, details, raw_data_json)
                VALUES (:inv_id, :file_id, :line, :ts, :account, :ip, :device, :action, :status, :details, :raw_json)";
        Database::query($sql, [
            'inv_id' => $norm['investigation_id'],
            'file_id' => $norm['file_id'],
            'line' => $norm['raw_line_number'],
            'ts' => $norm['timestamp'],
            'account' => $norm['account'],
            'ip' => $norm['ip_address'],
            'device' => $norm['device_id'],
            'action' => $norm['action'],
            'status' => $norm['status'],
            'details' => $norm['details'],
            'raw_json' => $norm['raw_data_json']
        ]);
        return (int)Database::lastInsertId();
    }

    private static function extractEntitiesAndLinks(int $invId, int $eventId, array $norm): void
    {
        $entitiesMap = [];

        // Account Entity
        if (!empty($norm['account']) && $norm['account'] !== 'anonymous') {
            $entitiesMap['account'] = self::upsertEntity($invId, 'account', $norm['account'], $norm['timestamp']);
        }

        // IP Entity
        if (!empty($norm['ip_address']) && $norm['ip_address'] !== '0.0.0.0') {
            $entitiesMap['ip'] = self::upsertEntity($invId, 'ip', $norm['ip_address'], $norm['timestamp']);
        }

        // Device Entity
        if (!empty($norm['device_id']) && $norm['device_id'] !== 'DEV-UNKNOWN') {
            $entitiesMap['device'] = self::upsertEntity($invId, 'device', $norm['device_id'], $norm['timestamp']);
        }

        // Create links between account <-> IP
        if (isset($entitiesMap['account'], $entitiesMap['ip'])) {
            self::upsertLink($invId, $entitiesMap['account'], $entitiesMap['ip'], 'authenticated_from', $eventId);
        }

        // Create links between account <-> Device
        if (isset($entitiesMap['account'], $entitiesMap['device'])) {
            self::upsertLink($invId, $entitiesMap['account'], $entitiesMap['device'], 'used_device', $eventId);
        }

        // Create links between IP <-> Device
        if (isset($entitiesMap['ip'], $entitiesMap['device'])) {
            self::upsertLink($invId, $entitiesMap['ip'], $entitiesMap['device'], 'network_target', $eventId);
        }
    }

    private static function upsertEntity(int $invId, string $type, string $value, string $timestamp): int
    {
        $existing = Database::fetch(
            "SELECT id, event_count, first_seen, last_seen FROM entities WHERE investigation_id = :inv_id AND type = :type AND value = :val",
            ['inv_id' => $invId, 'type' => $type, 'val' => $value]
        );

        if ($existing) {
            Database::query(
                "UPDATE entities SET event_count = event_count + 1, last_seen = :ts WHERE id = :id",
                ['ts' => $timestamp, 'id' => $existing['id']]
            );
            return (int)$existing['id'];
        }

        Database::query(
            "INSERT INTO entities (investigation_id, type, value, event_count, first_seen, last_seen)
             VALUES (:inv_id, :type, :val, 1, :ts, :ts)",
            ['inv_id' => $invId, 'type' => $type, 'val' => $value, 'ts' => $timestamp]
        );
        return (int)Database::lastInsertId();
    }

    private static function upsertLink(int $invId, int $sourceId, int $targetId, string $relation, int $eventId): void
    {
        $existing = Database::fetch(
            "SELECT id FROM entity_links WHERE investigation_id = :inv_id AND source_entity_id = :s AND target_entity_id = :t AND relation_type = :r",
            ['inv_id' => $invId, 's' => $sourceId, 't' => $targetId, 'r' => $relation]
        );

        if ($existing) {
            Database::query("UPDATE entity_links SET weight = weight + 1 WHERE id = :id", ['id' => $existing['id']]);
        } else {
            Database::query(
                "INSERT INTO entity_links (investigation_id, source_entity_id, target_entity_id, relation_type, event_id, weight)
                 VALUES (:inv_id, :s, :t, :r, :ev, 1)",
                ['inv_id' => $invId, 's' => $sourceId, 't' => $targetId, 'r' => $relation, 'ev' => $eventId]
            );
        }
    }
}
