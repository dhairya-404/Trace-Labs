<!-- Ingestion Confirmation Alert (Step 2 in Demo Flow) -->
<?php if (!empty($importedSha256)): ?>
    <div class="alert alert-success border-success bg-dark text-light d-flex align-items-center justify-content-between p-3 mb-4 shadow" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-shield-fill-check fs-2 text-success"></i>
            <div>
                <strong class="d-block text-success font-mono">FILE INGESTION & NORMALIZATION COMPLETE</strong>
                <span class="small text-secondary font-mono">SHA-256 Digital Fingerprint: <code class="text-info"><?= \Tracelabs\Core\View::escape($importedSha256) ?></code></span>
            </div>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle font-mono px-3 py-2">TAMPER PROOF</span>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-clock-history text-info me-2"></i>Unified Chronological Timeline</h3>
        <p class="text-secondary small mb-0">Interactive <code>vis-timeline</code> engine consolidating messy multi-source logs into a singular, synchronized time sequence.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/graph" class="btn btn-outline-warning btn-sm font-mono">
            <i class="bi bi-diagram-3"></i> View Entity Graph &rarr;
        </a>
    </div>
</div>

<!-- vis-timeline Visualization Box with Controls -->
<div class="card mb-4 shadow">
    <div class="card-header d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
        <!-- View Mode Switcher -->
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary text-dark font-mono fw-bold">vis-timeline</span>
            <div class="btn-group btn-group-sm ms-1" role="group" aria-label="Timeline View Mode">
                <button type="button" class="btn btn-xs btn-outline-primary active" id="modeSwimlanesBtn" onclick="switchTimelineMode('swimlanes')" title="Categorized Domain Swimlanes">
                    <i class="bi bi-distribute-vertical"></i> Swimlanes
                </button>
                <button type="button" class="btn btn-xs btn-outline-secondary" id="modeUnifiedBtn" onclick="switchTimelineMode('unified')" title="Flat Unified Stream">
                    <i class="bi bi-water"></i> Flat Stream
                </button>
            </div>
        </div>

        <!-- Zoom & Focus Presets -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-xs btn-outline-danger font-mono fw-bold" onclick="focusAttackWindow()" title="Zoom directly into attack burst">
                    <i class="bi bi-crosshair text-danger"></i> Focus Incident
                </button>
                <button type="button" class="btn btn-xs btn-outline-secondary font-mono" onclick="zoomPreset(1)" title="1 Hour Span">1h</button>
                <button type="button" class="btn btn-xs btn-outline-secondary font-mono" onclick="zoomPreset(24)" title="24 Hour Span">24h</button>
                <button type="button" class="btn btn-xs btn-outline-secondary font-mono" onclick="timelineFit()" title="Fit all events"><i class="bi bi-arrows-angle-expand"></i> Fit</button>
            </div>

            <!-- Navigation Controls -->
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="timelineMove(-0.3)" title="Pan Left"><i class="bi bi-chevron-left"></i></button>
                <button type="button" class="btn btn-outline-secondary" onclick="timelineZoom(0.5)" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                <button type="button" class="btn btn-outline-secondary" onclick="timelineZoom(-0.5)" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                <button type="button" class="btn btn-outline-secondary" onclick="timelineMove(0.3)" title="Pan Right"><i class="bi bi-chevron-right"></i></button>
            </div>

            <!-- Color Legend Strip -->
            <div class="d-flex align-items-center gap-2 ms-1 small font-mono d-none d-lg-flex">
                <span class="badge border border-primary text-info bg-dark py-1 px-2" style="font-size: 0.68rem;"><i class="bi bi-person-badge me-1"></i>Auth</span>
                <span class="badge border border-warning text-warning bg-dark py-1 px-2" style="font-size: 0.68rem;"><i class="bi bi-hdd-network me-1"></i>Network</span>
                <span class="badge border bg-dark py-1 px-2" style="font-size: 0.68rem; color: #2dd4bf; border-color: #0f766e;"><i class="bi bi-terminal me-1"></i>System</span>
                <span class="badge border border-danger text-danger bg-dark py-1 px-2" style="font-size: 0.68rem;"><i class="bi bi-shield-x me-1"></i>Anomaly</span>
            </div>
        </div>
    </div>
    <div class="card-body p-2 bg-black">
        <div id="visualization" style="height: 350px; width: 100%;"></div>
    </div>
</div>

