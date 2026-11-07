<div class="card bg-dark border-secondary shadow-lg p-4 position-relative overflow-hidden" style="border-color: rgba(239, 68, 68, 0.4) !important;">
    <!-- Classified Diagonal Corner Watermark -->
    <div class="position-absolute top-0 end-0 bg-danger text-black fw-bold font-mono px-4 py-1 small text-uppercase" 
         style="transform: rotate(45deg) translate(28px, -15px); font-size: 0.65rem; letter-spacing: 0.15em; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);">
        CLASSIFIED
    </div>

    <div class="card-body">
        <div class="text-center mb-3">
            <div class="d-inline-flex p-3 rounded-circle bg-danger bg-opacity-10 text-danger mb-2 border border-danger border-opacity-25" style="box-shadow: 0 0 18px rgba(239, 68, 68, 0.25);">
                <i class="bi bi-shield-lock-fill fs-1"></i>
            </div>
            <div class="badge bg-danger bg-opacity-20 text-danger font-mono text-uppercase px-2 py-1 mb-2 border border-danger border-opacity-25">
                <i class="bi bi-exclamation-octagon-fill me-1"></i> Level 4 Forensic Clearance Required
            </div>
            <h3 class="fw-bold tracking-wide font-mono text-light mb-0">TRACELAB // SECURE TERMINAL</h3>
            <p class="text-secondary small font-mono mt-1">DFIR Operational Environment &bull; Authorized Personnel Only</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 small font-mono border-danger" role="alert">
                <i class="bi bi-x-octagon-fill me-1"></i> <?= \Tracelabs\Core\View::escape($error) ?>
            </div>
        <?php endif; ?>

        <!-- Security Protocol Notice -->
        <div class="alert alert-dark bg-black border-secondary py-2 px-3 small font-mono text-secondary mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-fingerprint text-warning fs-5"></i>
            <span style="font-size: 0.75rem;">
                <strong>CLASSIFIED PROTOCOL:</strong> Identity pre-verified. Manual keyphrase entry required by security policy.
            </span>
        </div>

        <form action="/login" method="POST" autocomplete="off">
            <!-- Investigator Email (Pre-filled as requested) -->
            <div class="mb-3">
                <label for="email" class="form-label small text-secondary font-mono">
                    <i class="bi bi-person-badge text-primary me-1"></i> Pre-Authorized Investigator ID
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-black border-secondary text-info font-mono"><i class="bi bi-person-check-fill"></i></span>
                    <input type="email" class="form-control bg-black text-light border-secondary font-mono" id="email" name="email" 
                           value="analyst@tracelab.local" required readonly style="background-color: #0b1120 !important; cursor: not-allowed;">
                </div>
            </div>

            <!-- Access Password (Empty, must be manually typed as requested) -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label small text-secondary font-mono mb-0">
                        <i class="bi bi-key-fill text-danger me-1"></i> Manual Security Keyphrase
                    </label>
                    <span class="badge bg-danger bg-opacity-20 text-danger font-mono" style="font-size: 0.65rem;">REQUIRED</span>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-black border-secondary text-danger"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control bg-dark text-light border-secondary font-mono" id="password" name="password" 
                           placeholder="Type classified keyphrase..." required autofocus autocomplete="new-password">
                    <button class="btn btn-outline-secondary border-secondary" type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Show/Hide Keyphrase">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold font-mono text-uppercase tracking-wide" style="box-shadow: 0 0 14px rgba(239, 68, 68, 0.3);">
                <i class="bi bi-unlock-fill me-1"></i> Authenticate & Enter Desk
            </button>
        </form>

        <!-- Classified Hint Footer -->
        <div class="mt-4 pt-3 border-top border-secondary text-center small text-secondary font-mono">
            <span class="d-block mb-1 text-muted" style="font-size: 0.72rem;">EXAMINER DEMO CLEARANCE KEYPHRASE:</span>
            <code class="text-warning px-2 py-1 bg-black rounded border border-secondary" style="font-size: 0.85rem; cursor: pointer;" onclick="copyKeyphrase()" title="Click to fill keyphrase">
                tracelab2026
            </code>
            <div class="text-muted mt-1" style="font-size: 0.68rem;">(Click code above to quickly insert during demo)</div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

function copyKeyphrase() {
    const input = document.getElementById('password');
    input.value = 'tracelab2026';
    input.focus();
}
</script>
