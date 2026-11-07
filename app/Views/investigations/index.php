<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold mb-1"><i class="bi bi-folder2-open text-primary me-2"></i>Investigation Workspaces</h2>
        <p class="text-secondary mb-0">Select an ongoing digital activity investigation or initialize a new forensic workspace.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="/investigations/create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Start New Investigation
        </a>
    </div>
</div>

<?php if (empty($investigations)): ?>
    <div class="card bg-dark border-secondary p-5 text-center my-4">
        <div class="display-4 text-secondary mb-3"><i class="bi bi-search"></i></div>
        <h4 class="fw-semibold">No active investigations yet</h4>
        <p class="text-secondary mx-auto" style="max-width: 500px;">
            Create your first workspace to upload messy server, login, or firewall log files, line them up on a timeline, and discover suspicious patterns.
        </p>
        <div>
            <a href="/investigations/create" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-1"></i> Initialize Workspace</a>
        </div>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($investigations as $inv): ?>
            <div class="col-lg-6">
                <div class="card bg-dark border-secondary h-100 shadow-sm hover-border-primary">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="fw-bold mb-0">
                                <a href="/investigations/<?= $inv['id'] ?>" class="text-light text-decoration-none">
                                    <?= \Tracelabs\Core\View::escape($inv['title']) ?>
                                </a>
                            </h4>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                <?= \Tracelabs\Core\View::escape($inv['status']) ?>
                            </span>
                        </div>
                        <p class="text-secondary small mb-3">
                            <?= \Tracelabs\Core\View::escape($inv['description'] ?: 'Digital event timeline and entity reconstruction workspace.') ?>
                        </p>
                        
                        <div class="row g-2 py-2 mb-3 bg-black rounded border border-secondary font-monospace small text-center">
                            <div class="col-3">
                                <div class="text-secondary small">Files</div>
                                <div class="fw-bold text-light"><?= (int)$inv['file_count'] ?></div>
                            </div>
                            <div class="col-3">
                                <div class="text-secondary small">Events</div>
                                <div class="fw-bold text-info"><?= (int)$inv['event_count'] ?></div>
                            </div>
                            <div class="col-3">
                                <div class="text-secondary small">Entities</div>
                                <div class="fw-bold text-warning"><?= (int)$inv['entity_count'] ?></div>
                            </div>
                            <div class="col-3">
                                <div class="text-secondary small">Anomalies</div>
                                <div class="fw-bold text-danger"><?= (int)$inv['finding_count'] ?></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small">
                                <i class="bi bi-person-badge"></i> <?= \Tracelabs\Core\View::escape($inv['lead_analyst']) ?>
                            </span>
                            <div class="btn-group btn-group-sm">
                                <a href="/investigations/<?= $inv['id'] ?>/timeline" class="btn btn-outline-secondary">
                                    <i class="bi bi-clock-history"></i> Timeline
                                </a>
                                <a href="/investigations/<?= $inv['id'] ?>/graph" class="btn btn-outline-secondary">
                                    <i class="bi bi-diagram-3"></i> Graph
                                </a>
                                <a href="/investigations/<?= $inv['id'] ?>" class="btn btn-primary">
                                    Open Desk <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
