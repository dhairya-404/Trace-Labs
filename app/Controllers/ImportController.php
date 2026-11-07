<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Services\LogNormalizer;
use Tracelabs\Services\RuleEngine;
use Tracelabs\Services\MLServiceClient;

class ImportController extends Controller
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

        $this->view('import/index', [
            'pageTitle' => "Import & Normalize Logs // {$investigation['title']}",
            'investigation' => $investigation,
            'files' => $files,
            'summary' => null,
            'error' => null
        ]);
    }

    public function upload(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->redirect('/investigations');
            return;
        }

        // Check if sample data load requested
        $sampleType = $request->post('sample_dataset');
        if ($sampleType) {
            $samplePath = match($sampleType) {
                'auth' => __DIR__ . '/../../sample_data/auth_logs_scenario_alpha.csv',
                'firewall' => __DIR__ . '/../../sample_data/firewall_traffic_scenario_beta.json',
                default => null
            };

            if ($samplePath && file_exists($samplePath)) {
                $filename = basename($samplePath);
                $importResult = LogNormalizer::process($id, $samplePath, $filename);

                // Auto-run detection rules and ML scoring on import
                RuleEngine::analyze($id);
                MLServiceClient::scoreInvestigation($id);

                $this->redirect("/investigations/{$id}/timeline?imported=1&sha256=" . $importResult['sha256_hash']);
                return;
            }
        }

        // Handle uploaded file
        if (!isset($_FILES['log_file']) || $_FILES['log_file']['error'] !== UPLOAD_ERR_OK) {
            $files = Investigation::getFiles($id);
            $this->view('import/index', [
                'pageTitle' => "Import & Normalize Logs",
                'investigation' => $investigation,
                'files' => $files,
                'summary' => null,
                'error' => 'Please select a valid CSV or JSON file to upload.'
            ]);
            return;
        }

        $file = $_FILES['log_file'];
        $filename = $file['name'];
        $tempPath = $file['tmp_name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, ['csv', 'json'], true)) {
            $files = Investigation::getFiles($id);
            $this->view('import/index', [
                'pageTitle' => "Import & Normalize Logs",
                'investigation' => $investigation,
                'files' => $files,
                'summary' => null,
                'error' => 'Unsupported format. TraceLab accepts .csv and .json log files only.'
            ]);
            return;
        }

        // Process, calculate SHA-256 fingerprint, normalize records
        $importResult = LogNormalizer::process($id, $tempPath, $filename);

        // Run Rule checks and ML detection
        RuleEngine::analyze($id);
        MLServiceClient::scoreInvestigation($id);

        $this->redirect("/investigations/{$id}/timeline?imported=1&sha256=" . $importResult['sha256_hash']);
    }
}
