<div class="container py-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4 font-mono small">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="/logs" class="text-secondary text-decoration-none">SIEM Directory</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page"><?= \Tracelabs\Core\View::escape($article['title']) ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Main Article Content -->
        <div class="col-lg-8">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 border border-primary border-opacity-50 font-mono small" style="background: rgba(37, 99, 235, 0.1);">
                <i class="bi bi-shield-check text-primary"></i>
                <span class="text-info"><?= \Tracelabs\Core\View::escape($article['category']) ?></span>
            </div>
            
            <h1 class="display-5 fw-bold text-light mb-3 font-sans"><?= \Tracelabs\Core\View::escape($article['title']) ?></h1>
            <p class="lead text-secondary mb-4 font-sans"><?= \Tracelabs\Core\View::escape($article['description']) ?></p>

            <div class="card bg-black border-secondary p-3 mb-4 font-mono small">
                <div class="text-secondary mb-1">Standard Schema Header &amp; Canonical Fields:</div>
                <code class="text-info text-break"><?= \Tracelabs\Core\View::escape($article['schema']) ?></code>
            </div>

            <!-- Deep Technical Analysis -->
            <h3 class="fw-bold text-light font-sans mt-4 mb-3">1. Technical Log Anatomy &amp; Key Threat Fields</h3>
            <p class="text-secondary font-sans leading-relaxed">
                <?= $article['anatomy'] ?>
            </p>

            <!-- Sample Attack Snippet -->
            <h3 class="fw-bold text-light font-sans mt-5 mb-3">2. Raw Attack Log Snippet</h3>
            <div class="card bg-black border-secondary p-3 mb-4">
                <pre class="font-mono small text-light mb-0" style="overflow-x: auto;"><?= \Tracelabs\Core\View::escape($article['sample_snippet']) ?></pre>
            </div>

            <!-- Timeline Reconstruction Pattern -->
            <h3 class="fw-bold text-light font-sans mt-5 mb-3">3. How TraceLab Visualizes This Incursion</h3>
            <p class="text-secondary font-sans leading-relaxed">
                When ingested into TraceLab, these disparate records receive a calculated <strong>SHA-256 fingerprint</strong> for legal chain-of-custody preservation. The events are then mapped into the <strong><?= \Tracelabs\Core\View::escape($article['target_swimlane']) ?></strong> swimlane on the chronological timeline, while accounts and source IPs are instantly linked on the <strong>Cytoscape.js Entity Graph</strong>.
            </p>

            <!-- Interactive CTA Card -->
            <div class="card p-4 my-5 border-primary border-opacity-50 shadow" style="background: #0d1527;">
                <h4 class="fw-bold text-light font-sans mb-2">Test This Log Format in the TraceLab Playground</h4>
                <p class="text-secondary small font-sans mb-3">
                    Copy the snippet above and paste it directly into our client-side playground to see real-time SHA-256 fingerprinting and timeline swimlanes.
                </p>
                <div>
                    <a href="/playground" class="btn btn-warning font-mono fw-bold text-dark px-3 me-2">
                        <i class="bi bi-play-circle-fill me-1"></i> Open in Live Playground
                    </a>
                    <a href="/login" class="btn btn-outline-primary font-mono px-3">
                        Launch Full Investigation Desk &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Sidebar (Metadata & Related Guides) -->
        <div class="col-lg-4">
            <div class="card bg-black border-secondary p-4 mb-4">
                <h5 class="fw-bold text-light font-sans mb-3 border-bottom border-secondary border-opacity-50 pb-2">Log Quick Facts</h5>
                <ul class="list-unstyled font-mono small text-secondary d-flex flex-column gap-2 mb-0">
                    <li><strong class="text-light">Source:</strong> <?= \Tracelabs\Core\View::escape($article['source']) ?></li>
                    <li><strong class="text-light">Format:</strong> <?= \Tracelabs\Core\View::escape($article['format']) ?></li>
                    <li><strong class="text-light">Swimlane:</strong> <?= \Tracelabs\Core\View::escape($article['target_swimlane']) ?></li>
                    <li><strong class="text-light">Triage Rule:</strong> <?= \Tracelabs\Core\View::escape($article['triage_rule']) ?></li>
                    <li><strong class="text-light">ML Metric:</strong> Volumetric + Time Outlier</li>
                </ul>
            </div>

            <div class="card bg-black border-secondary p-4">
                <h5 class="fw-bold text-light font-sans mb-3 border-bottom border-secondary border-opacity-50 pb-2">More SIEM Guides</h5>
                <ul class="list-unstyled font-mono small d-flex flex-column gap-3 mb-0">
                    <li><a href="/logs/windows-event-4624-logon-analyzer" class="text-info text-decoration-none">Windows Event 4624/4625 &rarr;</a></li>
                    <li><a href="/logs/palo-alto-traffic-exfiltration-timeline" class="text-warning text-decoration-none">Palo Alto Egress Exfiltration &rarr;</a></li>
                    <li><a href="/logs/ssh-auth-log-brute-force-visualizer" class="text-danger text-decoration-none">Linux SSH Brute-Force Triage &rarr;</a></li>
                    <li><a href="/logs/apache-access-log-analyzer" class="text-info text-decoration-none">Apache &amp; Nginx Access Logs &rarr;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
