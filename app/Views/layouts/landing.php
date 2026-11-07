<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab — Digital Forensics & Activity Investigation Platform') ?></title>
    
    <!-- Favicon & Brand Marks -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <!-- Comprehensive SEO Meta Tags -->
    <meta name="description" content="<?= \Tracelabs\Core\View::escape($metaDescription ?? 'TraceLab is an open-source forensic detective workbench that normalizes heterogeneous activity logs, reconstructs chronological timeline swimlanes, maps entity relationships, and triages threats with hybrid rules and Isolation Forest ML.') ?>">
    <meta name="keywords" content="<?= \Tracelabs\Core\View::escape($metaKeywords ?? 'digital forensics, log normalization, timeline reconstruction, SIEM, incident response, DFIR, entity linking, anomaly detection, isolation forest, cyber investigation') ?>">
    <meta name="author" content="Dhairya Patel (@dhairya-404)">
    <link rel="canonical" href="https://trace-labs.vercel.app<?= \Tracelabs\Core\View::escape($_SERVER['REQUEST_URI'] ?? '') ?>">

    <!-- OpenGraph Social Sharing Cards (LinkedIn, Facebook, Discord, Slack) -->
    <meta property="og:title" content="<?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab — Digital Activity Forensics & Anomaly Triage') ?>">
    <meta property="og:description" content="<?= \Tracelabs\Core\View::escape($metaDescription ?? 'Ingest messy server logs, calculate SHA-256 digital fingerprints, reconstruct synchronized timelines, and triage anomalies with explainable rules + ML.') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://trace-labs.vercel.app<?= \Tracelabs\Core\View::escape($_SERVER['REQUEST_URI'] ?? '') ?>">
    <meta property="og:site_name" content="TraceLab DFIR">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= \Tracelabs\Core\View::escape($pageTitle ?? 'TraceLab — Digital Activity Forensics & Anomaly Triage') ?>">
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
            background: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(14, 165, 233, 0.15), transparent 75%), linear-gradient(180deg, #070c1a 0%, #030712 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 85px 0 70px;
            position: relative;
        }
        .feature-card {
            background: linear-gradient(180deg, rgba(13, 21, 39, 0.75) 0%, rgba(7, 11, 22, 0.85) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 28px;
            height: 100%;
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .feature-card:hover {
            transform: translateY(-3px);
            border-color: rgba(56, 189, 248, 0.45);
            box-shadow: 0 16px 36px -6px rgba(0, 0, 0, 0.8), 0 0 25px rgba(56, 189, 248, 0.18);
        }
        .stat-box {
            background: rgba(8, 13, 26, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 18px;
            text-align: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        .nav-landing {
            background: rgba(5, 9, 18, 0.85) !important;
            backdrop-filter: blur(18px) !important;
            -webkit-backdrop-filter: blur(18px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* ----------------------------------------------------------------------
           Smooth Scrolling & Top Cyber Telemetry Progress Bar
           ---------------------------------------------------------------------- */
        html {
            scroll-behavior: smooth;
        }

        #scrollProgressBar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 50%, #818cf8 100%);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.8), 0 0 4px #38bdf8;
            z-index: 99999;
            transition: width 0.08s ease-out;
            pointer-events: none;
        }

        /* ----------------------------------------------------------------------
           Hero Entrance Keyframe Animations (Triggered on Landing Entry)
           ---------------------------------------------------------------------- */
        @keyframes heroBadgeFadeIn {
            0% { opacity: 0; transform: translateY(-16px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes heroTitleReveal {
            0% { opacity: 0; transform: translateY(28px); filter: blur(6px); }
            100% { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes heroSubtitleFade {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes heroButtonsPop {
            0% { opacity: 0; transform: translateY(18px) scale(0.97); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes heroCardSlideIn {
            0% { opacity: 0; transform: translateX(45px) translateY(12px) scale(0.95); filter: blur(8px); }
            100% { opacity: 1; transform: translateX(0) translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes swimlaneItemScan {
            0% { opacity: 0; transform: translateX(-24px); filter: brightness(1.6); }
            70% { opacity: 1; transform: translateX(4px); }
            100% { opacity: 1; transform: translateX(0); filter: brightness(1); }
        }

        @keyframes ambientCardPulse {
            0%, 100% { box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.9), 0 0 25px rgba(56, 189, 248, 0.12); }
            50% { box-shadow: 0 24px 50px -8px rgba(0, 0, 0, 0.95), 0 0 40px rgba(56, 189, 248, 0.22); }
        }

        @keyframes beaconBlink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(0.8); }
        }

        /* Hero Animation Utility Classes */
        .anim-hero-badge {
            animation: heroBadgeFadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
        }

        .anim-hero-title {
            animation: heroTitleReveal 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }

        .anim-hero-sub {
            animation: heroSubtitleFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.35s both;
        }

        .anim-hero-cta {
            animation: heroButtonsPop 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
        }

        .anim-hero-bullets {
            animation: heroSubtitleFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.65s both;
        }

        .anim-hero-mockup {
            animation: heroCardSlideIn 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both, ambientCardPulse 6s ease-in-out 1.25s infinite;
        }

        /* Sequential Swimlane Rows In Mockup Desk */
        .swimlane-anim-1 { animation: swimlaneItemScan 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.65s both; }
        .swimlane-anim-2 { animation: swimlaneItemScan 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.85s both; }
        .swimlane-anim-3 { animation: swimlaneItemScan 0.55s cubic-bezier(0.16, 1, 0.3, 1) 1.05s both; }
        .swimlane-anim-4 { animation: swimlaneItemScan 0.55s cubic-bezier(0.16, 1, 0.3, 1) 1.25s both; }

        .anim-beacon {
            animation: beaconBlink 1.8s ease-in-out infinite;
        }

        /* ----------------------------------------------------------------------
           Scroll-Driven Reveal Classes (IntersectionObserver)
           ---------------------------------------------------------------------- */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.94);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-scale.revealed {
            opacity: 1;
            transform: scale(1);
        }

        /* Staggered Delay Helpers */
        .delay-1 { transition-delay: 0.08s; }
        .delay-2 { transition-delay: 0.16s; }
        .delay-3 { transition-delay: 0.24s; }
        .delay-4 { transition-delay: 0.32s; }
        .delay-5 { transition-delay: 0.40s; }
        .delay-6 { transition-delay: 0.48s; }

        /* Accessibility: respect user prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            .anim-hero-badge,
            .anim-hero-title,
            .anim-hero-sub,
            .anim-hero-cta,
            .anim-hero-bullets,
            .anim-hero-mockup,
            .swimlane-anim-1,
            .swimlane-anim-2,
            .swimlane-anim-3,
            .swimlane-anim-4,
            .reveal,
            .reveal-scale {
                opacity: 1 !important;
                transform: none !important;
                animation: none !important;
                transition: none !important;
                filter: none !important;
            }
            #scrollProgressBar {
                display: none !important;
            }
        }
    </style>
</head>
<body class="text-light" style="background-color: var(--bg-page);">
    <!-- Top Telemetry Scroll Progress Indicator -->
    <div id="scrollProgressBar"></div>

    <!-- Top Public Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-landing sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 font-mono" href="/">
                <svg width="28" height="28" viewBox="0 0 64 64" fill="none" class="rounded-2" style="border: 1px solid rgba(56, 189, 248, 0.4); box-shadow: 0 0 10px rgba(56, 189, 248, 0.25);">
                    <rect width="64" height="64" rx="14" fill="#070c18"/>
                    <circle cx="32" cy="32" r="22" stroke="#334155" stroke-width="2" stroke-dasharray="8 6"/>
                    <path d="M 32 16 A 16 16 0 1 1 16 32" stroke="#38bdf8" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="32" cy="32" r="6" fill="#38bdf8"/>
                    <circle cx="32" cy="32" r="3" fill="#ffffff"/>
                    <line x1="32" y1="32" x2="48" y2="16" stroke="#38bdf8" stroke-width="3" stroke-linecap="round"/>
                </svg>
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
                        <svg width="28" height="28" viewBox="0 0 64 64" fill="none" class="rounded-2" style="border: 1px solid rgba(56, 189, 248, 0.4);">
                            <rect width="64" height="64" rx="14" fill="#070c18"/>
                            <circle cx="32" cy="32" r="22" stroke="#334155" stroke-width="2" stroke-dasharray="8 6"/>
                            <path d="M 32 16 A 16 16 0 1 1 16 32" stroke="#38bdf8" stroke-width="4" stroke-linecap="round"/>
                            <circle cx="32" cy="32" r="6" fill="#38bdf8"/>
                            <circle cx="32" cy="32" r="3" fill="#ffffff"/>
                            <line x1="32" y1="32" x2="48" y2="16" stroke="#38bdf8" stroke-width="3" stroke-linecap="round"/>
                        </svg>
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
                    High-Fidelity Forensic Incident Response &bull; Built with Pure PHP 8.3 MVC &bull; scikit-learn ML
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- vis-timeline JS -->
    <script src="https://unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>

    <!-- Smooth Scrolling & Telemetry Scroll Reveals Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Scroll Progress Bar Tracking
        const progressBar = document.getElementById('scrollProgressBar');
        if (progressBar) {
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const scrollTop = window.scrollY || document.documentElement.scrollTop;
                        const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                        if (docHeight > 0) {
                            const pct = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
                            progressBar.style.width = pct + '%';
                        }
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });
        }

        // 2. Hardware-Accelerated IntersectionObserver for Scroll Reveals
        const revealElements = document.querySelectorAll('.reveal, .reveal-scale');
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -40px 0px',
                threshold: 0.08
            };

            const observer = new IntersectionObserver(function(entries, obs) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            revealElements.forEach(function(el) {
                observer.observe(el);
            });
        } else {
            revealElements.forEach(function(el) {
                el.classList.add('revealed');
            });
        }
    });
    </script>
</body>
</html>