<!-- Dynamic Real-Time Live Search & Instant Filter Bar -->
<div class="card p-3 mb-4 shadow-sm border-secondary">
    <div class="row g-2 align-items-center">
        <!-- Live Instant Search Input -->
        <div class="col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-black border-secondary text-info font-mono">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       id="liveSearchInput" 
                       class="form-control bg-dark text-light border-secondary font-mono" 
                       placeholder="Search events by user (e.g. 'alice'), IP, or action..." 
                       autocomplete="off">
                <button class="btn btn-outline-secondary border-secondary" type="button" id="clearSearchBtn" onclick="clearLiveSearch()" style="display: none;" title="Clear search (Esc)">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <!-- Quick 1-Click Filter Preset Chips -->
        <div class="col-lg-6 d-flex align-items-center justify-content-lg-end gap-1 flex-wrap">
            <span class="text-secondary small font-mono me-1 d-none d-md-inline">Quick:</span>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('alice')">alice</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('admin.finance')">admin.finance</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('198.51')">198.51.x</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('login_failed')">failed_logins</button>
            <button type="button" class="btn btn-xs btn-outline-danger font-mono py-1 px-2" id="flaggedOnlyBtn" onclick="toggleFlaggedOnly()">⚠️ Flagged Only</button>
            <button type="button" class="btn btn-xs btn-outline-info font-mono py-1 px-2" onclick="clearLiveSearch()">Reset</button>
        </div>
    </div>

    <!-- Real-time Synchronization Status Bar -->
    <div class="d-flex justify-content-between align-items-center mt-2 px-1 font-mono small text-secondary">
        <span id="matchCounterText" class="text-light">
            Showing all <strong class="text-info"><?= count($events) ?></strong> events
        </span>
        <span class="text-muted small" style="font-size: 0.72rem;">
            <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Live filter synced with vis-timeline
        </span>
    </div>
</div>

