<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge border border-danger border-opacity-40 bg-danger bg-opacity-10 text-danger font-mono">STEP 04</span>
            <span class="text-secondary small font-mono">&bull; Forensic Incident Triage</span>
        </div>
        <h3 class="fw-bold mb-1 text-light font-sans"><i class="bi bi-shield-exclamation text-danger me-2"></i>Dual-Engine Anomaly Detection</h3>
        <p class="text-secondary small mb-0 font-sans">Deterministic explainable detection rules paired with an unsupervised <strong>Isolation Forest</strong> machine learning triage model.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="/investigations/<?= $investigation['id'] ?>/timeline?focus=alerts" class="btn btn-outline-danger btn-sm font-mono fw-bold">
            <i class="bi bi-clock-history me-1"></i> View on Timeline (<?= $ruleCount + $mlCount ?>) &rarr;
        </a>
        <form action="/investigations/<?= $investigation['id'] ?>/detections/rerun" method="POST">
            <button type="submit" class="btn btn-outline-secondary btn-sm font-mono">
                <i class="bi bi-arrow-repeat me-1"></i> Re-Run Pipeline
            </button>
        </form>
        <a href="/investigations/<?= $investigation['id'] ?>/report" class="btn btn-cyber-primary btn-sm font-mono">
            <i class="bi bi-file-earmark-text me-1"></i> Final Court Report &rarr;
        </a>
    </div>
</div>

<!-- Detection Metrics Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3 shadow-sm hover-card-elevate" style="border-radius: 10px; border-left: 3px solid #ef4444 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge border border-danger border-opacity-40 text-danger bg-danger bg-opacity-10 font-mono mb-1" style="font-size: 0.68rem;">DETERMINISTIC HEURISTICS</span>
                    <h5 class="fw-bold text-light mb-0 font-sans">Rule-Based Attack Flags</h5>
                    <p class="text-secondary small mb-0 mt-1 font-sans">Rapid Brute-Force &bull; Off-Hours Logins &bull; Shadow Copy Purges</p>
                </div>
                <div class="fs-1 fw-bold text-danger font-mono ms-3" style="text-shadow: 0 0 15px rgba(239, 68, 68, 0.4);"><?= $ruleCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 shadow-sm hover-card-elevate" style="border-radius: 10px; border-left: 3px solid #38bdf8 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge border border-info border-opacity-40 text-info bg-info bg-opacity-10 font-mono mb-1" style="font-size: 0.68rem;">UNSUPERVISED ML</span>
                    <h5 class="fw-bold text-light mb-0 font-sans">Isolation Forest Outliers</h5>
                    <p class="text-secondary small mb-0 mt-1 font-sans">Multi-dimensional statistical deviation in feature space</p>
                </div>
                <div class="fs-1 fw-bold text-info font-mono ms-3" style="text-shadow: 0 0 15px rgba(56, 189, 248, 0.4);"><?= $mlCount ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Academic Disclaimer Callout Box -->
<div class="card p-3 mb-4 shadow-sm" style="background: #060a14 !important; border: 1px solid rgba(56, 189, 248, 0.25) !important; border-radius: 10px;">
    <div class="d-flex align-items-start gap-3">
        <div class="p-2 rounded-2 text-info d-flex align-items-center justify-content-center" style="background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.25); width: 36px; height: 36px;">
            <i class="bi bi-info-circle-fill text-info"></i>
        </div>
        <div class="small font-sans">
            <strong class="text-light font-mono d-block mb-1" style="letter-spacing: 0.03em;">Methodological Principle: AI as Screening Lead, Not Judicial Proof</strong>
            <p class="text-secondary mb-0" style="line-height: 1.45;">
                The scikit-learn Isolation Forest algorithm operates as an unsupervised triage consultant, scoring mathematical rarity across high-dimensional feature spaces (off-hours timing, failure bursts, egress magnitude). 
                <strong>In digital forensic jurisprudence, ML anomaly scores are strictly investigatory leads ("worth a second look") &mdash; deterministically verified rules and cryptographic logs form the admissible evidence.</strong>
            </p>
        </div>
    </div>
</div>

