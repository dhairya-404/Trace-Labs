<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\AuditModel;

class AuditController extends Controller
{
    public function index(Request $request): void
    {
        $logs = AuditModel::getAll(50);
        $verification = AuditModel::verifyChain();

        $this->view('audit/index', [
            'pageTitle' => 'Cryptographic Audit Trail (NIST SP 800-86)',
            'logs' => $logs,
            'verification' => $verification
        ]);
    }

    public function verify(Request $request): void
    {
        $result = AuditModel::verifyChain();
        $this->json($result);
    }
}