<!-- Normalized Events Tabular View with Provenance Links -->
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 font-mono">
            <i class="bi bi-list-columns-reverse text-info me-2"></i>Normalized Event Sequence
        </h5>
        <span class="text-secondary small font-mono">Click any row to open the Event Provenance Inspector</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($events)): ?>
            <div class="p-5 text-center text-secondary">
                <p>No events found in this investigation workspace yet.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/import" class="btn btn-sm btn-primary">Go to Ingestion Desk</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-cyber table-hover mb-0 align-middle" id="eventsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Timestamp (UTC)</th>
                            <th>Account</th>
                            <th>Source IP</th>
                            <th>Device</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Detection Flag</th>
                            <th>Provenance</th>
                        </tr>
                    </thead>
                    <tbody class="font-mono small" id="eventsTableBody">
                        <?php foreach ($events as $ev): ?>
                            <tr class="event-row <?= $ev['is_flagged'] ? 'table-danger bg-danger bg-opacity-10 border-start border-danger border-3 is-flagged-row' : '' ?>" 
                                data-id="<?= $ev['id'] ?>"
                                data-account="<?= strtolower($ev['account']) ?>"
                                data-ip="<?= strtolower($ev['ip_address']) ?>"
                                data-device="<?= strtolower($ev['device_id']) ?>"
                                data-action="<?= strtolower($ev['action']) ?>"
                                data-details="<?= strtolower(htmlspecialchars($ev['details'], ENT_QUOTES)) ?>"
                                data-flagged="<?= $ev['is_flagged'] ? '1' : '0' ?>"
                                onclick="openEventModal(<?= $ev['id'] ?>)">
                                <td><?= $ev['id'] ?></td>
                                <td class="text-info col-ts"><?= $ev['timestamp'] ?></td>
                                <td class="fw-semibold text-light col-account"><?= \Tracelabs\Core\View::escape($ev['account']) ?></td>
                                <td class="col-ip">
                                    <?php if (!str_starts_with($ev['ip_address'], '10.') && $ev['ip_address'] !== '127.0.0.1' && $ev['ip_address'] !== '0.0.0.0'): ?>
                                        <span class="badge bg-danger-subtle text-danger"><?= $ev['ip_address'] ?></span>
                                    <?php else: ?>
                                        <span class="text-secondary"><?= $ev['ip_address'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-secondary col-device"><?= \Tracelabs\Core\View::escape($ev['device_id']) ?></td>
                                <td class="col-action">
                                    <span class="badge <?= in_array($ev['action'], ['privilege_escalation', 'data_export', 'shadow_copy_delete', 'file_download_bulk']) ? 'bg-danger' : 'bg-secondary' ?>">
                                        <?= \Tracelabs\Core\View::escape($ev['action']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= str_contains($ev['status'], 'fail') ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?>">
                                        <?= \Tracelabs\Core\View::escape($ev['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($ev['is_flagged']): ?>
                                        <span class="badge bg-danger text-light" title="<?= \Tracelabs\Core\View::escape($ev['flag_rule']) ?>">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Flagged
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info py-0 px-2 small font-mono" onclick="event.stopPropagation(); openEventModal(<?= $ev['id'] ?>)">
                                        <i class="bi bi-eye"></i> Line <?= $ev['raw_line_number'] ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <!-- Empty match message (hidden by default) -->
                        <tr id="noMatchRow" style="display: none;">
                            <td colspan="9" class="text-center py-5 text-secondary">
                                <i class="bi bi-search display-6 d-block mb-2 text-muted"></i>
                                <div class="text-light fw-bold font-mono">No events match your search query</div>
                                <div class="small text-muted mt-1">Try another keyword or <button type="button" class="btn btn-link p-0 text-info font-mono small" onclick="clearLiveSearch()">click here to reset</button>.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Event Provenance & Raw Record Inspector -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-mono fw-bold" id="eventModalLabel"><i class="bi bi-file-earmark-code text-primary me-2"></i>Event Provenance Inspector</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="eventModalBody">
                <div class="text-center py-4 text-secondary"><div class="spinner-border spinner-border-sm" role="status"></div> Loading event metadata...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close Inspector</button>
            </div>
        </div>
    </div>
</div>

<script>
let timelineInstance = null;
let timelineDataSet = null;
let timelineGroupsDataSet = null;
let rawTimelineItems = [];
let rawTimelineGroups = [];
let currentViewMode = 'swimlanes';
const totalEventsCount = <?= count($events) ?>;
let filterFlaggedOnly = false;

document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize vis-timeline with Swimlanes & Chips
    const container = document.getElementById('visualization');
    if (container) {
        fetch('/investigations/<?= $investigation['id'] ?>/timeline/data')
            .then(res => res.json())
            .then(data => {
                let items = [];
                let groups = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data && data.items) {
                    items = data.items;
                    groups = data.groups || [];
                }

                if (items.length === 0) {
                    container.innerHTML = '<div class="text-center py-5 text-secondary">No timeline events recorded yet.</div>';
                    return;
                }

                rawTimelineItems = items;
                rawTimelineGroups = groups;
                timelineDataSet = new vis.DataSet(items);
                timelineGroupsDataSet = new vis.DataSet(groups);
                
                const options = {
                    height: '350px',
                    stack: true,
                    showCurrentTime: false,
                    zoomMin: 1000 * 10, // 10 seconds
                    zoomMax: 1000 * 60 * 60 * 24 * 60, // 60 days
                    margin: { item: { horizontal: 6, vertical: 8 }, axis: 8 },
                    orientation: 'top',
                    groupHeightMode: 'auto',
                    selectable: true,
                    multiselect: false
                };

                // Initialize with swimlane groups
                timelineInstance = new vis.Timeline(container, timelineDataSet, timelineGroupsDataSet, options);
                
                timelineInstance.on('select', function(properties) {
                    if (properties.items.length > 0) {
                        openEventModal(properties.items[0]);
                    }
                });

                // Auto-fit with smooth transition
                timelineInstance.fit({ animation: { duration: 400, easingFunction: 'easeInOutQuad' } });
            })
            .catch(err => console.error('Timeline error:', err));
    }

    // 2. Setup Real-time Dynamic Live Search Listener
    const searchInput = document.getElementById('liveSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            performLiveFilter();
        });

        // Esc key to clear
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                clearLiveSearch();
            }
        });
    }
});

// Switch between Categorized Swimlanes and Flat Stream
function switchTimelineMode(mode) {
    if (!timelineInstance) return;
    currentViewMode = mode;
    const swimBtn = document.getElementById('modeSwimlanesBtn');
    const uniBtn = document.getElementById('modeUnifiedBtn');

    if (mode === 'swimlanes') {
        timelineInstance.setGroups(timelineGroupsDataSet);
        if (swimBtn) { swimBtn.classList.add('active', 'btn-outline-primary'); swimBtn.classList.remove('btn-outline-secondary'); }
        if (uniBtn) { uniBtn.classList.remove('active', 'btn-outline-primary'); uniBtn.classList.add('btn-outline-secondary'); }
    } else {
        timelineInstance.setGroups(null);
        if (uniBtn) { uniBtn.classList.add('active', 'btn-outline-primary'); uniBtn.classList.remove('btn-outline-secondary'); }
        if (swimBtn) { swimBtn.classList.remove('active', 'btn-outline-primary'); swimBtn.classList.add('btn-outline-secondary'); }
    }
}

