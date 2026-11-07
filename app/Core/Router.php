<?php
declare(strict_types=1);

namespace Tracelabs\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', trim($path, '/'));
        $regex = '#^/' . ($pattern ? $pattern : '') . '$#';

        $this->routes[] = [
            'method' => $method,
            'path' => '/' . trim($path, '/'),
            'regex' => $regex,
            'handler' => $handler
        ];
    }

    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $uri, $matches)) {
                $params = array_filter($matches, fn($k) => !is_numeric($k), ARRAY_FILTER_USE_KEY);

                if (is_callable($route['handler'])) {
                    call_user_func($route['handler'], $request, $params);
                    return;
                }

                if (is_array($route['handler'])) {
                    [$class, $action] = $route['handler'];
                    if (class_exists($class)) {
                        $controller = new $class();
                        if (method_exists($controller, $action)) {
                            $controller->$action($request, $params);
                            return;
                        }
                    }
                }
            }
        }

        // 404 Handler
        http_response_code(404);
        View::render('errors/404', ['uri' => $uri], 'main');
    }
}
