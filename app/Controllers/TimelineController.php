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
            'pageTitle' => "Timeline Reconstruction // {$investigation['title']}",
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
        $this->json($items);
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
