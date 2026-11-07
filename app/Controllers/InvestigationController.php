<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Models\Event;
use Tracelabs\Models\Entity;
use Tracelabs\Models\User;

class InvestigationController extends Controller
{
    public function index(Request $request): void
    {
        User::seedDefaultUser();
        $investigations = Investigation::getAll();

        $this->view('investigations/index', [
            'pageTitle' => 'Investigation Workspaces',
            'investigations' => $investigations
        ]);
    }

    public function create(Request $request): void
    {
        $this->view('investigations/create', [
            'pageTitle' => 'Create New Investigation Workspace'
        ]);
    }

    public function store(Request $request): void
    {
        $title = trim((string)$request->post('title'));
        $description = trim((string)$request->post('description'));
        $analyst = trim((string)$request->post('lead_analyst', 'Lead Investigator'));

        if (empty($title)) {
            $title = 'Incident Investigation - ' . date('Y-m-d H:i');
        }

        $id = Investigation::create([
            'title' => $title,
            'description' => $description,
            'lead_analyst' => $analyst,
            'status' => 'Active'
        ]);

        $this->redirect("/investigations/{$id}/import");
    }

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
        $entities = Entity::getByInvestigation($id);
        $events = Event::getByInvestigation($id);

        $this->view('investigations/show', [
            'pageTitle' => "Workspace // {$investigation['title']}",
            'investigation' => $investigation,
            'files' => $files,
            'findings' => $findings,
            'entities' => $entities,
            'events' => array_slice($events, 0, 10),
            'totalEvents' => count($events)
        ]);
    }
}
