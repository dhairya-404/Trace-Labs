<?php
declare(strict_types=1);

/**
 * TraceLab Front Controller & HTTP Dispatcher
 * 6th-Semester Degree Capstone Project
 */

// 1. Session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1.1 Direct static asset dispatch for edge & serverless compatibility
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if ($requestPath === '/favicon.svg' || $requestPath === '/favicon.ico') {
    header('Content-Type: image/svg+xml');
    header('Cache-Control: public, max-age=86400');
    if (file_exists(__DIR__ . '/favicon.svg')) {
        readfile(__DIR__ . '/favicon.svg');
        exit;
    }
}
if ($requestPath === '/robots.txt') {
    header('Content-Type: text/plain');
    if (file_exists(__DIR__ . '/robots.txt')) {
        readfile(__DIR__ . '/robots.txt');
        exit;
    }
}
if ($requestPath === '/sitemap.xml') {
    header('Content-Type: application/xml');
    if (file_exists(__DIR__ . '/sitemap.xml')) {
        readfile(__DIR__ . '/sitemap.xml');
        exit;
    }
}

// 2. PSR-4 Class Autoloader for Pure PHP Architecture
spl_autoload_register(function (string $class) {
    $prefix = 'Tracelabs\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Tracelabs\Core\Router;
use Tracelabs\Core\Request;
use Tracelabs\Controllers\AuthController;
use Tracelabs\Controllers\InvestigationController;
use Tracelabs\Controllers\ImportController;
use Tracelabs\Controllers\TimelineController;
use Tracelabs\Controllers\GraphController;
use Tracelabs\Controllers\DetectionController;
use Tracelabs\Controllers\ReportController;
use Tracelabs\Controllers\LandingController;

$router = new Router();
$request = new Request();

// Public SEO & Product Landing Routes
$router->get('/', [LandingController::class, 'index']);
$router->get('/playground', [LandingController::class, 'playground']);
$router->get('/logs', [LandingController::class, 'logsIndex']);
$router->get('/logs/{slug}', [LandingController::class, 'logsShow']);

// Authentication Routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Investigation Workspace Routes
$router->get('/investigations', [InvestigationController::class, 'index']);
$router->get('/investigations/create', [InvestigationController::class, 'create']);
$router->post('/investigations', [InvestigationController::class, 'store']);
$router->get('/investigations/{id}', [InvestigationController::class, 'show']);

// Step 1: Ingestion & SHA-256 Fingerprint
$router->get('/investigations/{id}/import', [ImportController::class, 'show']);
$router->post('/investigations/{id}/import', [ImportController::class, 'upload']);

// Step 2: Unified Chronological Timeline (vis-timeline)
$router->get('/investigations/{id}/timeline', [TimelineController::class, 'show']);
$router->get('/investigations/{id}/timeline/data', [TimelineController::class, 'data']);
$router->get('/investigations/{id}/events/{eventId}', [TimelineController::class, 'eventDetails']);

// Step 3: Entity Relationship Graph (Cytoscape.js)
$router->get('/investigations/{id}/graph', [GraphController::class, 'show']);
$router->get('/investigations/{id}/graph/data', [GraphController::class, 'data']);

// Step 4: Dual Anomaly Detections (3 Rules + Isolation Forest ML)
$router->get('/investigations/{id}/detections', [DetectionController::class, 'show']);
$router->post('/investigations/{id}/detections/rerun', [DetectionController::class, 'rerun']);

// Step 5: Official Report & Provenance Export (PDF / JSON)
$router->get('/investigations/{id}/report', [ReportController::class, 'show']);
$router->get('/investigations/{id}/report/json', [ReportController::class, 'exportJson']);

// Dispatch HTTP request
$router->dispatch($request);
