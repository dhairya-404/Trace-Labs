<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab') ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- vis-timeline CSS -->
    <link href="https://unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-dark text-light">

    <!-- Top Forensic Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary-subtle px-3 py-2 sticky-top bg-black">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold tracking-wide text-uppercase" href="/investigations">
                <span class="badge bg-primary text-light font-monospace px-2 py-1"><i class="bi bi-radar"></i> TRACELAB</span>
                <span class="fs-6 text-secondary d-none d-md-inline">// Digital Activity Detective</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <?php if (isset($investigation)): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/import') ? 'active text-primary fw-semibold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/import">
                                <i class="bi bi-file-earmark-arrow-up"></i> 1. Import & Hash
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/timeline') ? 'active text-primary fw-semibold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/timeline">
                                <i class="bi bi-clock-history"></i> 2. Timeline
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/graph') ? 'active text-primary fw-semibold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/graph">
                                <i class="bi bi-diagram-3"></i> 3. Entity Graph
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/detections') ? 'active text-primary fw-semibold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/detections">
                                <i class="bi bi-shield-exclamation"></i> 4. Anomaly Flags
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/report') ? 'active text-primary fw-semibold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/report">
                                <i class="bi bi-file-earmark-text"></i> 5. Final Report
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge border border-info-subtle text-info font-monospace py-1 px-2">
                            <i class="bi bi-folder-check"></i> <?= \Tracelabs\Core\View::escape($investigation['title']) ?>
                        </span>
                        <a href="/investigations" class="btn btn-sm btn-outline-secondary">Switch Workspace</a>
                    </div>
                <?php else: ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="/investigations"><i class="bi bi-collection"></i> Workspaces</a>
                        </li>
                    </ul>
                    <a href="/investigations/create" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> New Investigation</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container-fluid py-4 px-md-4">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="border-top border-secondary-subtle py-3 text-center text-secondary small bg-black mt-5">
        <div class="container d-flex justify-content-between align-items-center">
            <span><strong>TraceLab</strong> &mdash; 6th Semester Capstone Project // Log Normalization & Anomaly Triage</span>
            <span class="badge bg-dark-subtle text-light border border-secondary">PHP MVC &middot; vis-timeline &middot; Cytoscape.js &middot; FastAPI (Isolation Forest)</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- vis-timeline JS -->
    <script src="https://unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
    <!-- Cytoscape JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.28.1/cytoscape.min.js"></script>
</body>
</html>
