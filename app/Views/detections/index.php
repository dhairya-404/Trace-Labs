<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-shield-exclamation text-danger me-2"></i>Dual-Engine Anomaly Detection</h3>
        <p class="text-secondary small mb-0">Deterministic explainable detection rules paired with an unsupervised <strong>Isolation Forest</strong> machine learning triage model.</p>
    </div>
    <div class="d-flex gap-2">
        <form action="/investigations/<?= $investigation['id'] ?>/detections/rerun" method="POST">
            <button type="submit" class="btn btn-outline-primary btn-sm font-mono">
                <i class="bi bi-arrow-repeat"></i> Re-Run Detection Pipeline
            </button>
        </form>
        <a href="/investigations/<?= $investigation['id'] ?>/report" class="btn btn-primary btn-sm font-mono">
            <i class="bi bi-file-earmark-text"></i> Export Final Report &rarr;
        </a>
    </div>
</div>

<!-- Detection Metrics Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge border border-secondary text-secondary font-mono mb-1">DETERMINISTIC RULES</span>
                    <h5 class="fw-semibold text-light mb-0 font-mono">Rule-Based Flags</h5>
                    <p class="text-secondary small mb-0 mt-1">Brute-Force &bull; Off-Hours Operations &bull; Tampering</p>
                </div>
                <div class="fs-2 fw-semibold text-danger font-mono"><?= $ruleCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge border border-secondary text-secondary font-mono mb-1">UNSUPERVISED ML</span>
                    <h5 class="fw-semibold text-light mb-0 font-mono">Isolation Forest Outliers</h5>
                    <p class="text-secondary small mb-0 mt-1">Multi-dimensional statistical deviation</p>
                </div>
                <div class="fs-2 fw-semibold text-info font-mono"><?= $mlCount ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Academic Disclaimer Callout Box (Explicitly in the PDF!) -->
<div class="alert alert-secondary bg-black border-secondary d-flex align-items-start gap-3 p-3 mb-4 shadow-sm" role="alert">
    <i class="bi bi-info-circle-fill text-info fs-4 mt-1"></i>
    <div class="small">
        <strong class="text-light font-mono">Methodological Note on Machine Learning Triage:</strong>
        <p class="text-secondary mb-0 mt-1">
            The Isolation Forest algorithm acts as a specialist screening consultant. It scores statistical rarity in multi-dimensional feature space (off-hours, failure frequency, action risk weight). 
            <strong>Importantly, the ML anomaly score is strictly treated as an investigatory lead ("worth a second look") &mdash; never as definitive proof of malicious activity.</strong>
        </p>
    </div>
</div>

<!-- Findings List with Plain-English Explanations (Demo Step 5 & 6) -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 font-mono"><i class="bi bi-card-checklist text-danger me-2"></i>Flagged Findings & Provenance Trace</h5>
        <span class="badge bg-secondary font-mono"><?= count($findings) ?> Active Leads</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($findings)): ?>
            <div class="p-5 text-center text-secondary">
                <i class="bi bi-check2-circle display-5 d-block mb-3 text-success"></i>
                <h5 class="text-light font-mono">No Anomalies Detected</h5>
                <p class="small">The dataset matches baseline normal behavior, or no log files have been ingested yet.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-primary">Go to Ingestion Desk</a>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($findings as $f): ?>
                    <div class="list-group-item bg-dark text-light border-secondary p-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                            <div>
                                <span class="badge <?= $f['detection_source'] === 'RULE_BASED' ? 'bg-danger' : 'bg-info text-dark' ?> me-2 font-mono">
                                    <?= $f['detection_source'] ?>
                                </span>
                                <strong class="fs-6 font-mono text-light"><?= \Tracelabs\Core\View::escape($f['rule_name']) ?></strong>
                            </div>
                            <div class="d-flex align-items-center gap-2 font-mono">
                                <?php if ($f['ml_anomaly_score'] > 0): ?>
                                    <span class="badge bg-warning text-dark">Isolation Forest Score: <?= number_format($f['ml_anomaly_score'], 2) ?></span>
                                <?php endif; ?>
                                <span class="badge bg-secondary"><?= $f['severity'] ?> SEVERITY</span>
                            </div>
                        </div>

                        <!-- Plain English Reason (Core PDF Requirement!) -->
                        <div class="p-3 bg-black rounded border border-secondary mb-3">
                            <span class="text-secondary small d-block mb-1 fw-bold text-uppercase font-mono">Plain-English Diagnostic:</span>
                            <div class="text-light"><?= \Tracelabs\Core\View::escape($f['plain_english_reason']) ?></div>
                        </div>

                        <!-- Full Provenance Link Back to Original Source Record (Core PDF Requirement!) -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 small text-secondary font-mono">
                            <div>
                                <i class="bi bi-file-earmark-text text-info"></i> Source File: <strong><?= \Tracelabs\Core\View::escape($f['filename']) ?></strong>
                                (Line #<?= $f['raw_line_number'] ?>) &bull;
                                SHA-256: <code><?= substr($f['sha256_hash'], 0, 16) ?>...</code>
                            </div>
                            <div>
                                <span class="text-light">Actor: <?= \Tracelabs\Core\View::escape($f['account']) ?></span> &bull; 
                                <span class="text-warning">IP: <?= $f['ip_address'] ?></span> &bull;
                                <span><?= $f['timestamp'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Machine Learning Model Evaluation Report (Academic Requirement in PDF) -->
<div class="card shadow">
    <div class="card-header py-3">
        <h5 class="fw-bold mb-0 font-mono"><i class="bi bi-bar-chart-line text-info me-2"></i>Machine Learning Model Evaluation Report</h5>
    </div>
    <div class="card-body p-4">
        <p class="text-secondary small mb-3">
            Academic benchmark metrics for the scikit-learn Isolation Forest model, demonstrating validation against a labeled ground-truth synthetic log dataset.
        </p>

        <div class="row g-3 font-mono small">
            <div class="col-md-3">
                <div class="p-3 bg-black rounded border border-secondary text-center">
                    <div class="text-secondary small mb-1">Precision</div>
                    <div class="fs-4 fw-bold text-success"><?= $evalReport['academic_validation_metrics']['precision'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-black rounded border border-secondary text-center">
                    <div class="text-secondary small mb-1">Recall</div>
                    <div class="fs-4 fw-bold text-info"><?= $evalReport['academic_validation_metrics']['recall'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-black rounded border border-secondary text-center">
                    <div class="text-secondary small mb-1">F1-Score</div>
                    <div class="fs-4 fw-bold text-primary"><?= $evalReport['academic_validation_metrics']['f1_score'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-black rounded border border-secondary text-center">
                    <div class="text-secondary small mb-1">ROC-AUC</div>
                    <div class="fs-4 fw-bold text-warning"><?= $evalReport['academic_validation_metrics']['roc_auc'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
