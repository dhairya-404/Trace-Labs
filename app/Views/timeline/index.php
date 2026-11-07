<?php
$flaggedCount = count(array_filter($events, fn($e) => !empty($e['is_flagged'])));
?>

<style>
/* Flagged Incident Event Rows: Sleek Obsidian-Crimson */
#eventsTable tr.is-flagged-row,
#eventsTable tr.is-flagged-row > td,
#eventsTable tr.table-danger,
#eventsTable tr.table-danger > td {
    background-color: #16080b !important;
    --bs-table-bg: #16080b !important;
    --bs-table-color: #f1f5f9 !important;
    color: #f1f5f9 !important;
    border-bottom: 1px solid rgba(239, 68, 68, 0.25) !important;
}

#eventsTable tr.is-flagged-row > td:first-child,
#eventsTable tr.table-danger > td:first-child {
    border-left: 3px solid #ef4444 !important;
}

#eventsTable tr.is-flagged-row:hover,
#eventsTable tr.is-flagged-row:hover > td,
#eventsTable tr.table-danger:hover,
#eventsTable tr.table-danger:hover > td {
    background-color: #240d13 !important;
    --bs-table-hover-bg: #240d13 !important;
}
</style>

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
        <p class="text-secondary small mb-0">Interactive <code>vis-timeline</code> engine consolidating multi-source logs into a singular, synchronized time sequence.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-outline-danger btn-sm font-mono fw-bold">
            <i class="bi bi-shield-exclamation"></i> View Anomaly Deck (<?= $flaggedCount ?>) &rarr;
        </a>
        <a href="/investigations/<?= $investigation['id'] ?>/graph" class="btn btn-outline-warning btn-sm font-mono">
            <i class="bi bi-diagram-3"></i> Entity Graph &rarr;
        </a>
    </div>
</div>

<!-- Prominent Active Security Threat Alert Banner (SOC Tier-1 Active Incident) -->
<?php if ($flaggedCount > 0): ?>
    <div class="alert p-3 mb-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3 shadow-lg" 
         style="background: linear-gradient(90deg, rgba(69, 10, 10, 0.45) 0%, rgba(20, 5, 8, 0.6) 100%) !important; border: 1px solid rgba(239, 68, 68, 0.45) !important; box-shadow: 0 10px 30px -5px rgba(239, 68, 68, 0.15) !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded-2 text-danger fs-3 d-flex align-items-center justify-content-center" 
                 style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); width: 44px; height: 44px;">
                <i class="bi bi-shield-fill-exclamation text-danger"></i>
            </div>
            <div>
                <strong class="text-danger font-mono d-block fs-6" style="letter-spacing: 0.04em;">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i> <?= $flaggedCount ?> CRITICAL SECURITY THREAT ALERTS ON TIMELINE
                </strong>
                <span class="text-secondary small font-mono">
                    Incident window active on <strong class="text-light">Saturday 7 Nov &bull; 02:14 &ndash; 03:25 UTC</strong>: Credential stuffing, outbound exfiltration &amp; shadow copy deletion.
                </span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-danger btn-sm font-mono fw-bold px-3 shadow" onclick="showTodaysAlerts()">
                <i class="bi bi-crosshair me-1"></i> Jump Directly to Today's Alerts &rarr;
            </button>
        </div>
    </div>
<?php endif; ?>

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
                <button type="button" class="btn btn-xs btn-danger font-mono fw-bold" onclick="showTodaysAlerts()" title="Jump directly to Today's Alerts (Sat Nov 7)">
                    <i class="bi bi-shield-fill-exclamation me-1"></i> Today's Alerts (<?= $flaggedCount ?>)
                </button>
                <button type="button" class="btn btn-xs btn-outline-danger font-mono" onclick="focusAttackWindow()" title="Focus Attack Burst Window">
                    <i class="bi bi-crosshair"></i> Focus Window
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
    <div class="card-body p-2" style="background: #050812;">
        <div id="visualization" style="height: 360px; width: 100%;"></div>
    </div>
