<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab — Forensic Investigation Desk') ?></title>
    
    <!-- Favicon & Brand Marks -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <!-- Google Fonts: IBM Plex Sans & JetBrains Mono (ui-ux-pro-max design system) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- vis-timeline CSS -->
    <link href="https://unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
    
    <!-- TraceLab Custom Cyber-Forensic Theme (with Cache Buster) -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
</head>
<body>

    <!-- Top Forensic Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-cyber px-3 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2 font-mono text-uppercase" href="/investigations">
                <img src="/favicon.svg" alt="TraceLab Mark" width="24" height="24" class="rounded" style="border: 1px solid rgba(56, 189, 248, 0.4); box-shadow: 0 0 8px rgba(56, 189, 248, 0.25);">
                <span class="text-light fw-bold">TRACELAB</span>
                <span class="badge border border-secondary text-secondary font-mono small py-0 px-1">v1.0</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <?php if (isset($investigation)): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/import') ? 'active text-primary fw-bold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/import">
                                <i class="bi bi-file-earmark-arrow-up"></i> 1. Ingestion & Hash
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/timeline') ? 'active text-primary fw-bold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/timeline">
                                <i class="bi bi-clock-history"></i> 2. Timeline
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/graph') ? 'active text-primary fw-bold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/graph">
                                <i class="bi bi-diagram-3"></i> 3. Entity Graph
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/detections') ? 'active text-primary fw-bold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/detections">
                                <i class="bi bi-shield-exclamation"></i> 4. Anomaly Flags
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/report') ? 'active text-primary fw-bold' : '' ?>" href="/investigations/<?= $investigation['id'] ?>/report">
                                <i class="bi bi-file-earmark-text"></i> 5. Final Report
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-2">
                        <!-- 5-Minute Demo Quick Assistant Modal Trigger -->
                        <button type="button" class="btn btn-sm btn-outline-warning font-mono" data-bs-toggle="modal" data-bs-target="#demoCheatSheetModal">
                            <i class="bi bi-play-circle-fill me-1"></i> Demo Guide
                        </button>
                        <span class="badge border border-info-subtle text-info font-mono py-1 px-2 d-none d-xl-inline">
                            <i class="bi bi-folder-check"></i> <?= \Tracelabs\Core\View::escape($investigation['title']) ?>
                        </span>
                        <a href="/investigations" class="btn btn-sm btn-outline-secondary">Switch</a>
                        <a href="/logout" class="btn btn-sm btn-outline-danger font-mono" title="Lock & Sign Out">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="/investigations"><i class="bi bi-collection"></i> Workspaces</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-warning font-mono" data-bs-toggle="modal" data-bs-target="#demoCheatSheetModal">
                            <i class="bi bi-play-circle-fill me-1"></i> Demo Guide
                        </button>
                        <a href="/investigations/create" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> New Investigation</a>
                        <a href="/logout" class="btn btn-sm btn-outline-danger font-mono" title="Lock & Sign Out">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container-fluid py-4 px-md-4">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="border-top border-secondary-subtle py-3 text-secondary small bg-black mt-5">
        <div class="container-fluid px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><strong>TraceLab</strong> &mdash; 6th Semester Degree Capstone &bull; Activity Log Normalization, Entity-Linking & Anomaly Triage</span>
            <span class="font-mono text-muted small">PHP 8.3 MVC &middot; SQLite &middot; vis-timeline &middot; Cytoscape.js &middot; FastAPI (Isolation Forest)</span>
        </div>
    </footer>

    <!-- Demo Cheat Sheet Modal (Available everywhere in the app!) -->
    <div class="modal fade" id="demoCheatSheetModal" tabindex="-1" aria-labelledby="demoCheatSheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-mono fw-bold" id="demoCheatSheetLabel">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>5-Minute Presentation Demo Walkthrough
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-secondary small mb-3">
                        Use this exact step-by-step script when presenting to your project examiner or classmates:
                    </p>

                    <div class="list-group list-group-flush border border-secondary rounded">
                        <div class="list-group-item bg-dark text-light p-3 border-secondary">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary font-mono">STEP 1</span>
                                <strong>Start an Investigation & Ingest a File</strong>
                            </div>
                            <p class="text-secondary small mb-0">
                                Open the Ingestion page and click one of the <strong>1-Click Demo Scenarios</strong> (e.g. <em>Scenario 1: Brute Force Attack</em>). Point out the <strong>SHA-256 fingerprint</strong> calculated on intake to guarantee evidence immutability.
                            </p>
                        </div>

                        <div class="list-group-item bg-dark text-light p-3 border-secondary">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-info text-dark font-mono">STEP 2</span>
                                <strong>Explore the Unified Chronological Timeline</strong>
                            </div>
                            <p class="text-secondary small mb-0">
                                Click <strong>Timeline</strong>. Show how events from disparate files are unified in time sequence using <code>vis-timeline</code>. Zoom in, pan, and filter by user <code>admin.finance</code>.
                            </p>
                        </div>

                        <div class="list-group-item bg-dark text-light p-3 border-secondary">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning text-dark font-mono">STEP 3</span>
                                <strong>Connect the Dots with the Entity Graph</strong>
                            </div>
                            <p class="text-secondary small mb-0">
                                Click <strong>Entity Graph</strong>. Show the <code>Cytoscape.js</code> topological map. <strong>Click node <code>198.51.100.44</code></strong> to demonstrate interactive entity isolation and connected account tracking.
                            </p>
                        </div>

                        <div class="list-group-item bg-dark text-light p-3 border-secondary">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-danger font-mono">STEP 4</span>
                                <strong>Review Explainable Rules & Machine Learning Scores</strong>
                            </div>
                            <p class="text-secondary small mb-0">
                                Click <strong>Anomaly Flags</strong>. Explain <em>Rule 1 (5 failed logins in 2 minutes)</em>, then show the <strong>Isolation Forest</strong> outlier score. State clearly: <em>"The ML model is an unsupervised triage consultant, not definitive legal proof."</em>
                            </p>
                        </div>

                        <div class="list-group-item bg-dark text-light p-3 border-secondary">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-success font-mono">STEP 5 (THE WOW MOMENT)</span>
                                <strong>Generate the Official Report</strong>
                            </div>
                            <p class="text-secondary small mb-0">
                                Click <strong>Final Report</strong>. Show the complete provenance trail linking:
                                <code>Original File (Line #) &rarr; Normalized Event &rarr; Graph Entity &rarr; Plain-English Reason &rarr; Report</code>.
                                Click <strong>Print / Save as PDF</strong>!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close Guide</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- vis-timeline JS -->
    <script src="https://unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
    <!-- Cytoscape JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.28.1/cytoscape.min.js"></script>
</body>
</html>
