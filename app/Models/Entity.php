<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class Entity
{
    public static function getByInvestigation(int $invId): array
    {
        return Database::fetchAll(
            "SELECT * FROM entities WHERE investigation_id = :inv_id ORDER BY event_count DESC",
            ['inv_id' => $invId]
        );
    }

    /**
     * Formats entities & links into Cytoscape.js graph elements
     */
    public static function getCytoscapeElements(int $invId): array
    {
        $entities = Database::fetchAll(
            "SELECT * FROM entities WHERE investigation_id = :inv_id",
            ['inv_id' => $invId]
        );

        $links = Database::fetchAll(
            "SELECT el.*, s.value as source_val, s.type as source_type, t.value as target_val, t.type as target_type
             FROM entity_links el
             JOIN entities s ON el.source_entity_id = s.id
             JOIN entities t ON el.target_entity_id = t.id
             WHERE el.investigation_id = :inv_id",
            ['inv_id' => $invId]
        );

        $elements = [];

        // Check which entities are associated with flagged anomalies
        $flaggedEntities = Database::fetchAll(
            "SELECT DISTINCT e.account, e.ip_address, e.device_id
             FROM findings f
             JOIN events e ON f.event_id = e.id
             WHERE f.investigation_id = :inv_id",
            ['inv_id' => $invId]
        );

        $anomalyValues = [];
        foreach ($flaggedEntities as $fe) {
            $anomalyValues[$fe['account']] = true;
            $anomalyValues[$fe['ip_address']] = true;
            $anomalyValues[$fe['device_id']] = true;
        }

        // Add Nodes
        foreach ($entities as $ent) {
            $isSuspect = isset($anomalyValues[$ent['value']]);
            $color = match($ent['type']) {
                'account' => $isSuspect ? '#ef4444' : '#3b82f6',
                'ip' => $isSuspect ? '#f97316' : '#10b981',
                'device' => $isSuspect ? '#dc2626' : '#8b5cf6',
                default => '#6b7280'
            };

            $elements[] = [
                'data' => [
                    'id' => 'ent_' . $ent['id'],
                    'label' => $ent['value'],
                    'type' => $ent['type'],
                    'event_count' => (int)$ent['event_count'],
                    'first_seen' => $ent['first_seen'],
                    'last_seen' => $ent['last_seen'],
                    'is_suspect' => $isSuspect,
                    'node_color' => $color
                ]
            ];
        }

        // Add Edges
        foreach ($links as $link) {
            $elements[] = [
                'data' => [
                    'id' => 'link_' . $link['id'],
                    'source' => 'ent_' . $link['source_entity_id'],
                    'target' => 'ent_' . $link['target_entity_id'],
                    'label' => $link['relation_type'],
                    'weight' => (int)$link['weight']
                ]
            ];
        }

        return $elements;
    }
}
