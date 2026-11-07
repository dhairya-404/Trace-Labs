<div class="card bg-dark border-secondary p-5 text-center my-5 shadow">
    <div class="display-3 text-warning mb-3"><i class="bi bi-exclamation-diamond"></i> 404</div>
    <h3 class="fw-bold">Forensic Artifact Not Found</h3>
    <p class="text-secondary mx-auto" style="max-width: 480px;">
        The requested endpoint <code><?= \Tracelabs\Core\View::escape($uri ?? '') ?></code> does not exist on this TraceLab investigation node.
    </p>
    <div>
        <a href="/investigations" class="btn btn-primary px-4"><i class="bi bi-arrow-left me-1"></i> Return to Detective Desk</a>
    </div>
</div>
