<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Models\Event;

class TimelineController extends Controller
{
    public function show(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->redirect('/investigations');
            return;
        }

        $filters = [
            'account' => $request->get('account'),
            'ip' => $request->get('ip'),
            'action' => $request->get('action')
        ];

        $events = Event::getByInvestigation($id, $filters);
        $files = Investigation::getFiles($id);

        $this->view('timeline/index', [
            'pageTitle' => "Timeline — {$investigation['title']}",
            'investigation' => $investigation,
            'events' => $events,
            'files' => $files,
            'filters' => $filters,
            'importedSha256' => $request->get('sha256')
        ]);
    }

    public function data(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $items = Event::getVisTimelineItems($id);

        $groups = [
            [
                'id' => 'AUTH',
                'content' => '<div class="tl-group-header"><i class="bi bi-person-badge text-primary me-2"></i><strong>Authentication</strong><div class="tl-group-sub">Logins, Sessions & Access</div></div>',
                'order' => 1
            ],
            [
                'id' => 'NETWORK',
                'content' => '<div class="tl-group-header"><i class="bi bi-hdd-network text-warning me-2"></i><strong>Network Flows</strong><div class="tl-group-sub">Firewall & Perimeter Egress</div></div>',
                'order' => 2
            ],
            [
                'id' => 'SYSTEM',
                'content' => '<div class="tl-group-header"><i class="bi bi-terminal text-info me-2"></i><strong>Host & Files</strong><div class="tl-group-sub">File Access & Operations</div></div>',
                'order' => 3
            ]
        ];

        $this->json([
            'items' => $items,
            'groups' => $groups
        ]);
    }

    public function eventDetails(Request $request, array $params): void
    {
        $eventId = (int)$params['eventId'];
        $event = Event::findById($eventId);

        if (!$event) {
            $this->json(['error' => 'Event not found'], 404);
            return;
        }

        $this->json($event);
    }
}
