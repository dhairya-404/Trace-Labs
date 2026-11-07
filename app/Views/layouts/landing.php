<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab // Digital Activity Log Normalization, Timeline Reconstruction & Anomaly Triage') ?></title>
    
    <!-- Comprehensive SEO Meta Tags -->
    <meta name="description" content="<?= \Tracelabs\Core\View::escape($metaDescription ?? 'TraceLab is an open-source forensic detective workbench that normalizes heterogeneous activity logs, reconstructs chronological timeline swimlanes, maps entity relationships, and triages threats with hybrid rules and Isolation Forest ML.') ?>">
    <meta name="keywords" content="<?= \Tracelabs\Core\View::escape($metaKeywords ?? 'digital forensics, log normalization, timeline reconstruction, SIEM, incident response, DFIR, entity linking, anomaly detection, isolation forest, cyber investigation') ?>">
    <meta name="author" content="Dhairya Patel (@dhairya-404)">
    <link rel="canonical" href="https://trace-labs.vercel.app<?= \Tracelabs\Core\View::escape($_SERVER['REQUEST_URI'] ?? '') ?>">

    <!-- OpenGraph Social Sharing Cards (LinkedIn, Facebook, Discord, Slack) -->
    <meta property="og:title" content="<?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab // Digital Activity Forensics & Anomaly Triage') ?>">
    <meta property="og:description" content="<?= \Tracelabs\Core\View::escape($metaDescription ?? 'Ingest messy server logs, calculate SHA-256 digital fingerprints, reconstruct synchronized timelines, and triage anomalies with explainable rules + ML.') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://trace-labs.vercel.app<?= \Tracelabs\Core\View::escape($_SERVER['REQUEST_URI'] ?? '') ?>">
    <meta property="og:site_name" content="TraceLab DFIR">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab // Digital Activity Forensics & Anomaly Triage') ?>">
    <meta name="twitter:description" content="<?= \Tracelabs\Core\View::escape($metaDescription ?? 'The detective desk for digital event logs: timeline reconstruction, entity graphs, and dual-engine anomaly triage.') ?>">

    <!-- Schema.org JSON-LD Structured Data for Google Rich Snippets -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "TraceLab",
      "operatingSystem": "All (Web-based)",
      "applicationCategory": "SecurityApplication",
      "description": "Digital Activity Log Normalization, Timeline Reconstruction, Entity Linking, and Dual-Engine Anomaly Detection Workbench.",
      "url": "https://trace-labs.vercel.app",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      },
      "author": {
        "@type": "Person",
        "name": "Dhairya Patel"
      }
    }
    </script>

    <!-- Google Fonts: IBM Plex Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- vis-timeline CSS -->
    <link href="https://unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />

    <!-- TraceLab Custom Theme with Cache Buster -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">

    <style>
        .landing-hero {
            background-color: #080c14;
            border-bottom: 1px solid #1f2937;
            padding: 70px 0 60px;
        }
        .feature-card {
            background-color: #111827;
            border: 1px solid #1f2937;
            border-radius: 10px;
            padding: 24px;
            height: 100%;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }
        .feature-card:hover {
            transform: translateY(-2px);
            border-color: #3b82f6;
        }
        .stat-box {
            background-color: #090e17;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }
        .nav-landing {
            background-color: #0b0f19;
            border-bottom: 1px solid #1f2937;
        }
    </style>
</head>
<body class="bg-dark text-light">

    <!-- Top Public Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-landing sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 font-mono" href="/">
                <i class="bi bi-radar text-info fs-4"></i>
                <span class="fw-bold tracking-wide text-light">TRACELAB</span>
                <span class="badge border border-secondary text-secondary font-mono small py-0 px-1">v1.0</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="landingNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2 font-mono small">
                    <li class="nav-item">
                        <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/#features') ? 'text-primary' : '' ?>" href="/#features">
                            <i class="bi bi-grid-1x2 me-1"></i> Capabilities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/playground') ? 'active text-primary fw-bold' : '' ?>" href="/playground">
                            <i class="bi bi-play-circle-fill text-warning me-1"></i> Live Playground
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/logs') ? 'active text-primary fw-bold' : '' ?>" href="/logs">
                            <i class="bi bi-file-earmark-code me-1"></i> SIEM Directory
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#pricing">
                            <i class="bi bi-tag me-1"></i> Editions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/dhairya-404/Trace-Labs" target="_blank" rel="noopener">
                            <i class="bi bi-github me-1"></i> GitHub
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/investigations" class="btn btn-primary btn-sm font-mono px-3">
                            <i class="bi bi-folder2-open me-1"></i> Open Investigation Desk &rarr;
                        </a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-secondary btn-sm font-mono px-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Analyst Sign In
                        </a>
                        <a href="/investigations" class="btn btn-primary btn-sm font-mono px-3">
                            <span>Launch Desk</span> <i class="bi bi-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Injection -->
    <main>
        <?= $content ?>
    </main>

    <!-- Enterprise Footer -->
    <footer class="border-top border-secondary border-opacity-25 py-5 mt-5 bg-black">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 font-mono mb-2">
                        <i class="bi bi-radar text-info fs-4"></i>
                        <span class="fw-bold fs-5 text-light">TRACELAB</span>
                    </div>
                    <p class="text-secondary small mb-3" style="max-width: 420px;">
                        An open-source investigative platform for digital activity log normalization, chronological timeline reconstruction, entity linking, and dual-engine anomaly triage.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="https://github.com/dhairya-404/Trace-Labs" target="_blank" rel="noopener" class="btn btn-xs btn-outline-secondary font-mono">
                            <i class="bi bi-star me-1 text-warning"></i> Star on GitHub
                        </a>
                        <a href="/playground" class="btn btn-xs btn-outline-warning font-mono">
                            <i class="bi bi-play-circle me-1"></i> Try Playground
                        </a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-light font-mono small fw-bold text-uppercase mb-3">Product</h6>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-0 font-mono">
                        <li><a href="/playground" class="text-secondary text-decoration-none hover-text-light">Live Playground</a></li>
                        <li><a href="/#features" class="text-secondary text-decoration-none hover-text-light">Dual Anomaly Engine</a></li>
                        <li><a href="/#features" class="text-secondary text-decoration-none hover-text-light">Entity Graph</a></li>
                        <li><a href="/#pricing" class="text-secondary text-decoration-none hover-text-light">Editions & SaaS</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h6 class="text-light font-mono small fw-bold text-uppercase mb-3">SIEM Directory</h6>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-0 font-mono">
                        <li><a href="/logs/windows-event-4624-logon-analyzer" class="text-secondary text-decoration-none hover-text-light">Windows Event 4624</a></li>
                        <li><a href="/logs/palo-alto-traffic-exfiltration-timeline" class="text-secondary text-decoration-none hover-text-light">Palo Alto Exfiltration</a></li>
                        <li><a href="/logs/ssh-auth-log-brute-force-visualizer" class="text-secondary text-decoration-none hover-text-light">SSH Brute Force</a></li>
                        <li><a href="/logs/apache-access-log-analyzer" class="text-secondary text-decoration-none hover-text-light">Apache Web Access</a></li>
                    </ul>
                </div>

                <div class="col-lg-2">
                    <h6 class="text-light font-mono small fw-bold text-uppercase mb-3">Security & Legal</h6>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-0 font-mono">
                        <li><span class="text-muted">MIT License</span></li>
                        <li><span class="text-muted">SHA-256 Provenance</span></li>
                        <li><span class="text-muted">Zero-Trust Ready</span></li>
                        <li><span class="text-muted">SOC2 Roadmap</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-secondary border-opacity-25 pt-4 d-flex justify-content-between align-items-center flex-wrap gap-2 small text-secondary font-mono">
                <div>
                    &copy; 2026 <strong>TraceLab</strong> &mdash; Maintained by <a href="https://github.com/dhairya-404" target="_blank" rel="noopener" class="text-info text-decoration-none">Dhairya Patel</a>.
                </div>
                <div>
                    6th-Semester Degree Capstone Project &bull; Built with Pure PHP 8.3 MVC &bull; Python ML
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- vis-timeline JS -->
    <script src="https://unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
</body>
</html>