</div>

<!-- Dynamic Real-Time Live Search & Instant Filter Bar -->
<div class="card p-3 mb-4 shadow-sm">
    <div class="row g-2 align-items-center">
        <!-- Live Instant Search Input -->
        <div class="col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-black text-info font-mono" style="border-color: rgba(255, 255, 255, 0.1);">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       id="liveSearchInput" 
                       class="form-control font-mono" 
                       placeholder="Search events by user (e.g. 'alice'), IP, or action..." 
                       autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn" onclick="clearLiveSearch()" style="display: none;" title="Clear search (Esc)">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <!-- Quick 1-Click Filter Preset Chips -->
        <div class="col-lg-6 d-flex align-items-center justify-content-lg-end gap-1 flex-wrap">
            <span class="text-secondary small font-mono me-1 d-none d-md-inline">Quick:</span>
            <button type="button" class="btn btn-xs btn-danger font-mono py-1 px-2 fw-bold" id="flaggedOnlyBtn" onclick="showTodaysAlerts()" title="Jump to Today's Alerts (Sat Nov 7)">
                <i class="bi bi-shield-fill-exclamation me-1"></i> Today's Alerts (<?= $flaggedCount ?>)
            </button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('alice')">alice</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('admin.finance')">admin.finance</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('198.51')">198.51.x</button>
            <button type="button" class="btn btn-xs btn-outline-secondary font-mono py-1 px-2" onclick="setQuickSearch('login_failed')">failed_logins</button>
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
                            <tr class="event-row <?= $ev['is_flagged'] ? 'is-flagged-row' : '' ?>" 
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
                                        <span class="badge badge-cyber-danger font-mono"><?= $ev['ip_address'] ?></span>
                                    <?php else: ?>
                                        <span class="text-secondary"><?= $ev['ip_address'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-secondary col-device"><?= \Tracelabs\Core\View::escape($ev['device_id']) ?></td>
                                <td class="col-action">
                                    <span class="badge <?= in_array($ev['action'], ['privilege_escalation', 'data_export', 'shadow_copy_delete', 'file_download_bulk']) ? 'badge-cyber-danger' : 'border border-secondary border-opacity-40 text-secondary bg-dark' ?> font-mono">
                                        <?= \Tracelabs\Core\View::escape($ev['action']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= str_contains($ev['status'], 'fail') ? 'badge-cyber-danger' : 'badge-cyber-success' ?> font-mono">
                                        <?= \Tracelabs\Core\View::escape($ev['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($ev['is_flagged']): ?>
                                        <span class="badge badge-cyber-danger font-mono d-inline-flex align-items-center gap-1" title="<?= \Tracelabs\Core\View::escape($ev['flag_rule']) ?>">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Flagged
                                        </span>
                                    <?php else: ?>
                                        <span class="badge border border-secondary border-opacity-30 text-muted font-mono">Normal</span>
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

                // Auto-fit or focus alerts if requested
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('focus') === 'alerts' || urlParams.get('filter') === 'flagged') {
                    setTimeout(showTodaysAlerts, 250);
                } else {
                    timelineInstance.fit({ animation: { duration: 400, easingFunction: 'easeInOutQuad' } });
                }
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

// 🎯 Jump straight to Today's Active Security Alerts (Saturday 7 Nov)
function showTodaysAlerts() {
    // 1. Clear any conflicting search query (such as 'alice') that would filter out the Saturday threats
    const searchInput = document.getElementById('liveSearchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // 2. Activate flagged-only mode
    filterFlaggedOnly = true;
    const btn = document.getElementById('flaggedOnlyBtn');
    if (btn) {
        btn.classList.add('btn-danger', 'text-light');
        btn.classList.remove('btn-outline-danger');
    }

    // 3. Re-filter both table and vis-timeline
    performLiveFilter();

    // 4. Smoothly pan and zoom directly into the Saturday 7 Nov attack window
    focusAttackWindow();
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
        // Add 15-minute padding before and after so rapid bursts spread out across the viewport
        const pad = 1000 * 60 * 15;
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
    let flaggedInResults = 0;
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
            if (isFlagged) flaggedInResults++;
        } else {
            row.style.display = 'none';
        }
    });

    // Handle empty table state
    if (noMatchRow) {
        noMatchRow.style.display = (visibleCount === 0) ? '' : 'none';
    }

    const totalAlertsCount = rawTimelineItems.filter(i => i.is_flagged).length;

    // Update Counter Feedback with Smart Guidance
    if (query) {
        if (visibleCount > 0 && flaggedInResults === 0) {
            counterText.innerHTML = `Showing <strong class="text-warning">${visibleCount}</strong> events for "<span class="text-info">${escapeHtml(query)}</span>" <span class="badge bg-secondary-subtle text-secondary ms-1">0 Security Alerts</span> &bull; <button type="button" class="btn btn-link btn-xs p-0 text-danger font-mono fw-bold text-decoration-none" onclick="showTodaysAlerts()"><i class="bi bi-shield-fill-exclamation text-danger me-1"></i>View Today's ${totalAlertsCount} Alerts (Sat Nov 7) &rarr;</button>`;
        } else {
            counterText.innerHTML = `Showing <strong class="text-warning">${visibleCount}</strong> of ${totalEventsCount} events matching "<span class="text-info">${escapeHtml(query)}</span>" ${flaggedInResults > 0 ? `<span class="badge bg-danger ms-1">⚠️ ${flaggedInResults} Alerts</span>` : ''}`;
        }
    } else if (filterFlaggedOnly) {
        counterText.innerHTML = `Showing all <strong class="text-danger">${visibleCount}</strong> Security Alerts on <strong class="text-light font-mono">Saturday 7 Nov 2026 (Today's Incident)</strong> &bull; <button type="button" class="btn btn-link btn-xs p-0 text-info font-mono" onclick="clearLiveSearch()">Reset to All Events</button>`;
    } else {
        counterText.innerHTML = `Showing all <strong class="text-info">${totalEventsCount}</strong> events across timeline &bull; <button type="button" class="btn btn-link btn-xs p-0 text-danger font-mono fw-bold text-decoration-none" onclick="showTodaysAlerts()"><i class="bi bi-shield-fill-exclamation text-danger me-1"></i>Jump to Today's ${totalAlertsCount} Alerts (Sat Nov 7) &rarr;</button>`;
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
    filterFlaggedOnly = false;
    const btn = document.getElementById('flaggedOnlyBtn');
    if (btn) {
        btn.classList.remove('btn-danger', 'text-light');
        btn.classList.add('btn-outline-danger');
    }
    input.value = val;
    input.focus();
    performLiveFilter();
}

// Toggle Flagged-Only Filter
function toggleFlaggedOnly() {
    filterFlaggedOnly = !filterFlaggedOnly;
    const btn = document.getElementById('flaggedOnlyBtn');
    const searchInput = document.getElementById('liveSearchInput');
    
    // If activating flagged only and current search has no alerts, clear the text so alerts show up!
    if (filterFlaggedOnly && searchInput && searchInput.value) {
        searchInput.value = '';
    }

    if (filterFlaggedOnly) {
        if (btn) {
            btn.classList.remove('btn-outline-danger');
            btn.classList.add('btn-danger', 'text-light');
        }
        performLiveFilter();
        focusAttackWindow();
    } else {
        if (btn) {
            btn.classList.remove('btn-danger', 'text-light');
            btn.classList.add('btn-outline-danger');
        }
        performLiveFilter();
        timelineFit();
    }
}

// Reset / Clear Live Search
function clearLiveSearch() {
    const input = document.getElementById('liveSearchInput');
    if (input) input.value = '';
    filterFlaggedOnly = false;
    const btn = document.getElementById('flaggedOnlyBtn');
    if (btn) {
        btn.classList.remove('btn-danger', 'text-light');
        btn.classList.add('btn-outline-danger');
    }
    performLiveFilter();
    if (input) input.focus();
    timelineFit();
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
