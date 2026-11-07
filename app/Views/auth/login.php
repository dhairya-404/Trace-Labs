<div class="auth-card">
    <!-- Brand Header (Bulletproof Inline Forensic Telemetry Emblem) -->
    <div class="text-center mb-4">
        <div class="position-relative d-inline-flex align-items-center justify-content-center mb-3">
            <div class="brand-glow"></div>
            <svg class="rounded-3 position-relative" width="56" height="56" viewBox="0 0 64 64" fill="none" style="border: 1px solid rgba(56, 189, 248, 0.4); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6), 0 0 25px rgba(56, 189, 248, 0.25);">
                <defs>
                    <linearGradient id="loginGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#38bdf8"/>
                        <stop offset="50%" stop-color="#0284c7"/>
                        <stop offset="100%" stop-color="#2563eb"/>
                    </linearGradient>
                    <radialGradient id="loginGlow" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.35"/>
                        <stop offset="100%" stop-color="#0284c7" stop-opacity="0"/>
                    </radialGradient>
                </defs>
                <rect width="64" height="64" rx="14" fill="#070c18"/>
                <rect x="0.75" y="0.75" width="62.5" height="62.5" rx="13.25" stroke="#1e293b" stroke-width="1.5"/>
                <circle cx="32" cy="32" r="24" fill="url(#loginGlow)"/>
                <line x1="32" y1="12" x2="32" y2="52" stroke="#1e293b" stroke-width="1" stroke-dasharray="2 2"/>
                <line x1="12" y1="32" x2="52" y2="32" stroke="#1e293b" stroke-width="1" stroke-dasharray="2 2"/>
                <circle cx="32" cy="32" r="22" stroke="#334155" stroke-width="1.5" stroke-dasharray="8 6"/>
                <path d="M 32 16 A 16 16 0 1 1 16 32" stroke="url(#loginGrad)" stroke-width="3" stroke-linecap="round"/>
                <path d="M 22 32 A 10 10 0 0 1 32 22" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="32" cy="32" r="5" fill="url(#loginGrad)"/>
                <circle cx="32" cy="32" r="2.5" fill="#ffffff"/>
                <line x1="32" y1="32" x2="48" y2="16" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>
                <circle cx="48" cy="16" r="2" fill="#38bdf8"/>
            </svg>
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
            <h3 class="fw-bold tracking-wider font-mono mb-0 text-light fs-3" style="letter-spacing: 0.08em;">TRACELAB</h3>
            <span class="badge border border-info border-opacity-30 bg-info bg-opacity-10 text-info font-mono" style="font-size: 0.65rem;">v1.0</span>
        </div>
        <p class="text-secondary small mb-0 font-sans" style="font-size: 0.8rem; letter-spacing: 0.02em;">Digital Forensics &amp; Activity Investigation Platform</p>
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