// 🎯 Focus directly into the anomaly/attack burst window (eliminates stacking & spreading events cleanly)
function focusAttackWindow() {
    if (!timelineInstance || rawTimelineItems.length === 0) return;
    
    // Locate flagged anomaly events
    const flagged = rawTimelineItems.filter(i => i.is_flagged === true);
    if (flagged.length > 0) {
        const times = flagged.map(i => new Date(i.start).getTime());
        const minTime = Math.min(...times);
        const maxTime = Math.max(...times);
        // Add 8-minute padding before and after so rapid bursts spread out across the viewport
        const pad = 1000 * 60 * 8;
        timelineInstance.setWindow(new Date(minTime - pad), new Date(maxTime + pad), {
            animation: { duration: 600, easingFunction: 'easeInOutQuad' }
        });
    } else {
        timelineFit();
    }
}

// Zoom into a specific hour span around current viewport center
function zoomPreset(hours) {
    if (!timelineInstance || rawTimelineItems.length === 0) return;
    const range = timelineInstance.getWindow();
    const midPoint = (range.start.getTime() + range.end.getTime()) / 2;
    const span = hours * 60 * 60 * 1000;
    timelineInstance.setWindow(
        new Date(midPoint - span / 2),
        new Date(midPoint + span / 2),
        { animation: { duration: 400, easingFunction: 'easeInOutQuad' } }
    );
}

