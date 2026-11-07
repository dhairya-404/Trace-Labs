<div class="row g-4">
    <!-- Left Column: Upload Form & 1-Click Demo Scenarios -->
    <div class="col-lg-7">
        <div class="card p-4 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge border border-info border-opacity-40 bg-info bg-opacity-10 text-info font-mono">STEP 01</span>
                <span class="text-secondary small font-mono">&bull; Evidence Intake Boundary</span>
            </div>
            <h4 class="fw-bold mb-1 text-light font-sans"><i class="bi bi-file-earmark-arrow-up text-info me-2"></i>Upload &amp; Fingerprint Raw Activity Logs</h4>
            <p class="text-secondary small mb-4 font-sans">
                Ingest raw CSV or JSON files (authentication logs, perimeter firewall flows, cloud audit trails). TraceLab computes a cryptographic <strong>SHA-256 digital fingerprint</strong> at the intake boundary, normalizes disparate timestamp formats, and extracts security entities.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                    <span><?= \Tracelabs\Core\View::escape($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="log_file" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.74rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Select Evidence File (.csv or .json)
                    </label>
                    <input class="form-control form-control-cyber" type="file" id="log_file" name="log_file" accept=".csv,.json">
                    <div class="form-text text-muted font-mono small mt-2" style="font-size: 0.72rem;">
                        <i class="bi bi-info-circle me-1"></i> Supports CSV and JSON feeds with timestamp, account, IP, action, and status fields.
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25 flex-wrap gap-2">
                    <button type="submit" class="btn btn-cyber-primary px-4">
                        <i class="bi bi-cpu me-1"></i> Upload, Hash &amp; Ingest
                    </button>
                    <span class="text-secondary small font-mono">
                        <i class="bi bi-shield-check text-success me-1"></i> SHA-256 Non-Repudiation
                    </span>
                </div>
            </form>
        </div>

        <!-- 4 Pre-Packaged Incident Scenarios -->
        <div class="card p-4 mb-4" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge border border-secondary text-secondary font-mono">INCIDENT SCENARIOS</span>
                    <h5 class="fw-bold mb-0 text-light font-sans">Pre-Bundled Forensic Datasets</h5>
                </div>
                <span class="text-muted small font-mono"><i class="bi bi-lightning-charge text-warning me-1"></i>1-Click Ingestion</span>
            </div>
            <p class="text-secondary small mb-3 font-sans">
                Select any simulated enterprise security scenario to instantly demonstrate cryptographic intake, timeline synchronization, entity graph linking, and dual anomaly detection:
            </p>

            <div class="row g-3">
                <!-- Scenario 1: Brute Force Attack -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="auth">
                        <button type="submit" class="card hover-card-elevate w-100 text-start p-3 h-100" style="border: 1px solid rgba(239, 68, 68, 0.3) !important; background: #080d1a !important; cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong class="text-light font-sans"><i class="bi bi-key-fill text-danger me-1"></i> Scenario 1: Brute Force</strong>
                                <span class="badge border border-danger border-opacity-40 text-danger bg-danger bg-opacity-10 font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2 font-mono" style="font-size: 0.72rem;">17 records &bull; Remote Authentication</div>
                            <div class="badge border border-danger border-opacity-30 text-danger font-mono small text-wrap text-start w-100 py-2" style="background: rgba(239, 68, 68, 0.08); font-size: 0.7rem; line-height: 1.4;">
                                5 rapid failed logins + success from 198.51.100.44 + admin privilege escalation
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 2: Firewall Flow & Exfil -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="firewall">
                        <button type="submit" class="card hover-card-elevate w-100 text-start p-3 h-100" style="border: 1px solid rgba(245, 158, 11, 0.3) !important; background: #080d1a !important; cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong class="text-light font-sans"><i class="bi bi-shield-shaded text-warning me-1"></i> Scenario 2: Network Exfil</strong>
                                <span class="badge border border-warning border-opacity-40 text-warning bg-warning bg-opacity-10 font-mono">JSON</span>
                            </div>
                            <div class="text-secondary small mb-2 font-mono" style="font-size: 0.72rem;">6 records &bull; Network Perimeter Flows</div>
                            <div class="badge border border-warning border-opacity-30 text-warning font-mono small text-wrap text-start w-100 py-2" style="background: rgba(245, 158, 11, 0.08); font-size: 0.7rem; line-height: 1.4;">
                                SSL VPN handshake + 4.8 GB outbound egress + VSS shadow copy purge
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 3: Insider Threat -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="insider">
                        <button type="submit" class="card hover-card-elevate w-100 text-start p-3 h-100" style="border: 1px solid rgba(56, 189, 248, 0.3) !important; background: #080d1a !important; cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong class="text-light font-sans"><i class="bi bi-person-x-fill text-info me-1"></i> Scenario 3: Insider Threat</strong>
                                <span class="badge border border-info border-opacity-40 text-info bg-info bg-opacity-10 font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2 font-mono" style="font-size: 0.72rem;">8 records &bull; Midnight Data Access</div>
                            <div class="badge border border-info border-opacity-30 text-info font-mono small text-wrap text-start w-100 py-2" style="background: rgba(56, 189, 248, 0.08); font-size: 0.7rem; line-height: 1.4;">
                                Resigning engineer syncing token archives to unauthorized S3 bucket at 11:45 PM
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Scenario 4: Clean Normal Day -->
                <div class="col-md-6">
                    <form action="/investigations/<?= $investigation['id'] ?>/import" method="POST">
                        <input type="hidden" name="sample_dataset" value="baseline">
                        <button type="submit" class="card hover-card-elevate w-100 text-start p-3 h-100" style="border: 1px solid rgba(16, 185, 129, 0.3) !important; background: #080d1a !important; cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong class="text-light font-sans"><i class="bi bi-check2-circle text-success me-1"></i> Scenario 4: Clean Baseline</strong>
                                <span class="badge border border-success border-opacity-40 text-success bg-success bg-opacity-10 font-mono">CSV</span>
                            </div>
                            <div class="text-secondary small mb-2 font-mono" style="font-size: 0.72rem;">11 records &bull; Standard 9-5 Working Day</div>
                            <div class="badge border border-success border-opacity-30 text-success font-mono small text-wrap text-start w-100 py-2" style="background: rgba(16, 185, 129, 0.08); font-size: 0.7rem; line-height: 1.4;">
                                Validates false-positive resilience &bull; Clean normal operational activity with 0 flags
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Evidence Fingerprint Manifest -->
    <div class="col-lg-5">
        <div class="card h-100 shadow-sm" style="border-radius: 12px;">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge border border-secondary text-secondary font-mono">CHAIN OF CUSTODY</span>
                    <h5 class="fw-bold mb-0 font-sans text-light"><i class="bi bi-fingerprint text-info me-2"></i>Evidence Manifest</h5>
                </div>
                <span class="badge border border-info border-opacity-30 bg-info bg-opacity-10 text-info font-mono"><?= count($files) ?> Stored</span>
            </div>
            <div class="card-body p-3">
                <p class="text-secondary small mb-3 font-sans">
                    Every ingested file is cryptographically stamped to ensure complete provenance and judicial auditability.
                </p>

                <?php if (empty($files)): ?>
                    <div class="p-5 text-center text-secondary rounded-3" style="border: 1px dashed rgba(255, 255, 255, 0.1); background: rgba(5, 9, 18, 0.4);">
                        <i class="bi bi-file-earmark-lock display-5 d-block mb-3 text-muted"></i>
                        <span class="text-light font-mono small d-block mb-1">Evidence Ledger Empty</span>
                        <span class="text-muted small">Click any of the 4 demo scenarios on the left or upload a raw file to begin.</span>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($files as $f): ?>
                            <div class="p-3 rounded-3" style="background: #060a14; border: 1px solid rgba(255, 255, 255, 0.08);">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-light font-mono" style="font-size: 0.85rem;">
                                        <i class="bi bi-file-earmark-binary text-info me-1"></i>
                                        <?= \Tracelabs\Core\View::escape($f['filename']) ?>
                                    </strong>
                                    <span class="badge border border-secondary border-opacity-40 text-secondary bg-dark font-mono"><?= $f['file_format'] ?></span>
                                </div>
                                <div class="text-secondary small mb-2 font-mono" style="font-size: 0.72rem;">
                                    <span><?= number_format($f['file_size'] / 1024, 1) ?> KB</span> &bull; 
                                    <span class="text-info"><?= number_format($f['raw_event_count']) ?> records</span> &bull;
                                    <span class="text-muted"><?= $f['uploaded_at'] ?></span>
                                </div>
                                <div class="small text-muted font-mono mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    SHA-256 Provenance Fingerprint:
                                </div>
                                <div class="p-2 rounded font-mono small text-break" style="background: #02050c; border: 1px solid rgba(56, 189, 248, 0.25); color: #38bdf8; font-size: 0.72rem;">
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
