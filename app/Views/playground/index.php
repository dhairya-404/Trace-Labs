<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 border border-warning border-opacity-50 font-mono small" style="background: rgba(234, 179, 8, 0.1);">
                <i class="bi bi-play-circle-fill text-warning"></i>
                <span class="text-warning fw-bold">FREE CLIENT-SIDE DFIR UTILITY</span>
            </div>
            <h2 class="fw-bold text-light mb-1 font-sans">Interactive Log Timeline Playground</h2>
            <p class="text-secondary small mb-0 font-mono">
                Paste raw log records below to instantly calculate the cryptographic SHA-256 digest and reconstruct visual timeline swimlanes.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="/login" class="btn btn-primary btn-sm font-mono fw-bold">
                <i class="bi bi-folder2-open me-1"></i> Open Full Desk (Graph &amp; ML) &rarr;
            </a>
        </div>
    </div>

    <!-- Playground Working Grid -->
    <div class="row g-4 mb-4">
        <!-- Left: Input & Preset Selector -->
        <div class="col-lg-5">
            <div class="card h-100 shadow">
                <div class="card-header d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
                    <span class="font-mono small text-light fw-bold"><i class="bi bi-terminal me-1 text-info"></i> Raw Log Input</span>
                    <!-- Quick Snippet Presets -->
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-xs btn-outline-danger font-mono" onclick="loadPreset('bruteforce')">Brute Force</button>
                        <button type="button" class="btn btn-xs btn-outline-warning font-mono" onclick="loadPreset('exfil')">Exfiltration</button>
                        <button type="button" class="btn btn-xs btn-outline-success font-mono" onclick="loadPreset('clean')">Clean Normal</button>
                    </div>
                </div>
                <div class="card-body p-3 d-flex flex-column">
                    <textarea id="rawLogInput" class="form-control font-mono small flex-grow-1" rows="12" placeholder="timestamp,account,ip_address,action,status&#10;2026-11-07 02:14:05,admin.finance,198.51.100.44,login_failed,failed&#10;2026-11-07 02:14:22,admin.finance,198.51.100.44,login_failed,failed&#10;2026-11-07 02:15:45,admin.finance,198.51.100.44,login_success,success" style="resize: none; font-size: 0.82rem;"></textarea>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary border-opacity-25">
                        <button type="button" class="btn btn-outline-secondary btn-sm font-mono" onclick="clearPlayground()">
                            <i class="bi bi-trash3 me-1"></i> Clear
                        </button>
                        <button type="button" class="btn btn-cyber-primary btn-sm font-mono fw-bold px-3" onclick="processPlayground()">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Parse &amp; Render Timeline
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Real-time Cryptographic Provenance & Stats -->
        <div class="col-lg-7">
            <div class="card h-100 shadow p-3">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-secondary border-opacity-30 font-mono small">
                    <span class="text-light fw-bold"><i class="bi bi-shield-check text-success me-1"></i> Evidence Digest &amp; Metadata</span>
                    <span class="badge badge-cyber-success font-mono d-inline-flex align-items-center gap-1" style="background: rgba(16, 185, 129, 0.18) !important; color: #a7f3d0 !important; border: 1px solid rgba(16, 185, 129, 0.5) !important;">
                        <i class="bi bi-shield-check text-success"></i> CLIENT-SIDE VERIFIED
                    </span>
                </div>

                <div class="mb-3">
                    <label class="text-secondary small font-mono mb-1 d-block" style="font-size: 0.72rem;">SHA-256 Evidence Non-Repudiation Fingerprint:</label>
                    <div class="p-2 rounded font-mono small text-info text-break border border-secondary border-opacity-30" id="playgroundSha256" style="background: #050812; font-size: 0.78rem;">
                        e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855
                    </div>
                </div>

                <div class="row g-2 mb-3 font-mono text-center small">
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="text-secondary" style="font-size: 0.72rem;">Parsed Events</div>
                            <div class="fs-5 fw-bold text-light" id="statEventsCount">0</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="text-secondary" style="font-size: 0.72rem;">Unique Entities</div>
                            <div class="fs-5 fw-bold text-warning" id="statEntitiesCount">0</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="text-secondary" style="font-size: 0.72rem;">Potential Threats</div>
                            <div class="fs-5 fw-bold text-danger" id="statThreatsCount">0</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-dark border-secondary p-3 mb-0 mt-auto font-mono small text-secondary">
                    <div class="d-flex align-items-center gap-2 mb-1 text-light">
                        <i class="bi bi-info-circle text-info"></i>
                        <strong>TraceLab Zero-Upload Security Guarantee:</strong>
                    </div>
                    Logs pasted in this playground are parsed and hashed strictly inside your browser. No data leaves your machine unless you explicitly import it into an authenticated workspace desk.
                </div>
            </div>
        </div>
    </div>

    <!-- Live Interactive Timeline Canvas -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2 font-mono small">
                <span class="badge bg-primary text-light fw-bold">vis-timeline</span>
                <span class="text-secondary">Interactive Chronological Swimlanes</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-xs btn-outline-secondary font-mono" onclick="timelinePlaygroundFit()"><i class="bi bi-arrows-angle-expand"></i> Fit All</button>
            </div>
        </div>
        <div class="card-body p-2" style="background: #050812;">
            <div id="playgroundTimeline" style="height: 280px; width: 100%;"></div>
        </div>
    </div>

    <!-- CTA Card -->
    <div class="card p-4 text-center shadow-lg" style="background: radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.1) 0%, #070c18 80%); border: 1px solid rgba(56, 189, 248, 0.25);">
        <h4 class="fw-bold text-light font-sans mb-2">Need Topological Entity Graphing &amp; Isolation Forest ML?</h4>
        <p class="text-secondary small mx-auto mb-3 font-sans" style="max-width: 600px;">
            The playground gives you instant timeline reconstruction. The full TraceLab Investigation Desk connects accounts to foreign IPs with Cytoscape.js, runs unsupervised Python ML triage, and exports official PDF incident dossiers.
        </p>
        <div>
            <a href="/login" class="btn btn-primary font-mono fw-bold px-4">
                <i class="bi bi-folder2-open me-1"></i> Enter Full Investigation Workspace &rarr;
            </a>
        </div>
    </div>
