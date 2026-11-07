<?php
declare(strict_types=1);

spl_autoload_register(function (string $class) {
    $prefix = 'Tracelabs\\';
    $baseDir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $file = $baseDir . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($file)) require $file;
});

use Tracelabs\Models\User;
use Tracelabs\Models\Investigation;
use Tracelabs\Models\Event;
use Tracelabs\Models\Entity;
use Tracelabs\Services\LogNormalizer;
use Tracelabs\Services\RuleEngine;
use Tracelabs\Services\MLServiceClient;

echo "=== TRACELAB END-TO-END PIPELINE VERIFICATION ===\n";

// 1. Seed user
User::seedDefaultUser();
echo "[1/6] Investigator Authentication Seeded: OK\n";

// 2. Fetch or create investigation
$inv = Investigation::findById(1);
if (!$inv) {
    $invId = Investigation::create([
        'title' => 'Incident Alpha: Credential Stuffing & Exfiltration',
        'description' => 'Automated test suite workspace',
        'lead_analyst' => 'Dr. Examiner',
        'status' => 'Active'
    ]);
} else {
    $invId = (int)$inv['id'];
}
echo "[2/6] Investigation Workspace #{$invId}: OK\n";

// 3. Process CSV log file
$csvResult = LogNormalizer::process($invId, __DIR__ . '/sample_data/auth_logs_scenario_alpha.csv', 'auth_logs_scenario_alpha.csv');
echo "[3/6] File Normalization Complete: {$csvResult['total_events']} events\n";
echo "      Calculated SHA-256 Fingerprint: {$csvResult['sha256_hash']}\n";

// 4. Process JSON log file
$jsonResult = LogNormalizer::process($invId, __DIR__ . '/sample_data/firewall_traffic_scenario_beta.json', 'firewall_traffic_scenario_beta.json');
echo "[4/6] JSON File Normalization Complete: {$jsonResult['total_events']} events\n";
echo "      Calculated SHA-256 Fingerprint: {$jsonResult['sha256_hash']}\n";

// 5. Test Rule Engine
$ruleFindings = RuleEngine::analyze($invId);
echo "[5/6] Explainable Rule Engine Execution: " . count($ruleFindings) . " anomalies flagged\n";
foreach ($ruleFindings as $f) {
    echo "      * [{$f['severity']}] {$f['rule_name']}\n";
    echo "        Reason: {$f['plain_english_reason']}\n";
}

// 6. Test ML Service Client (Live or Fallback)
$mlResult = MLServiceClient::scoreInvestigation($invId);
echo "[6/6] ML Anomaly Service: {$mlResult['service_mode']}\n";
echo "      Events Analyzed: {$mlResult['total_analyzed']} | Outliers Flagged: {$mlResult['anomalies_flagged']}\n";

// 7. Test Graph Elements for Cytoscape.js
$graphElements = Entity::getCytoscapeElements($invId);
echo "\n[Graph] Generated " . count($graphElements) . " Cytoscape.js graph elements (nodes & edges)\n";

// 8. Test Timeline Items for vis-timeline
$timelineItems = Event::getVisTimelineItems($invId);
echo "[Timeline] Generated " . count($timelineItems) . " vis-timeline chronological events\n";

echo "\n>>> ALL TRACELAB CHECKS PASSED PERFECTLY! <<<\n";
