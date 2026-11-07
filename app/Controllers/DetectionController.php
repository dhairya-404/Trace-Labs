<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Services\RuleEngine;
use Tracelabs\Services\MLServiceClient;

class DetectionController extends Controller
{
    public function show(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->redirect('/investigations');
            return;
        }

        $findings = Investigation::getFindings($id);
        $evalReport = MLServiceClient::getEvaluationReport();

        $ruleCount = 0;
        $mlCount = 0;
        foreach ($findings as $f) {
            if ($f['detection_source'] === 'RULE_BASED') $ruleCount++;
            if ($f['detection_source'] === 'MACHINE_LEARNING') $mlCount++;
        }

        $this->view('detections/index', [
            'pageTitle' => "Detections & Anomaly Scoring // {$investigation['title']}",
            'investigation' => $investigation,
            'findings' => $findings,
            'ruleCount' => $ruleCount,
            'mlCount' => $mlCount,
            'evalReport' => $evalReport
        ]);
    }

    public function rerun(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        RuleEngine::analyze($id);
        MLServiceClient::scoreInvestigation($id);
        $this->redirect("/investigations/{$id}/detections?analyzed=1");
    }
}