<!-- Findings List with Plain-English Explanations -->
<div class="card shadow mb-4" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 font-mono">INCIDENT TRIAGE</span>
            <h5 class="fw-bold mb-0 text-light font-sans"><i class="bi bi-card-checklist text-danger me-2"></i>Flagged Findings &amp; Provenance Trace</h5>
        </div>
        <span class="badge border border-secondary text-secondary font-mono"><?= count($findings) ?> Active Leads</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($findings)): ?>
            <div class="p-5 text-center text-secondary">
                <i class="bi bi-check2-circle display-5 d-block mb-3 text-success"></i>
                <h5 class="text-light font-sans">No Anomalies Detected</h5>
                <p class="small text-secondary mb-3">The ingested dataset matches baseline normal behavior, or no log files have been ingested yet.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-cyber-primary">Go to Ingestion Desk</a>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column">
                <?php foreach ($findings as $idx => $f): ?>
                    <div class="p-4 <?= $idx > 0 ? 'border-top border-secondary border-opacity-25' : '' ?>" style="background: <?= $f['severity'] === 'CRITICAL' ? 'rgba(69, 10, 10, 0.15)' : '#070c18' ?>;">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                            <div>
                                <span class="badge <?= $f['detection_source'] === 'RULE_BASED' ? 'border border-danger text-danger bg-danger bg-opacity-10' : 'border border-info text-info bg-info bg-opacity-10' ?> me-2 font-mono">
                                    <?= $f['detection_source'] ?>
                                </span>
                                <strong class="fs-6 font-mono text-light"><?= \Tracelabs\Core\View::escape($f['rule_name']) ?></strong>
                            </div>
                            <div class="d-flex align-items-center gap-2 font-mono">
                                <?php if ($f['ml_anomaly_score'] > 0): ?>
                                    <span class="badge border border-warning text-warning bg-warning bg-opacity-10">Isolation Forest Score: <?= number_format($f['ml_anomaly_score'], 2) ?></span>
                                <?php endif; ?>
                                <span class="badge <?= $f['severity'] === 'CRITICAL' ? 'bg-danger text-white' : 'bg-warning text-dark' ?>"><?= $f['severity'] ?> SEVERITY</span>
                            </div>
                        </div>

                        <!-- Plain English Diagnostic Reason -->
                        <div class="p-3 rounded-3 mb-3" style="background: #040711; border: 1px solid rgba(255, 255, 255, 0.08); border-left: 3px solid <?= $f['severity'] === 'CRITICAL' ? '#ef4444' : '#f59e0b' ?>;">
                            <span class="text-muted small d-block mb-1 font-mono fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.05em;">Plain-English Forensic Diagnostic:</span>
                            <div class="text-light font-sans" style="font-size: 0.88rem; line-height: 1.5;"><?= \Tracelabs\Core\View::escape($f['plain_english_reason']) ?></div>
                        </div>

                        <!-- Full Provenance Link Back to Original Source Record -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 small text-secondary font-mono pt-1">
                            <div>
                                <i class="bi bi-file-earmark-text text-info me-1"></i> Source File: <strong class="text-light"><?= \Tracelabs\Core\View::escape($f['filename']) ?></strong>
                                (Line #<?= $f['raw_line_number'] ?>) &bull;
                                SHA-256: <code class="text-info"><?= substr($f['sha256_hash'], 0, 16) ?>...</code>
                            </div>
                            <div>
                                <span class="text-light">Actor: <strong><?= \Tracelabs\Core\View::escape($f['account']) ?></strong></span> &bull; 
                                <span class="text-warning">IP: <?= $f['ip_address'] ?></span> &bull;
                                <span class="text-muted"><?= $f['timestamp'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Machine Learning Model Evaluation Report -->
<div class="card shadow-sm" style="border-radius: 12px;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="badge border border-info text-info bg-info bg-opacity-10 font-mono">BENCHMARKS</span>
            <h5 class="fw-bold mb-0 font-sans text-light"><i class="bi bi-bar-chart-line text-info me-2"></i>Machine Learning Model Evaluation Report</h5>
        </div>
        <span class="badge border border-secondary text-muted font-mono">scikit-learn 1.4</span>
    </div>
    <div class="card-body p-4">
        <p class="text-secondary small mb-3 font-sans">
            Standard empirical evaluation metrics for the scikit-learn Isolation Forest model, validated against a ground-truth labeled synthetic log dataset:
        </p>

        <div class="row g-3 font-mono small">
            <div class="col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: #060a14; border: 1px solid rgba(16, 185, 129, 0.25);">
                    <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase;">Precision</div>
                    <div class="fs-4 fw-bold text-success" style="text-shadow: 0 0 10px rgba(16, 185, 129, 0.35);"><?= $evalReport['academic_validation_metrics']['precision'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: #060a14; border: 1px solid rgba(56, 189, 248, 0.25);">
                    <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase;">Recall</div>
                    <div class="fs-4 fw-bold text-info" style="text-shadow: 0 0 10px rgba(56, 189, 248, 0.35);"><?= $evalReport['academic_validation_metrics']['recall'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: #060a14; border: 1px solid rgba(59, 130, 246, 0.25);">
                    <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase;">F1-Score</div>
                    <div class="fs-4 fw-bold text-primary" style="text-shadow: 0 0 10px rgba(59, 130, 246, 0.35);"><?= $evalReport['academic_validation_metrics']['f1_score'] * 100 ?>%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: #060a14; border: 1px solid rgba(245, 158, 11, 0.25);">
                    <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase;">ROC-AUC</div>
                    <div class="fs-4 fw-bold text-warning" style="text-shadow: 0 0 10px rgba(245, 158, 11, 0.35);"><?= $evalReport['academic_validation_metrics']['roc_auc'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
