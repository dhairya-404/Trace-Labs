<div class="row justify-content-center py-4">
    <div class="col-lg-7">
        <div class="card p-4 shadow-lg" style="border-radius: 12px;">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <a href="/investigations" class="btn btn-sm btn-outline-secondary font-mono" title="Back to Workspaces">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <span class="badge border border-info border-opacity-40 bg-info bg-opacity-10 text-info font-mono small mb-1" style="font-size: 0.68rem;">
                        INCIDENT INITIALIZATION
                    </span>
                    <h4 class="fw-bold mb-0 text-light font-sans">Initialize Forensic Workspace</h4>
                    <span class="text-secondary small font-sans">Define the operational objective and scope for activity log normalization and triage.</span>
                </div>
            </div>

            <form action="/investigations" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="title" class="form-label small font-mono text-secondary mb-1" style="font-size: 0.74rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Investigation Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control form-control-cyber" 
                           id="title" 
                           name="title" 
                           placeholder="e.g. Incident Alpha: Credential Stuffing &amp; Lateral Breach" 
                           required 
                           autofocus>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small font-mono text-secondary mb-1" style="font-size: 0.74rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Objective &amp; Incident Scope
                    </label>
                    <textarea class="form-control form-control-cyber" 
                              id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Brief summary of reported anomaly, initial SOC triage alerts, or suspect actor footprints..."></textarea>
                </div>

                <div class="mb-4">
                    <label for="lead_analyst" class="form-label small font-mono text-secondary mb-1" style="font-size: 0.74rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Lead Investigator
                    </label>
                    <input type="text" 
                           class="form-control form-control-cyber font-mono" 
                           id="lead_analyst" 
                           name="lead_analyst" 
                           value="<?= \Tracelabs\Core\View::escape($_SESSION['user_name'] ?? 'Lead Forensic Examiner') ?>">
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                    <a href="/investigations" class="btn btn-outline-secondary font-mono">Cancel</a>
                    <button type="submit" class="btn btn-cyber-primary px-4">
                        <i class="bi bi-folder-plus me-1"></i> Initialize Workspace &amp; Proceed to Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
