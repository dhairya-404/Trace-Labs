<div class="auth-card">
    <!-- Brand Header (Refined High-Precision DFIR Identity) -->
    <div class="text-center mb-4">
        <div class="position-relative d-inline-flex align-items-center justify-content-center mb-3">
            <div class="brand-glow"></div>
            <img src="/favicon.svg" alt="TraceLab Mark" width="56" height="56" class="rounded-3 position-relative" style="border: 1px solid rgba(56, 189, 248, 0.35); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6), 0 0 25px rgba(56, 189, 248, 0.25);">
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
            <h3 class="fw-bold tracking-wider font-mono mb-0 text-light fs-3" style="letter-spacing: 0.08em;">TRACELAB</h3>
            <span class="badge border border-info border-opacity-30 bg-info bg-opacity-10 text-info font-mono" style="font-size: 0.65rem;">v1.0</span>
        </div>
        <p class="text-secondary small mb-0" style="font-size: 0.8rem; letter-spacing: 0.02em;">Digital Forensics &amp; Activity Investigation Platform</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 px-3 small border-0 rounded-3 mb-3 d-flex align-items-center gap-2" 
             style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3) !important;">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= \Tracelabs\Core\View::escape($error) ?></span>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST" autocomplete="off">
        <!-- Analyst Email / Account Input -->
        <div class="mb-3">
            <label for="email" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                Analyst Identity / Email
            </label>
            <div class="position-relative">
                <input type="email" 
                       class="form-control form-control-cyber" 
                       id="email" 
                       name="email" 
                       value="<?= \Tracelabs\Core\View::escape($_POST['email'] ?? '') ?>" 
                       placeholder="analyst@organization.com" 
                       required 
                       autofocus
                       autocomplete="off"
                       style="padding-left: 38px;">
                <i class="bi bi-person-badge position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 0.85rem;"></i>
            </div>
        </div>

        <!-- Clearance Passkey Input -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label text-secondary small font-mono mb-0" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    Security Passkey
                </label>
                <span class="text-muted font-mono" style="font-size: 0.68rem;">Encrypted Entry</span>
            </div>
            <div class="position-relative">
                <input type="password" 
                       class="form-control form-control-cyber" 
                       id="password" 
                       name="password" 
                       placeholder="Enter security passkey..." 
                       required 
                       autocomplete="new-password"
                       style="padding-left: 38px; padding-right: 42px;">
                <i class="bi bi-key-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 0.85rem;"></i>
                <button type="button" 
                        class="btn position-absolute top-50 end-0 translate-middle-y text-secondary pe-3 border-0 bg-transparent" 
                        onclick="togglePassword()" 
                        style="cursor: pointer; z-index: 5;"
                        title="Show/Hide Password">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <!-- Session Persistence -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input bg-dark border-secondary" type="checkbox" id="rememberMe">
                <label class="form-check-label text-secondary small font-mono" for="rememberMe" style="font-size: 0.74rem;">
                    Remember workstation session
                </label>
            </div>
            <span class="badge border border-secondary text-secondary font-mono" style="font-size: 0.66rem;">
                <i class="bi bi-shield-check text-success me-1"></i>Zero Trust
            </span>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-cyber-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-2 py-2">
            <span>Unlock Investigation Desk</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <!-- Subtle Enterprise Footer Verification -->
    <div class="text-center pt-3 mt-2 border-top border-secondary border-opacity-25">
        <span class="text-muted font-mono" style="font-size: 0.7rem;">
            <i class="bi bi-shield-lock text-info me-1"></i> End-to-End Cryptographic Provenance &bull; SHA-256 Non-Repudiation
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
</script>
