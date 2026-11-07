<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge border border-info border-opacity-40 bg-info bg-opacity-10 text-info font-mono">
                #INV-<?= str_pad((string)$investigation['id'], 3, '0', STR_PAD_LEFT) ?>
            </span>
            <span class="text-secondary small font-mono">&bull; Forensic Incident Dossier</span>
        </div>
        <h2 class="fw-bold mb-1 font-sans text-light"><?= \Tracelabs\Core\View::escape($investigation['title']) ?></h2>
        <div class="d-flex align-items-center gap-3 text-secondary small font-mono">
            <span><i class="bi bi-person-badge text-info me-1"></i> Lead Analyst: <strong class="text-light"><?= \Tracelabs\Core\View::escape($investigation['lead_analyst']) ?></strong></span>
            <span>&bull;</span>
            <span><i class="bi bi-clock-history me-1"></i> Initialized <?= $investigation['created_at'] ?></span>
            <span>&bull;</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle font-mono py-0 px-2">EVIDENCE LOCKED</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> Import More Logs
        </a>
        <a href="/investigations/<?= $investigation['id'] ?>/report" class="btn btn-cyber-primary btn-sm">
            <i class="bi bi-file-earmark-text me-1"></i> Generate Court Report
        </a>
    </div>
</div>

<!-- 4 Tactical Detective Workflow Tiles -->
<div class="row g-3 mb-4">
    <!-- Step 1: Files & Fingerprints -->
    <div class="col-md-6 col-xl-3">
        <div class="card hover-card-elevate h-100 p-3 d-flex flex-column" style="border-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge border border-secondary border-opacity-40 text-muted font-mono" style="font-size: 0.68rem;">01 // FINGERPRINTS</span>
                <i class="bi bi-shield-check text-success fs-5"></i>
            </div>
            <div class="fs-2 fw-bold text-light font-mono mb-1"><?= count($files) ?></div>
            <p class="text-secondary small mb-3 font-sans" style="line-height: 1.4;">
                Ingested log manifests cryptographically fingerprinted with SHA-256 for non-repudiation.
            </p>
            <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-xs btn-outline-secondary font-mono mt-auto w-100">
                View Manifest &rarr;
            </a>
        </div>
    </div>

    <!-- Step 2: Unified Timeline -->
    <div class="col-md-6 col-xl-3">
        <div class="card hover-card-elevate h-100 p-3 d-flex flex-column" style="border-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge border border-info border-opacity-40 text-info font-mono" style="font-size: 0.68rem;">02 // UNIFIED TIMELINE</span>
                <i class="bi bi-clock-history text-info fs-5"></i>
            </div>
            <div class="fs-2 fw-bold text-info font-mono mb-1"><?= number_format($totalEvents) ?></div>
            <p class="text-secondary small mb-3 font-sans" style="line-height: 1.4;">
                Synchronized millisecond-accurate timeline across all disparate auth, firewall and server streams.
            </p>
            <a href="/investigations/<?= $investigation['id'] ?>/timeline" class="btn btn-xs btn-outline-info font-mono mt-auto w-100">
                Open vis-timeline &rarr;
            </a>
        </div>
    </div>

    <!-- Step 3: Entity Relationships -->
    <div class="col-md-6 col-xl-3">
        <div class="card hover-card-elevate h-100 p-3 d-flex flex-column" style="border-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge border border-warning border-opacity-40 text-warning font-mono" style="font-size: 0.68rem;">03 // ENTITY TOPOLOGY</span>
                <i class="bi bi-diagram-3 text-warning fs-5"></i>
            </div>
            <div class="fs-2 fw-bold text-warning font-mono mb-1"><?= count($entities) ?></div>
            <p class="text-secondary small mb-3 font-sans" style="line-height: 1.4;">
                Topological graph interconnecting accounts, IP addresses, domains, and internal endpoints.
            </p>
            <a href="/investigations/<?= $investigation['id'] ?>/graph" class="btn btn-xs btn-outline-warning font-mono mt-auto w-100">
                Explore Cytoscape &rarr;
            </a>
        </div>
    </div>

    <!-- Step 4: Anomaly Findings -->
    <div class="col-md-6 col-xl-3">
        <div class="card hover-card-elevate h-100 p-3 d-flex flex-column" style="border-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge border border-danger border-opacity-40 text-danger font-mono" style="font-size: 0.68rem;">04 // ANOMALY LEADS</span>
                <i class="bi bi-shield-exclamation text-danger fs-5"></i>
            </div>
            <div class="fs-2 fw-bold text-danger font-mono mb-1"><?= count($findings) ?></div>
            <p class="text-secondary small mb-3 font-sans" style="line-height: 1.4;">
                Flags from 3 deterministic rules fused with scikit-learn Isolation Forest unsupervised ML.
            </p>
            <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-xs btn-outline-danger font-mono mt-auto w-100">
                Inspect Findings &rarr;
            </a>
        </div>
    </div>
</div>

<!-- Ingested Evidence Files Manifest Table -->
<div class="card shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header d-flex justify-content-between align-items-center py-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge border border-secondary text-secondary font-mono">EVIDENCE MANIFEST</span>
            <h5 class="fw-bold mb-0 text-light font-sans">Cryptographic Ingestion Ledger &amp; SHA-256 Hashes</h5>
        </div>
        <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-cyber-primary">
            <i class="bi bi-plus-lg me-1"></i> Ingest New Log File
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($files)): ?>
            <div class="p-5 text-center text-secondary">
                <i class="bi bi-file-earmark-arrow-up display-5 d-block mb-3 text-muted"></i>
                <h5 class="text-light font-sans">No Evidence Files Ingested Yet</h5>
                <p class="small text-secondary mb-3">Upload your raw CSV or JSON files or select from our pre-packaged incident scenarios.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-cyber-primary">Go to Ingestion Desk</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-cyber mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Evidence File</th>
                            <th>Format</th>
                            <th>SHA-256 Provenance Fingerprint</th>
                            <th>Events</th>
                            <th>File Size</th>
                            <th>Ingested At</th>
                        </tr>
                    </thead>
                    <tbody class="font-mono small">
                        <?php foreach ($files as $f): ?>
                            <tr>
                                <td class="text-muted"><?= $f['id'] ?></td>
                                <td class="fw-semibold text-light">
                                    <i class="bi bi-file-earmark-binary text-info me-1"></i>
                                    <?= \Tracelabs\Core\View::escape($f['filename']) ?>
                                </td>
                                <td>
                                    <span class="badge border border-secondary border-opacity-40 text-secondary bg-dark">
                                        <?= $f['file_format'] ?>
                                    </span>
                                </td>
                                <td>
                                    <code class="text-info" style="font-size: 0.8rem; background: rgba(56, 189, 248, 0.08); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(56, 189, 248, 0.2);">
                                        <?= $f['sha256_hash'] ?>
                                    </code>
                                </td>
                                <td>
                                    <span class="badge border border-info border-opacity-30 bg-info bg-opacity-10 text-info">
                                        <?= number_format($f['raw_event_count']) ?> records
                                    </span>
                                </td>
                                <td class="text-secondary"><?= number_format($f['file_size'] / 1024, 1) ?> KB</td>
                                <td class="text-muted"><?= $f['uploaded_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
