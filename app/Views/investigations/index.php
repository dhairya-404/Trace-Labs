<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge border border-info border-opacity-30 bg-info bg-opacity-10 text-info font-mono">SOC WORKSPACES</span>
            <span class="text-secondary small font-mono">&bull; Active Telemetry Desks</span>
        </div>
        <h2 class="fw-bold mb-1 font-sans text-light">Forensic Investigation Workspaces</h2>
        <p class="text-secondary mb-0 font-sans">Select an active digital incident workspace or initialize a new forensic evidence dossier.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="/investigations/create" class="btn btn-cyber-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Initialize Workspace
        </a>
    </div>
</div>

<?php if (empty($investigations)): ?>
    <div class="card p-5 text-center my-4" style="border: 1px dashed rgba(56, 189, 248, 0.3) !important; background: rgba(10, 15, 29, 0.6) !important;">
        <div class="mb-3">
            <div class="d-inline-flex p-3 rounded-circle" style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.25);">
                <i class="bi bi-radar text-info fs-1"></i>
            </div>
        </div>
        <h4 class="fw-bold text-light font-sans mb-2">No Active Forensic Workspaces</h4>
        <p class="text-secondary mx-auto font-sans" style="max-width: 520px; font-size: 0.9rem;">
            Initialize your first workspace to ingest multi-source server, authentication, or firewall logs, reconstruct a synchronized timeline, and isolate anomalous attack chains.
        </p>
        <div class="mt-2">
            <a href="/investigations/create" class="btn btn-cyber-primary px-4">
                <i class="bi bi-plus-lg me-1"></i> Initialize First Workspace
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($investigations as $inv): ?>
            <div class="col-lg-6">
                <div class="card hover-card-elevate h-100 d-flex flex-column" style="border-radius: 12px; overflow: hidden;">
                    <!-- Card Top Accent Bar -->
                    <div style="height: 3px; background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 50%, #818cf8 100%);"></div>
                    
                    <div class="card-body p-4 d-flex flex-column">
                        <!-- Header with Title & Status -->
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div>
                                <span class="badge border border-secondary border-opacity-40 text-muted font-mono small mb-1" style="font-size: 0.68rem;">
                                    #INV-<?= str_pad((string)$inv['id'], 3, '0', STR_PAD_LEFT) ?>
                                </span>
                                <h4 class="fw-bold mb-1 font-sans">
                                    <a href="/investigations/<?= $inv['id'] ?>" class="text-light text-decoration-none hover-text-primary" style="transition: color 0.15s ease;">
                                        <?= \Tracelabs\Core\View::escape($inv['title']) ?>
                                    </a>
                                </h4>
                            </div>
                            <span class="badge border border-info border-opacity-40 bg-info bg-opacity-10 text-info font-mono d-flex align-items-center gap-1 py-1 px-2">
                                <span class="rounded-circle d-inline-block bg-info" style="width: 6px; height: 6px;"></span>
                                <?= strtoupper(\Tracelabs\Core\View::escape($inv['status'] ?: 'ACTIVE')) ?>
                            </span>
                        </div>

                        <!-- Objective Description -->
                        <p class="text-secondary small mb-3 font-sans" style="line-height: 1.5; min-height: 40px;">
                            <?= \Tracelabs\Core\View::escape($inv['description'] ?: 'Digital event timeline, topological entity reconstruction, and explainable ML anomaly triage workspace.') ?>
                        </p>
                        
                        <!-- Telemetry Stat Grid -->
                        <div class="row g-2 p-3 mb-3 rounded-3 font-mono small text-center" 
                             style="background: #060a14; border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: inset 0 2px 6px rgba(0,0,0,0.5);">
                            <div class="col-3 border-end border-secondary border-opacity-25">
                                <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em;">FILES</div>
                                <div class="fw-bold text-light fs-6"><?= (int)$inv['file_count'] ?></div>
                            </div>
                            <div class="col-3 border-end border-secondary border-opacity-25">
                                <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em;">EVENTS</div>
                                <div class="fw-bold text-info fs-6"><?= number_format((int)$inv['event_count']) ?></div>
                            </div>
                            <div class="col-3 border-end border-secondary border-opacity-25">
                                <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em;">ENTITIES</div>
                                <div class="fw-bold text-warning fs-6"><?= (int)$inv['entity_count'] ?></div>
                            </div>
                            <div class="col-3">
                                <div class="text-muted small mb-1" style="font-size: 0.68rem; letter-spacing: 0.05em;">ANOMALIES</div>
                                <div class="fw-bold <?= (int)$inv['finding_count'] > 0 ? 'text-danger' : 'text-success' ?> fs-6">
                                    <?= (int)$inv['finding_count'] ?>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer: Investigator & Actions -->
                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-20 flex-wrap gap-2">
                            <span class="text-secondary small font-mono d-flex align-items-center gap-1" style="font-size: 0.74rem;">
                                <i class="bi bi-shield-person text-info"></i> <?= \Tracelabs\Core\View::escape($inv['lead_analyst']) ?>
                            </span>
                            <div class="btn-group btn-group-sm">
                                <a href="/investigations/<?= $inv['id'] ?>/timeline" class="btn btn-outline-secondary font-mono" title="View Unified Timeline">
                                    <i class="bi bi-clock-history"></i> Timeline
                                </a>
                                <a href="/investigations/<?= $inv['id'] ?>/graph" class="btn btn-outline-secondary font-mono" title="View Entity Graph">
                                    <i class="bi bi-diagram-3"></i> Graph
                                </a>
                                <a href="/investigations/<?= $inv['id'] ?>" class="btn btn-cyber-primary">
                                    <span>Open Desk</span> <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
