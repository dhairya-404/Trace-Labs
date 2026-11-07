<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\IocModel;
use Tracelabs\Models\CaseModel;

class IocController extends Controller
{
    public function index(Request $request): void
    {
        $type = $request->get('type');
        $iocs = IocModel::getAll($type);
        $cases = CaseModel::getAll();

        $this->view('iocs/index', [
            'pageTitle' => 'Threat Intel & Indicators of Compromise',
            'iocs' => $iocs,
            'cases' => $cases,
            'currentType' => $type
        ]);
    }

    public function store(Request $request): void
    {
        $caseId = (int)$request->post('case_id');

        $iocId = IocModel::create([
            'case_id' => $caseId,
            'type' => (string)$request->post('type'),
            'indicator' => (string)$request->post('indicator'),
            'threat_actor' => (string)$request->post('threat_actor', 'UNC-Identified'),
            'confidence_score' => (int)$request->post('confidence_score', 85),
            'first_observed' => (string)$request->post('first_observed', date('Y-m-d H:i:s')),
            'notes' => (string)$request->post('notes', '')
        ]);

        $this->audit('IOC_REGISTERED', 'IOC', $iocId, 'Threat Hunter', [
            'indicator' => $request->post('indicator'),
            'type' => $request->post('type')
        ]);

        $this->redirect('/iocs');
    }

    public function exportStix(Request $request, array $params): void
    {
        $caseId = (int)$params['id'];
        $bundle = IocModel::exportSTIX($caseId);

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="tracelabs-stix2-case-' . $caseId . '.json"');
        echo json_encode($bundle, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
