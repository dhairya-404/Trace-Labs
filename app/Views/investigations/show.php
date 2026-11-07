<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-primary text-uppercase font-monospace">Workspace #<?= $investigation['id'] ?></span>
            <h2 class="fw-bold mb-0"><?= \Tracelabs\Core\View::escape($investigation['title']) ?></h2>
        </div>
        <p class="text-secondary small mb-0">Lead Analyst: <strong><?= \Tracelabs\Core\View::escape($investigation['lead_analyst']) ?></strong> &middot; Opened <?= $investigation['created_at'] ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-plus"></i> Import More Logs
        </a>
        <a href="/investigations/<?= $investigation['id'] ?>/report" class="btn btn-primary btn-sm">
            <i class="bi bi-file-earmark-text"></i> Generate Court Report
        </a>
    </div>
</div>

<!-- 5-Step Detective Workflow Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-dark border-secondary h-100 p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold">1. FILES & FINGERPRINTS</span>
                <i class="bi bi-shield-check text-success fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1"><?= count($files) ?></h3>
            <p class="text-secondary small mb-3">All files cryptographically fingerprinted with SHA-256.</p>
            <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-outline-secondary mt-auto">View Ingestion Manifest</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-secondary h-100 p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold">2. UNIFIED TIMELINE</span>
                <i class="bi bi-clock-history text-info fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-info"><?= $totalEvents ?></h3>
            <p class="text-secondary small mb-3">Cleaned chronological events across all uploaded sources.</p>
            <a href="/investigations/<?= $investigation['id'] ?>/timeline" class="btn btn-sm btn-outline-info mt-auto">Open vis-timeline</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-secondary h-100 p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold">3. ENTITY RELATIONSHIPS</span>
                <i class="bi bi-diagram-3 text-warning fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-warning"><?= count($entities) ?></h3>
            <p class="text-secondary small mb-3">Accounts, IPs, and workstations interconnected.</p>
            <a href="/investigations/<?= $investigation['id'] ?>/graph" class="btn btn-sm btn-outline-warning mt-auto">Open Cytoscape.js Graph</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-secondary h-100 p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold">4. ANOMALY FINDINGS</span>
                <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-danger"><?= count($findings) ?></h3>
            <p class="text-secondary small mb-3">Flags from 3 Explainable Rules + Isolation Forest ML.</p>
            <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-sm btn-outline-danger mt-auto">Inspect Findings</a>
        </div>
    </div>
</div>

<!-- Quick Ingested Files Manifest -->
<div class="card bg-dark border-secondary mb-4">
    <div class="card-header bg-black border-secondary d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-binary text-primary me-2"></i>Ingested Evidence Files & Cryptographic Fingerprints</h5>
        <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Ingest File</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($files)): ?>
            <div class="p-4 text-center text-secondary">
                <p class="mb-2">No log files uploaded to this workspace yet.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-outline-primary">Upload CSV / JSON or Load Sample Dataset</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead class="table-black border-secondary font-monospace small">
                        <tr>
                            <th>#</th>
                            <th>Filename</th>
                            <th>Format</th>
                            <th>SHA-256 Digital Fingerprint</th>
                            <th>Events</th>
                            <th>File Size</th>
                            <th>Uploaded</th>
                        </tr>
                    </thead>
                    <tbody class="font-monospace small">
                        <?php foreach ($files as $f): ?>
                            <tr>
                                <td><?= $f['id'] ?></td>
                                <td class="fw-semibold text-light"><?= \Tracelabs\Core\View::escape($f['filename']) ?></td>
                                <td><span class="badge bg-secondary"><?= $f['file_format'] ?></span></td>
                                <td><code class="text-info"><?= $f['sha256_hash'] ?></code></td>
                                <td><span class="badge bg-info text-dark"><?= $f['raw_event_count'] ?></span></td>
                                <td><?= number_format($f['file_size'] / 1024, 1) ?> KB</td>
                                <td class="text-secondary"><?= $f['uploaded_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
