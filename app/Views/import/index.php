<div class="row g-4">
    <div class="col-lg-7">
        <div class="card bg-dark border-secondary p-4 shadow-sm mb-4">
            <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>Step 1: Upload & Fingerprint Raw Log Files</h4>
            <p class="text-secondary small mb-4">
                Upload raw CSV or JSON files (e.g. authentication logs, firewall traffic, server access). TraceLab will validate structure, calculate a permanent SHA-256 digital fingerprint, and normalize timestamps and field names into a unified event format.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 small" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i> <?= \Tracelabs\Core\View::escape($error) ?>
                </div>
            <?php endif; ?>

            <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="log_file" class="form-label text-secondary small">Choose Log File (CSV or JSON)</label>
                    <input class="form-control bg-black text-light border-secondary" type="file" id="log_file" name="log_file" accept=".csv,.json">
                    <div class="form-text text-secondary small">Accepted formats: .csv, .json with timestamp, user/account, IP, action, status.</div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cpu me-1"></i> Upload, Hash & Normalize
                    </button>
                    <span class="text-secondary small"><i class="bi bi-shield-check"></i> SHA-256 Verified On Ingestion</span>
                </div>
            </form>
        </div>

        <!-- 1-Click Academic Demo Datasets (Essential for the 5-Minute Demo!) -->
        <div class="card bg-dark border-primary border-opacity-50 p-4 shadow-sm">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary">5-MINUTE DEMO SHORTCUT</span>
                <h5 class="fw-bold mb-0 text-light">Pre-Packaged Academic Test Datasets</h5>
            </div>
            <p class="text-secondary small mb-3">
                For examiner demonstration and grading, load realistic simulated enterprise security datasets with pre-injected anomalous attack vectors:
            </p>

            <div class="row g-2">
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="auth">
                        <button type="submit" class="btn btn-outline-info w-100 text-start p-3 h-100">
                            <div class="fw-bold text-light mb-1"><i class="bi bi-key me-1"></i> Scenario Alpha: Auth Logs</div>
                            <div class="small text-secondary mb-2">CSV format &bull; 17 normalized events</div>
                            <div class="badge bg-danger-subtle text-danger">Contains: 5 rapid failed logins + success brute-force + off-hours admin escalation</div>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="firewall">
                        <button type="submit" class="btn btn-outline-warning w-100 text-start p-3 h-100">
                            <div class="fw-bold text-light mb-1"><i class="bi bi-shield-shaded me-1"></i> Scenario Beta: Firewall Flows</div>
                            <div class="small text-secondary mb-2">JSON format &bull; 6 normalized events</div>
                            <div class="badge bg-warning-subtle text-warning">Contains: Inbound SSL VPN handshake + 4.8GB outbound exfiltration + shadow copy purge</div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Ingestion Ledger & Fingerprint Manifest -->
    <div class="col-lg-5">
        <div class="card bg-dark border-secondary h-100 shadow-sm">
            <div class="card-header bg-black border-secondary py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-fingerprint text-info me-2"></i>Evidence Fingerprint Manifest</h5>
            </div>
            <div class="card-body p-3">
                <p class="text-secondary small mb-3">
                    Calculated cryptographic hash guarantees original log file immutability and non-repudiation.
                </p>

                <?php if (empty($files)): ?>
                    <div class="p-4 text-center text-secondary border border-secondary border-dashed rounded">
                        <i class="bi bi-file-earmark-lock display-6 d-block mb-2"></i>
                        No files in evidence ledger yet.<br>Upload a file or click one of the demo datasets.
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($files as $f): ?>
                            <div class="p-3 bg-black rounded border border-secondary">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-light"><?= \Tracelabs\Core\View::escape($f['filename']) ?></strong>
                                    <span class="badge bg-secondary"><?= $f['file_format'] ?></span>
                                </div>
                                <div class="text-secondary small mb-2">
                                    <span><?= number_format($f['file_size'] / 1024, 1) ?> KB</span> &bull; 
                                    <span class="text-info"><?= $f['raw_event_count'] ?> records</span> &bull;
                                    <span><?= $f['uploaded_at'] ?></span>
                                </div>
                                <div class="small text-secondary mb-1">SHA-256 Fingerprint:</div>
                                <div class="p-2 bg-dark rounded font-monospace small text-primary text-break border border-secondary">
                                    <?= $f['sha256_hash'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
