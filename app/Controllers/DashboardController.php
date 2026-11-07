<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\CaseModel;
use Tracelabs\Models\EvidenceModel;
use Tracelabs\Models\TimelineModel;
use Tracelabs\Models\IocModel;
use Tracelabs\Models\AuditModel;

class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $stats = CaseModel::getStats();
        $recentCases = CaseModel::getAll();
        $recentEvidence = EvidenceModel::getAll();
        $recentTimeline = TimelineModel::getAll(10);
        $topIocs = IocModel::getAll();
        $chainStatus = AuditModel::verifyChain();

        $this->view('dashboard/index', [
            'pageTitle' => 'DFIR Command Center',
            'stats' => $stats,
            'recentCases' => array_slice($recentCases, 0, 5),
            'recentEvidence' => array_slice($recentEvidence, 0, 4),
            'recentTimeline' => $recentTimeline,
            'topIocs' => array_slice($topIocs, 0, 5),
            'chainStatus' => $chainStatus
        ]);
    }
}