</div>

<script>
let pgTimeline = null;
let pgItemsDataSet = null;
let pgGroupsDataSet = null;

// Preset Log Snippets
const PRESETS = {
    bruteforce: `timestamp,account,ip_address,action,status\n2026-11-07 02:14:05,admin.finance,198.51.100.44,login_failed,failed\n2026-11-07 02:14:22,admin.finance,198.51.100.44,login_failed,failed\n2026-11-07 02:14:41,admin.finance,198.51.100.44,login_failed,failed\n2026-11-07 02:15:02,admin.finance,198.51.100.44,login_failed,failed\n2026-11-07 02:15:19,admin.finance,198.51.100.44,login_failed,failed\n2026-11-07 02:15:45,admin.finance,198.51.100.44,login_success,success\n2026-11-07 02:22:10,admin.finance,198.51.100.44,privilege_escalation,success`,
    exfil: `timestamp,account,ip_address,action,status,volume_mb\n2026-11-07 03:00:15,admin.finance,198.51.100.44,login_success,success,0\n2026-11-07 03:10:00,admin.finance,198.51.100.44,data_export,success,4800\n2026-11-07 03:25:00,admin.finance,198.51.100.44,shadow_copy_delete,success,0`,
    clean: `timestamp,account,ip_address,action,status\n2026-11-06 09:00:15,alice.miller,10.0.1.45,login_success,success\n2026-11-06 09:02:40,bob.chen,10.0.1.72,login_success,success\n2026-11-06 11:30:10,alice.miller,10.0.1.45,file_access,success\n2026-11-06 12:00:00,alice.miller,10.0.1.45,firewall_allowed,success\n2026-11-06 17:55:00,alice.miller,10.0.1.45,logout,success`
};

document.addEventListener('DOMContentLoaded', function() {
    loadPreset('bruteforce');
});

function loadPreset(key) {
    const input = document.getElementById('rawLogInput');
    if (input && PRESETS[key]) {
        input.value = PRESETS[key];
        processPlayground();
    }
}

function clearPlayground() {
    document.getElementById('rawLogInput').value = '';
    document.getElementById('playgroundSha256').innerText = 'Waiting for input...';
    document.getElementById('statEventsCount').innerText = '0';
    document.getElementById('statEntitiesCount').innerText = '0';
    document.getElementById('statThreatsCount').innerText = '0';
    if (pgItemsDataSet) pgItemsDataSet.clear();
}

