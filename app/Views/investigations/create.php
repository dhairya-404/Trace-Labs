<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card bg-dark border-secondary p-4 shadow">
            <div class="d-flex align-items-center gap-3 mb-4 border-bottom border-secondary pb-3">
                <a href="/investigations" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h4 class="fw-bold mb-0">Create New Investigation Workspace</h4>
                    <span class="text-secondary small">Define the scope and title for your log activity analysis.</span>
                </div>
            </div>

            <form action="/investigations" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label small text-secondary">Investigation Title</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" id="title" name="title" 
                           placeholder="e.g. Incident Alpha: Credential Stuffing & Lateral Breach" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small text-secondary">Objective & Background</label>
                    <textarea class="form-control bg-dark text-light border-secondary" id="description" name="description" rows="3"
                              placeholder="Brief summary of reported anomaly or incident notification..."></textarea>
                </div>

                <div class="mb-4">
                    <label for="lead_analyst" class="form-label small text-secondary">Lead Investigator</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" id="lead_analyst" name="lead_analyst" 
                           value="Lead Investigator (6th-Sem Capstone)">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/investigations" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-folder-plus me-1"></i> Initialize Workspace & Proceed to Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
