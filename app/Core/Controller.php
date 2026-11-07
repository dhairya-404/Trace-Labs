<?php
declare(strict_types=1);

namespace Tracelabs\Core;

use Tracelabs\Models\AuditModel;

abstract class Controller
{
    protected function view(string $template, array $data = [], string $layout = 'main'): void
    {
        View::render($template, $data, $layout);
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        Response::json($data, $statusCode);
    }

    protected function redirect(string $url): void
    {
        Response::redirect($url);
    }

    protected function audit(string $action, string $entityType, ?int $entityId, string $actor = 'Lead Analyst', array $details = []): void
    {
        AuditModel::record([
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'actor' => $actor,
            'details' => json_encode($details, JSON_UNESCAPED_SLASHES),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);
    }
}
