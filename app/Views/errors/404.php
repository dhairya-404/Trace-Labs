<div class="card p-5 text-center my-5 shadow-lg" style="border-radius: 12px; background: #080d1a !important; border: 1px solid rgba(56, 189, 248, 0.25) !important;">
    <div class="mb-3">
        <div class="d-inline-flex p-3 rounded-circle" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
            <i class="bi bi-shield-x text-danger display-4"></i>
        </div>
    </div>
    <div class="badge border border-danger border-opacity-40 text-danger bg-danger bg-opacity-10 font-mono mx-auto mb-2 px-3 py-1">ERROR 404 &bull; ARTIFACT UNRESOLVED</div>
    <h3 class="fw-bold text-light font-sans mb-2">Forensic Route Not Found</h3>
    <p class="text-secondary mx-auto font-sans mb-4" style="max-width: 500px; font-size: 0.9rem;">
        The requested endpoint <code class="text-info"><?= \Tracelabs\Core\View::escape($uri ?? '') ?></code> could not be located in this TraceLab workstation node.
    </p>
    <div>
        <a href="/investigations" class="btn btn-cyber-primary px-4"><i class="bi bi-arrow-left me-1"></i> Return to Investigation Desks</a>
    </div>
</div>
