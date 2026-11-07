<div class="row g-4">
    <!-- Left Column: Upload Form & 1-Click Demo Scenarios -->
    <div class="col-lg-7">
        <div class="card p-4 shadow-sm mb-4">
            <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>Step 1: Upload & Fingerprint Raw Activity Logs</h4>
            <p class="text-secondary small mb-4">
                Ingest raw CSV or JSON files (authentication logs, firewall flows, server command access). TraceLab calculates a permanent <strong>SHA-256 digital fingerprint</strong> at the intake boundary, then cleans and standardizes timestamps and disparate column names into a unified event format.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 small" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i> <?= \Tracelabs\Core\View::escape($error) ?>
                </div>
            <?php endif; ?>

            <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="log_file" class="form-label text-secondary small fw-semibold">Select Log File (.csv or .json)</label>
                    <input class="form-control bg-black text-light border-secondary" type="file" id="log_file" name="log_file" accept=".csv,.json">
                    <div class="form-text text-secondary small">Supports any standard server/auth export with timestamp, account, IP, action, and status.</div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cpu me-1"></i> Upload, Hash & Ingest
                    </button>
                    <span class="text-secondary small font-mono"><i class="bi bi-shield-check text-success"></i> SHA-256 Non-Repudiation</span>
                </div>
            </form>
        </div>

        <!-- 4 Pre-Packaged Academic Test Datasets for Examination -->
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-secondary font-mono">DEMO SCENARIOS</span>
                    <h5 class="fw-semibold mb-0 text-light">Pre-Bundled Datasets</h5>
                </div>
                <span class="text-muted small font-mono">Ready to test</span>
            </div>
            <p class="text-secondary small mb-3">
                Select any simulated enterprise security scenario to instantly demonstrate ingestion, normalization, graph linking, and dual anomaly detection:
            </p>

            <div class="row g-3">
                <!-- Scenario 1: Brute Force Attack -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="auth">
                        <button type="submit" class="card bg-black border-secondary w-100 text-start p-3 h-100 hover-border-primary">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="text-light"><i class="bi bi-key-fill text-danger me-1"></i> Scenario 1: Brute Force Attack</strong>
                                <span class="badge bg-secondary font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2">17 records &bull; Remote Authentication</div>
                            <div class="badge bg-danger bg-opacity-25 text-danger font-mono small text-wrap text-start">
                                5 rapid failed logins + success from 198.51.100.44 + admin escalation
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 2: Firewall Flow & Exfil -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="firewall">
                        <button type="submit" class="card bg-black border-secondary w-100 text-start p-3 h-100 hover-border-primary">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="text-light"><i class="bi bi-shield-shaded text-warning me-1"></i> Scenario 2: Firewall Flow & Exfil</strong>
                                <span class="badge bg-secondary font-mono">JSON</span>
                            </div>
                            <div class="text-secondary small mb-2">6 records &bull; Network Traffic Flow</div>
                            <div class="badge bg-warning bg-opacity-25 text-warning font-mono small text-wrap text-start">
                                SSL VPN handshake + 4.8 GB outbound egress + VSS shadow copy purge
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 3: Insider Threat -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="insider">
                        <button type="submit" class="card bg-black border-secondary w-100 text-start p-3 h-100 hover-border-primary">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="text-light"><i class="bi bi-person-x-fill text-info me-1"></i> Scenario 3: Insider Threat</strong>
                                <span class="badge bg-secondary font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2">8 records &bull; Midnight Git/S3 Theft</div>
                            <div class="badge bg-info bg-opacity-25 text-info font-mono small text-wrap text-start">
                                Resigning engineer syncing token archives to personal S3 at 11:45 PM
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 4: Clean Baseline Normal Day -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="baseline">
                        <button type="submit" class="card bg-black border-secondary w-100 text-start p-3 h-100 hover-border-primary">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="text-light"><i class="bi bi-check2-circle text-success me-1"></i> Scenario 4: Clean Normal Day</strong>
                                <span class="badge bg-secondary font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2">11 records &bull; Standard 9-5 Working Day</div>
                            <div class="badge bg-success bg-opacity-25 text-success font-mono small text-wrap text-start">
                                Tests false positive resilience &bull; Clean normal activity with 0 flags
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Evidence Fingerprint Manifest -->
    <div class="col-lg-5">
        <div class="card h-100 shadow-sm">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 font-mono"><i class="bi bi-fingerprint text-info me-2"></i>Evidence Fingerprint Manifest</h5>
                <span class="badge bg-dark border border-secondary"><?= count($files) ?> Stored</span>
            </div>
            <div class="card-body p-3">
                <p class="text-secondary small mb-3">
                    Calculated cryptographic hash guarantees original log file immutability and judicial non-repudiation.
                </p>

                <?php if (empty($files)): ?>
                    <div class="p-5 text-center text-secondary border border-secondary border-dashed rounded">
                        <i class="bi bi-file-earmark-lock display-5 d-block mb-3 text-secondary"></i>
                        No files in evidence ledger yet.<br>Click any of the 4 demo scenarios on the left to start!
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($files as $f): ?>
                            <div class="p-3 bg-black rounded border border-secondary">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-light font-mono"><?= \Tracelabs\Core\View::escape($f['filename']) ?></strong>
                                    <span class="badge bg-secondary font-mono"><?= $f['file_format'] ?></span>
                                </div>
                                <div class="text-secondary small mb-2">
                                    <span><?= number_format($f['file_size'] / 1024, 1) ?> KB</span> &bull; 
                                    <span class="text-info"><?= $f['raw_event_count'] ?> records</span> &bull;
                                    <span><?= $f['uploaded_at'] ?></span>
                                </div>
                                <div class="small text-secondary mb-1">SHA-256 Fingerprint:</div>
                                <div class="p-2 bg-dark rounded font-mono small text-primary text-break border border-secondary">
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
