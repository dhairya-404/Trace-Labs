<?php
declare(strict_types=1);

namespace Tracelabs\Core;

class View
{
    public static function render(string $template, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        // Capture view content
        $viewPath = __DIR__ . "/../Views/{$template}.php";
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "<h1>Forensic Template Error</h1><p>View file <code>{$template}.php</code> not found.</p>";
            return;
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // If layout specified, wrap in layout
        if ($layout) {
            $layoutPath = __DIR__ . "/../Views/layouts/{$layout}.php";
            if (file_exists($layoutPath)) {
                require $layoutPath;
                return;
            }
        }

        echo $content;
    }

    public static function escape(?string $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}
