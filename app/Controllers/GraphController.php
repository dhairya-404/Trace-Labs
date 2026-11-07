<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\Investigation;
use Tracelabs\Models\Entity;

class GraphController extends Controller
{
    public function show(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $investigation = Investigation::findById($id);

        if (!$investigation) {
            $this->redirect('/investigations');
            return;
        }

        $entities = Entity::getByInvestigation($id);

        $this->view('graph/index', [
            'pageTitle' => "Entity Relationship Graph // {$investigation['title']}",
            'investigation' => $investigation,
            'entities' => $entities
        ]);
    }

    public function data(Request $request, array $params): void
    {
        $id = (int)$params['id'];
        $elements = Entity::getCytoscapeElements($id);
        $this->json($elements);
    }
}
