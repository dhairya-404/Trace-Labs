<div class="card bg-dark border-secondary shadow-lg p-4">
    <div class="card-body">
        <div class="text-center mb-4">
            <div class="d-inline-flex p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-2">
                <i class="bi bi-shield-lock fs-1"></i>
            </div>
            <h3 class="fw-bold tracking-wide">TRACELAB</h3>
            <p class="text-secondary small mb-0">6th-Semester Digital Forensic Activity Detective</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= \Tracelabs\Core\View::escape($error) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label small text-secondary">Investigator Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email" value="analyst@tracelab.local" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small text-secondary">Access Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control bg-dark text-light border-secondary" id="password" name="password" value="tracelab2026" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Open Detective Desk
            </button>
        </form>

        <div class="mt-4 pt-3 border-top border-secondary text-center small text-secondary">
            Demo Credentials Pre-filled: <code>analyst@tracelab.local</code> / <code>tracelab2026</code>
        </div>
    </div>
</div>
