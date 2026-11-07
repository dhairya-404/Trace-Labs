<div class="auth-card">
    <!-- Brand Header -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 p-2 mb-2" 
             style="background: #080d1a; border: 1px solid #1e293b; width: 44px; height: 44px;">
            <i class="bi bi-radar text-info fs-4"></i>
        </div>
        <h3 class="fw-bold tracking-wide font-mono mb-1 text-light">TRACELAB</h3>
        <p class="text-secondary small mb-0" style="font-size: 0.8rem;">Digital Forensics & Activity Investigation Platform</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 px-3 small border-0 rounded-3 mb-3 d-flex align-items-center gap-2" 
             style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3) !important;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= \Tracelabs\Core\View::escape($error) ?></span>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST" autocomplete="off">
        <!-- Pre-Verified Identity Card (No Overflows) -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label text-secondary small font-mono mb-0" style="font-size: 0.7rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    Investigator Identity
                </label>
                <span class="text-muted font-mono" style="font-size: 0.68rem;">Auto-Assigned</span>
            </div>
            <div class="user-pill">
                <div class="d-flex align-items-center gap-2" style="min-width: 0;">
                    <div class="position-relative flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-info fw-bold font-mono" 
                             style="width: 34px; height: 34px; background: #0f172a; border: 1px solid #1e293b; font-size: 0.82rem;">
                            DF
                        </div>
                        <span class="position-absolute bottom-0 end-0 rounded-circle bg-success" style="width: 8px; height: 8px; border: 2px solid #080d1a;"></span>
                    </div>
                    <div class="overflow-hidden" style="min-width: 0;">
                        <div class="fw-semibold text-light text-truncate" style="font-size: 0.85rem;">Lead Examiner</div>
                        <div class="font-mono text-muted text-truncate" style="font-size: 0.74rem;">analyst@tracelab.local</div>
                    </div>
                </div>
                <span class="badge-verified">
                    <i class="bi bi-shield-check"></i>
                    <span>Authorized</span>
                </span>
            </div>
            <input type="hidden" name="email" value="analyst@tracelab.local">
        </div>

        <!-- Clearance Passkey Input -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label text-secondary small font-mono mb-0" style="font-size: 0.7rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    Security Passkey
                </label>
                <span class="text-muted font-mono" style="font-size: 0.68rem;">Manual Entry Required</span>
            </div>
            <div class="position-relative">
                <input type="password" 
                       class="form-control form-control-cyber" 
                       id="password" 
                       name="password" 
                       placeholder="Enter passkey..." 
                       required 
                       autofocus 
                       autocomplete="new-password"
                       style="padding-right: 42px;">
                <button type="button" 
                        class="btn position-absolute top-50 end-0 translate-middle-y text-secondary pe-3 border-0 bg-transparent" 
                        onclick="togglePassword()" 
                        style="cursor: pointer; z-index: 5;"
                        title="Show/Hide Password">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <!-- 1-Click Demo Auto-fill Helper Card -->
        <div class="demo-key-card p-2 px-3 rounded-3 mb-3 d-flex align-items-center justify-content-between" 
             id="demoKeyBox"
             onclick="fillPasskey()" 
             role="button" 
             title="Click to fill password automatically">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-key-fill text-warning"></i>
                <div class="font-mono small">
                    <span class="text-secondary" style="font-size: 0.72rem;">Clearance Key:</span>
                    <code class="text-info fw-bold ms-1" style="font-size: 0.8rem;">tracelab2026</code>
                </div>
            </div>
            <span class="btn-xs-fill" id="fillStatusText">
                <i class="bi bi-box-arrow-in-down-left me-1"></i> Auto-fill
            </span>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-cyber-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-2">
            <span>Unlock Investigation Desk</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <!-- Subtle Footer Verification -->
    <div class="text-center pt-2">
        <span class="text-muted font-mono" style="font-size: 0.7rem;">
            <i class="bi bi-shield-lock me-1"></i> End-to-End Cryptographic Provenance
        </span>
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
    const statusText = document.getElementById('fillStatusText');
    input.value = 'tracelab2026';
    input.focus();
    
    if (statusText) {
        statusText.innerHTML = '<i class="bi bi-check-lg text-success me-1"></i> Filled!';
        setTimeout(() => {
            statusText.innerHTML = '<i class="bi bi-box-arrow-in-down-left me-1"></i> Auto-fill';
        }, 1800);
    }
}
</script>
