<div class="auth-card">
    <!-- Brand Header -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 p-2 mb-3" 
             style="background: #111827; border: 1px solid #1f2937;">
            <i class="bi bi-radar text-info fs-3"></i>
        </div>
        <h3 class="fw-bold tracking-wide font-mono mb-1 text-light">TRACELAB</h3>
        <p class="text-secondary small mb-0">Digital Forensics & Activity Investigation Platform</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 px-3 small border-0 rounded-3 mb-3 d-flex align-items-center gap-2" 
             style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3) !important;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= \Tracelabs\Core\View::escape($error) ?></span>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST" autocomplete="off">
        <!-- Pre-Verified Identity Card (Username Auto-fill) -->
        <div class="mb-3">
            <label class="form-label text-secondary small font-mono mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">
                Investigator Identity
            </label>
            <div class="user-pill">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-info fw-bold font-mono" 
                         style="width: 36px; height: 36px; background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.25); font-size: 0.85rem;">
                        DF
                    </div>
                    <div>
                        <div class="fw-semibold text-light small">Lead Examiner</div>
                        <div class="font-mono text-muted" style="font-size: 0.78rem;">analyst@tracelab.local</div>
                    </div>
                </div>
                <span class="badge font-mono py-1 px-2" style="background: rgba(34, 197, 94, 0.12); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.25); font-size: 0.7rem;">
                    <i class="bi bi-shield-check me-1"></i> Pre-Authorized
                </span>
            </div>
            <!-- Hidden input submitting the auto-filled identity -->
            <input type="hidden" name="email" value="analyst@tracelab.local">
        </div>

        <!-- Manual Security Keyphrase (Required & Empty) -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="password" class="form-label text-secondary small font-mono mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    Security Keyphrase
                </label>
                <span class="text-muted small font-mono" style="font-size: 0.7rem;">Manual entry required</span>
            </div>
            <div class="position-relative">
                <input type="password" 
                       class="form-control form-control-cyber font-mono" 
                       id="password" 
                       name="password" 
                       placeholder="Enter passkey..." 
                       required 
                       autofocus 
                       autocomplete="new-password"
                       style="padding-right: 44px;">
                <button type="button" 
                        class="btn position-absolute top-50 end-0 translate-middle-y text-secondary pe-3 border-0 bg-transparent" 
                        onclick="togglePassword()" 
                        style="cursor: pointer; z-index: 5;"
                        title="Show/Hide Keyphrase">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-cyber-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-3">
            <span>Unlock Investigation Desk</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <!-- Subtle Footer Hint for Demonstrations -->
    <div class="pt-3 mt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center small text-secondary">
        <span class="font-mono text-muted" style="font-size: 0.72rem;">Clearance Key:</span>
        <button type="button" 
                class="btn btn-link p-0 text-decoration-none font-mono small" 
                style="color: var(--accent-cyan); font-size: 0.78rem;" 
                onclick="fillPasskey()" 
                title="Click to auto-fill for demo">
            <code>tracelab2026</code> <i class="bi bi-box-arrow-in-down-left ms-1"></i>
        </button>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
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

function fillPasskey() {
    const input = document.getElementById('password');
    input.value = 'tracelab2026';
    input.focus();
}
</script>
