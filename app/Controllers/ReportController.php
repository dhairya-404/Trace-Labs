<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Models\Event;
use Tracelabs\Models\Entity;
use Tracelabs\Services\MLServiceClient;

class ReportController extends Controller
{
    public function show(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->redirect('/investigations');
            return;
        }

        $files = Investigation::getFiles($id);
        $findings = Investigation::getFindings($id);
        $events = Event::getByInvestigation($id);
        $entities = Entity::getByInvestigation($id);
        $evalReport = MLServiceClient::getEvaluationReport();

        $this->view('reports/show', [
            'pageTitle' => "Final Investigation Report // {$investigation['title']}",
            'investigation' => $investigation,
            'files' => $files,
            'findings' => $findings,
            'events' => $events,
            'entities' => $entities,
            'evalReport' => $evalReport,
            'generatedAt' => date('Y-m-d H:i:s T')
        ], 'report');
    }

    public function exportJson(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->json(['error' => 'Investigation not found'], 404);
            return;
        }

        $files = Investigation::getFiles($id);
        $findings = Investigation::getFindings($id);
        $events = Event::getByInvestigation($id);
        $entities = Entity::getByInvestigation($id);

        $payload = [
            'tracelab_metadata' => [
                'system' => 'TraceLab Digital Forensics & Activity Log Analyzer',
                'version' => '1.0.0-MVP',
                'exported_at' => date('c'),
                'academic_project' => '6th-Semester Degree Capstone'
            ],
            'investigation' => $investigation,
            'evidence_files' => $files,
            'summary_metrics' => [
                'total_files_ingested' => count($files),
                'total_events_normalized' => count($events),
                'unique_entities_identified' => count($entities),
                'anomalies_flagged' => count($findings)
            ],
            'provenance_trace' => array_map(function($f) {
                return [
                    'finding_id' => $f['id'],
                    'rule_or_model' => $f['rule_name'],
                    'detection_source' => $f['detection_source'],
                    'severity' => $f['severity'],
                    'plain_english_reason' => $f['plain_english_reason'],
                    'ml_anomaly_score' => (float)$f['ml_anomaly_score'],
                    'linked_source_record' => [
                        'file_origin' => $f['filename'],
                        'sha256_hash' => $f['sha256_hash'],
                        'raw_line_number' => $f['raw_line_number'],
                        'timestamp' => $f['timestamp'],
                        'account' => $f['account'],
                        'ip_address' => $f['ip_address'],
                        'device_id' => $f['device_id'],
                        'action' => $f['action']
                    ]
                ];
            }, $findings),
            'full_event_timeline' => $events
        ];

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="tracelab-investigation-' . $id . '-report.json"');
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
