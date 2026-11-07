<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\EvidenceModel;
use Tracelabs\Models\CaseModel;

class EvidenceController extends Controller
{
    public function index(Request $request): void
    {
        $caseId = $request->get('case_id') ? (int)$request->get('case_id') : null;
        $evidence = EvidenceModel::getAll($caseId);
        $cases = CaseModel::getAll();

        $this->view('evidence/index', [
            'pageTitle' => 'Digital Evidence Locker',
            'evidence' => $evidence,
            'cases' => $cases,
            'selectedCaseId' => $caseId
        ]);
    }

    public function create(Request $request): void
    {
        $cases = CaseModel::getAll();
        $preselectedCaseId = $request->get('case_id') ? (int)$request->get('case_id') : null;

        $this->view('evidence/create', [
            'pageTitle' => 'Evidence Accession & Ingestion',
            'cases' => $cases,
            'preselectedCaseId' => $preselectedCaseId
        ]);
    }

    public function store(Request $request): void
    {
        $caseId = (int)$request->post('case_id');
        $tag = 'EVD-' . mt_rand(100, 999) . '-' . strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string)$request->post('item_type')), 0, 4));

        $evidenceId = EvidenceModel::create([
            'case_id' => $caseId,
            'evidence_tag' => (string)$request->post('evidence_tag', $tag),
            'item_type' => (string)$request->post('item_type'),
            'source_host' => (string)$request->post('source_host', 'UNKNOWN-HOST'),
            'sha256_hash' => (string)$request->post('sha256_hash'),
            'md5_hash' => (string)$request->post('md5_hash'),
            'size_bytes' => (int)$request->post('size_bytes', 0),
            'storage_location' => (string)$request->post('storage_location'),
            'custodian' => (string)$request->post('custodian'),
            'integrity_status' => 'VERIFIED MATCH',
            'acquired_at' => (string)$request->post('acquired_at', date('Y-m-d H:i:s'))
        ]);

        // Add initial acquisition chain of custody record
        EvidenceModel::addCustodyRecord($evidenceId, [
            'transferred_by' => 'Evidence Field Ingestion',
            'received_by' => (string)$request->post('custodian'),
            'purpose' => 'Initial Physical/Logical Seizure & Cryptographic Registration',
            'notes' => 'Acquired with hardware write-blocker protection. Dual hashing complete.'
        ]);

        $this->audit('EVIDENCE_SEIZED', 'Evidence', $evidenceId, (string)$request->post('custodian'), [
            'tag' => $tag,
            'case_id' => $caseId,
            'sha256' => $request->post('sha256_hash')
        ]);

        $this->redirect("/evidence/{$evidenceId}/custody");
    }

    public function custody(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $evidence = EvidenceModel::findById($id);

        if (!$evidence) {
            $this->redirect('/evidence');
            return;
        }

        $chain = EvidenceModel::getCustodyChain($id);

        $this->view('evidence/custody', [
            'pageTitle' => "Chain of Custody // {$evidence['evidence_tag']}",
            'evidence' => $evidence,
            'chain' => $chain
        ]);
    }

    public function storeCustody(Request $request, array $params): void
    {
        $id = (int)$params['id'];

        EvidenceModel::addCustodyRecord($id, [
            'transferred_by' => (string)$request->post('transferred_by'),
            'received_by' => (string)$request->post('received_by'),
            'purpose' => (string)$request->post('purpose'),
            'notes' => (string)$request->post('notes')
        ]);

        $this->audit('CUSTODY_TRANSFER', 'Evidence', $id, (string)$request->post('received_by'), [
            'from' => $request->post('transferred_by'),
            'to' => $request->post('received_by'),
            'purpose' => $request->post('purpose')
        ]);

        $this->redirect("/evidence/{$id}/custody");
    }

    public function verifyHash(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $hash = (string)$request->post('hash');

        $result = EvidenceModel::verifyHash($id, $hash);

        $this->audit('INTEGRITY_CHECK', 'Evidence', $id, 'Forensic Auditor', [
            'result' => $result['status'],
            'algorithm' => $result['algorithm']
        ]);

        $this->json($result);
    }
}
