<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\CaseModel;
use Tracelabs\Models\EvidenceModel;
use Tracelabs\Models\TimelineModel;
use Tracelabs\Models\IocModel;

class CaseController extends Controller
{
    public function index(Request $request): void
    {
        $status = $request->get('status');
        $priority = $request->get('priority');

        $cases = CaseModel::getAll($status, $priority);

        $this->view('cases/index', [
            'pageTitle' => 'Forensic Case Registry',
            'cases' => $cases,
            'currentStatus' => $status,
            'currentPriority' => $priority
        ]);
    }

    public function show(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $case = CaseModel::findById($id);

        if (!$case) {
            $this->redirect('/cases');
            return;
        }

        $evidence = EvidenceModel::getAll($id);
        $timeline = TimelineModel::getByCase($id);
        $iocs = IocModel::getByCase($id);

        $this->view('cases/show', [
            'pageTitle' => "Case #{$case['case_number']}",
            'case' => $case,
            'evidence' => $evidence,
            'timeline' => $timeline,
            'iocs' => $iocs
        ]);
    }

    public function create(Request $request): void
    {
        $this->view('cases/create', [
            'pageTitle' => 'Initiate Incident Case'
        ]);
    }

    public function store(Request $request): void
    {
        $caseNumber = 'TL-' . date('Y') . '-' . str_pad((string)mt_rand(100, 9999), 4, '0', STR_PAD_LEFT);

        $caseId = CaseModel::create([
            'case_number' => $caseNumber,
            'title' => trim((string)$request->post('title')),
            'description' => trim((string)$request->post('description')),
            'classification' => (string)$request->post('classification'),
            'priority' => (string)$request->post('priority', 'HIGH'),
            'status' => 'ACTIVE INVESTIGATION',
            'lead_investigator' => trim((string)$request->post('lead_investigator', 'Examiner-In-Charge')),
            'incident_date' => (string)$request->post('incident_date', date('Y-m-d H:i:s'))
        ]);

        $this->audit('CASE_INITIATED', 'Case', $caseId, (string)$request->post('lead_investigator'), [
            'case_number' => $caseNumber,
            'classification' => $request->post('classification')
        ]);

        $this->redirect("/cases/{$caseId}");
    }

    public function updateStatus(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $status = (string)$request->post('status');
        $priority = (string)$request->post('priority');

        $data = [];
        if ($status) $data['status'] = $status;
        if ($priority) $data['priority'] = $priority;

        CaseModel::update($id, $data);

        $this->audit('CASE_STATUS_UPDATED', 'Case', $id, 'Lead Examiner', $data);

        if ($request->get('format') === 'json') {
            $this->json(['success' => true]);
            return;
        }

        $this->redirect("/cases/{$id}");
    }
}