// Real-time Instant Filter Engine
function performLiveFilter() {
    const searchInput = document.getElementById('liveSearchInput');
    const query = (searchInput.value || '').trim().toLowerCase();
    const clearBtn = document.getElementById('clearSearchBtn');
    const counterText = document.getElementById('matchCounterText');
    const noMatchRow = document.getElementById('noMatchRow');

    // Toggle clear button
    clearBtn.style.display = (query.length > 0 || filterFlaggedOnly) ? 'inline-block' : 'none';

    let visibleCount = 0;
    const rows = document.querySelectorAll('.event-row');

    rows.forEach(row => {
        const account = row.getAttribute('data-account') || '';
        const ip = row.getAttribute('data-ip') || '';
        const device = row.getAttribute('data-device') || '';
        const action = row.getAttribute('data-action') || '';
        const details = row.getAttribute('data-details') || '';
        const isFlagged = row.getAttribute('data-flagged') === '1';

        // Check search match
        const matchesQuery = !query || 
            account.includes(query) || 
            ip.includes(query) || 
            device.includes(query) || 
            action.includes(query) || 
            details.includes(query);

        // Check flagged-only filter
        const matchesFlagged = !filterFlaggedOnly || isFlagged;

        if (matchesQuery && matchesFlagged) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Handle empty table state
    if (noMatchRow) {
        noMatchRow.style.display = (visibleCount === 0) ? '' : 'none';
    }

    // Update Counter Feedback
    if (query || filterFlaggedOnly) {
        counterText.innerHTML = `Showing <strong class="text-warning">${visibleCount}</strong> of ${totalEventsCount} events ${query ? `matching "<span class="text-info">${escapeHtml(query)}</span>"` : ''} ${filterFlaggedOnly ? '<span class="badge bg-danger ms-1">Flagged Only</span>' : ''}`;
    } else {
        counterText.innerHTML = `Showing all <strong class="text-info">${totalEventsCount}</strong> events`;
    }

    // 3. Synchronize with vis-timeline visualization dynamically
    if (timelineInstance && timelineDataSet && rawTimelineItems.length > 0) {
        const filteredTimelineData = rawTimelineItems.filter(item => {
            const acc = (item.account || '').toLowerCase();
            const ip = (item.ip || '').toLowerCase();
            const act = (item.action || item.content || '').toLowerCase();
            const det = (item.details || item.title || '').toLowerCase();
            const dev = (item.device || '').toLowerCase();
            const isFlag = item.is_flagged === true;

            const matchesQuery = !query || 
                acc.includes(query) || 
                ip.includes(query) || 
                act.includes(query) || 
                det.includes(query) || 
                dev.includes(query);

            const matchesFlagged = !filterFlaggedOnly || isFlag;

            return matchesQuery && matchesFlagged;
        });

        timelineDataSet.clear();
        timelineDataSet.add(filteredTimelineData);

        if (filteredTimelineData.length > 0) {
            timelineInstance.fit({ animation: { duration: 350, easingFunction: 'easeInOutQuad' } });
        }
    }
}

// Quick Preset Filter setter
function setQuickSearch(val) {
    const input = document.getElementById('liveSearchInput');
    input.value = val;
    input.focus();
    performLiveFilter();
}

// Toggle Flagged-Only Filter
function toggleFlaggedOnly() {
    filterFlaggedOnly = !filterFlaggedOnly;
    const btn = document.getElementById('flaggedOnlyBtn');
    if (filterFlaggedOnly) {
        btn.classList.remove('btn-outline-danger');
        btn.classList.add('btn-danger', 'text-light');
    } else {
        btn.classList.remove('btn-danger', 'text-light');
        btn.classList.add('btn-outline-danger');
    }
    performLiveFilter();
}

// Reset / Clear Live Search
function clearLiveSearch() {
    const input = document.getElementById('liveSearchInput');
    input.value = '';
    filterFlaggedOnly = false;
    const btn = document.getElementById('flaggedOnlyBtn');
    if (btn) {
        btn.classList.remove('btn-danger', 'text-light');
        btn.classList.add('btn-outline-danger');
    }
    performLiveFilter();
    input.focus();
}

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function timelineZoom(percentage) {
    if (timelineInstance) {
        const range = timelineInstance.getWindow();
        const interval = range.end - range.start;
        timelineInstance.setWindow({
            start: range.start.valueOf() - interval * percentage * 0.5,
            end: range.end.valueOf() + interval * percentage * 0.5
        });
    }
}

function timelineMove(percentage) {
    if (timelineInstance) {
        const range = timelineInstance.getWindow();
        const interval = range.end - range.start;
        timelineInstance.setWindow({
            start: range.start.valueOf() + interval * percentage,
            end: range.end.valueOf() + interval * percentage
        });
    }
}

function timelineFit() {
    if (timelineInstance) {
        timelineInstance.fit();
    }
}

function openEventModal(eventId) {
    const modal = new bootstrap.Modal(document.getElementById('eventModal'));
    const body = document.getElementById('eventModalBody');
    body.innerHTML = '<div class="text-center py-4 text-secondary"><div class="spinner-border spinner-border-sm" role="status"></div> Fetching raw record provenance...</div>';
    modal.show();

    fetch(`/investigations/<?= $investigation['id'] ?>/events/${eventId}`)
        .then(res => res.json())
        .then(ev => {
            let anomalyHtml = '';
            if (ev.rule_name) {
                anomalyHtml = `
                    <div class="alert alert-danger border-danger bg-danger bg-opacity-10 p-3 mb-3">
                        <div class="fw-bold text-danger mb-1 font-mono"><i class="bi bi-shield-exclamation"></i> ${ev.rule_name}</div>
                        <div class="small">${ev.plain_english_reason}</div>
                        ${ev.ml_anomaly_score > 0 ? `<div class="badge bg-danger mt-2 font-mono">Isolation Forest Outlier Score: ${ev.ml_anomaly_score}</div>` : ''}
                    </div>
                `;
            }

            body.innerHTML = `
                ${anomalyHtml}
                <div class="row g-3 mb-3 font-mono small">
                    <div class="col-md-6">
                        <div class="p-2 bg-black rounded border border-secondary">
                            <span class="text-secondary d-block">Origin Log File:</span>
                            <strong class="text-info">${ev.filename}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 bg-black rounded border border-secondary">
                            <span class="text-secondary d-block">File SHA-256 Fingerprint:</span>
                            <code class="text-light text-break">${ev.sha256_hash.substring(0, 24)}...</code>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3 font-mono small">
                    <table class="table table-bordered table-dark border-secondary">
                        <tr><th class="w-25 text-secondary">Normalized Timestamp</th><td class="text-info">${ev.timestamp}</td></tr>
                        <tr><th class="text-secondary">Identified Account</th><td class="text-light fw-bold">${ev.account}</td></tr>
                        <tr><th class="text-secondary">Source IP Address</th><td><code>${ev.ip_address}</code></td></tr>
                        <tr><th class="text-secondary">Target Device / Host</th><td>${ev.device_id}</td></tr>
                        <tr><th class="text-secondary">Normalized Action</th><td><span class="badge bg-primary">${ev.action}</span></td></tr>
                        <tr><th class="text-secondary">Operation Status</th><td><span class="badge bg-secondary">${ev.status}</span></td></tr>
                        <tr><th class="text-secondary">Details</th><td>${ev.details}</td></tr>
                    </table>
                </div>

                <div class="small text-secondary mb-1 font-mono">Original Raw Record in Source (Line #${ev.raw_line_number}):</div>
                <pre class="bg-black text-light p-3 rounded border border-secondary font-mono small mb-0">${ev.raw_data_json || 'Raw record archived'}</pre>
            `;
        })
        .catch(err => {
            body.innerHTML = '<div class="alert alert-danger font-mono">Error retrieving event record.</div>';
        });
}
</script>