async function computeSha256(text) {
    const encoder = new TextEncoder();
    const data = encoder.encode(text);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

async function processPlayground() {
    const text = (document.getElementById('rawLogInput').value || '').trim();
    if (!text) {
        clearPlayground();
        return;
    }

    // 1. Calculate SHA-256 client-side
    const hash = await computeSha256(text);
    document.getElementById('playgroundSha256').innerText = hash;

    // 2. Parse CSV rows
    const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length <= 1) return;

    const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
    const events = [];
    const entities = new Set();
    let threats = 0;

    for (let i = 1; i < lines.length; i++) {
        const parts = lines[i].split(',').map(p => p.trim());
        if (parts.length !== headers.length) continue;

        const row = {};
        headers.forEach((h, idx) => row[h] = parts[idx]);

        const ts = row['timestamp'] || new Date().toISOString();
        const account = row['account'] || 'unknown';
        const ip = row['ip_address'] || '0.0.0.0';
        const action = (row['action'] || 'generic').toLowerCase();
        const status = (row['status'] || 'success').toLowerCase();

        entities.add(account);
        entities.add(ip);

        const isFail = status.includes('fail') || action.includes('fail');
        const isCritical = action.includes('privilege') || action.includes('shadow') || action.includes('export');
        if (isFail || isCritical) threats++;

        // Group assignment
        let group = 'SYSTEM';
        if (action.includes('login') || action.includes('logout') || action.includes('auth')) {
            group = 'AUTH';
        } else if (action.includes('firewall') || action.includes('traffic') || action.includes('conn')) {
            group = 'NETWORK';
        }

        let chipClass = 'tl-chip tl-chip-system';
        let icon = '<i class="bi bi-terminal me-1"></i>';
        if (isFail || isCritical) {
            chipClass = 'tl-chip tl-chip-danger';
            icon = '<i class="bi bi-shield-fill-x text-danger me-1"></i>';
        } else if (group === 'AUTH') {
            chipClass = 'tl-chip tl-chip-auth';
            icon = '<i class="bi bi-person-check-fill text-primary me-1"></i>';
        } else if (group === 'NETWORK') {
            chipClass = 'tl-chip tl-chip-network';
            icon = '<i class="bi bi-hdd-network-fill text-warning me-1"></i>';
        }

        const chipHtml = `<div class="${chipClass}">${icon}<span class="tl-act">${escapeHtml(action)}</span><span class="tl-sep">&bull;</span><span class="tl-who">${escapeHtml(account)}</span></div>`;

        events.push({
            id: i,
            group: group,
            content: chipHtml,
            start: ts,
            className: isFail || isCritical ? 'vis-pill-danger' : (group === 'AUTH' ? 'vis-pill-auth' : (group === 'NETWORK' ? 'vis-pill-network' : 'vis-pill-system')),
            title: `${action} by ${account} (${ip}) at ${ts}`
        });
    }

    // 3. Update stats
    document.getElementById('statEventsCount').innerText = events.length;
    document.getElementById('statEntitiesCount').innerText = entities.size;
    document.getElementById('statThreatsCount').innerText = threats;

    // 4. Render or update Timeline
    renderPlaygroundTimeline(events);
}

function renderPlaygroundTimeline(events) {
    const container = document.getElementById('playgroundTimeline');
    if (!container) return;

    const groups = [
        { id: 'AUTH', content: '<div class="tl-group-header"><i class="bi bi-person-badge text-primary me-2"></i><strong>Authentication</strong></div>', order: 1 },
        { id: 'NETWORK', content: '<div class="tl-group-header"><i class="bi bi-hdd-network text-warning me-2"></i><strong>Network</strong></div>', order: 2 },
        { id: 'SYSTEM', content: '<div class="tl-group-header"><i class="bi bi-terminal text-info me-2"></i><strong>Host &amp; Files</strong></div>', order: 3 }
    ];

    if (!pgTimeline) {
        pgItemsDataSet = new vis.DataSet(events);
        pgGroupsDataSet = new vis.DataSet(groups);

        const options = {
            height: '270px',
            stack: true,
            showCurrentTime: false,
            zoomMin: 1000 * 5,
            zoomMax: 1000 * 60 * 60 * 24 * 30,
            margin: { item: { horizontal: 6, vertical: 8 }, axis: 6 },
            orientation: 'top',
            groupHeightMode: 'auto'
        };

        pgTimeline = new vis.Timeline(container, pgItemsDataSet, pgGroupsDataSet, options);
    } else {
        pgItemsDataSet.clear();
        pgItemsDataSet.add(events);
    }

    pgTimeline.fit({ animation: { duration: 400, easingFunction: 'easeInOutQuad' } });
}

function timelinePlaygroundFit() {
    if (pgTimeline) pgTimeline.fit();
}

function escapeHtml(text) {
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}
</script>
