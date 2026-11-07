<!-- Ingestion Confirmation Alert (Step 2 in Demo Flow) -->
<?php if (!empty($importedSha256)): ?>
    <div class="alert alert-success border-success bg-dark text-light d-flex align-items-center justify-content-between p-3 mb-4 shadow" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-shield-fill-check fs-2 text-success"></i>
            <div>
                <strong class="d-block text-success">File Successfully Ingested & Normalized!</strong>
                <span class="small text-secondary">Cryptographic Fingerprint (SHA-256): <code class="text-info"><?= \Tracelabs\Core\View::escape($importedSha256) ?></code></span>
            </div>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle font-monospace px-3 py-2">Tamper Proof</span>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-clock-history text-info me-2"></i>Unified Chronological Timeline</h3>
        <p class="text-secondary small mb-0">Interactive <code>vis-timeline</code> visualization normalizing disparate log records into a singular, synchronized time sequence.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/graph" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-diagram-3"></i> View Entity Graph &rarr;
        </a>
    </div>
</div>

<!-- vis-timeline Visualization Box -->
<div class="card bg-dark border-secondary mb-4 shadow">
    <div class="card-header bg-black border-secondary d-flex justify-content-between align-items-center py-2">
        <div class="d-flex align-items-center gap-2 small">
            <span class="badge bg-primary">vis-timeline</span>
            <span class="text-secondary">Scroll to zoom &bull; Click and drag to pan through time</span>
        </div>
        <div class="d-flex align-items-center gap-3 small">
            <span><span class="badge bg-info p-1 me-1"></span> Normal Event</span>
            <span><span class="badge bg-danger p-1 me-1"></span> Flagged Anomaly (⚠️)</span>
        </div>
    </div>
    <div class="card-body p-2 bg-black">
        <div id="visualization" style="height: 280px; width: 100%;"></div>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="card bg-dark border-secondary p-3 mb-4">
    <form method="GET" action="/investigations/<?= $investigation['id'] ?>/timeline" class="row g-2 align-items-center">
        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-black border-secondary text-secondary"><i class="bi bi-person"></i></span>
                <input type="text" name="account" class="form-control bg-dark text-light border-secondary" placeholder="Filter Account (e.g. admin.finance)" value="<?= \Tracelabs\Core\View::escape($filters['account'] ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-black border-secondary text-secondary"><i class="bi bi-globe"></i></span>
                <input type="text" name="ip" class="form-control bg-dark text-light border-secondary" placeholder="Filter IP Address (e.g. 198.51.100.44)" value="<?= \Tracelabs\Core\View::escape($filters['ip'] ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-black border-secondary text-secondary"><i class="bi bi-activity"></i></span>
                <input type="text" name="action" class="form-control bg-dark text-light border-secondary" placeholder="Filter Action (e.g. login, export)" value="<?= \Tracelabs\Core\View::escape($filters['action'] ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-primary flex-grow-1"><i class="bi bi-funnel"></i> Apply Filter</button>
            <a href="/investigations/<?= $investigation['id'] ?>/timeline" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Normalized Events Tabular View with Provenance Links -->
<div class="card bg-dark border-secondary shadow">
    <div class="card-header bg-black border-secondary d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-list-columns-reverse text-info me-2"></i>Normalized Event Sequence (<?= count($events) ?> records)
        </h5>
        <span class="text-secondary small">Click any event to inspect raw provenance & anomaly signal</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($events)): ?>
            <div class="p-5 text-center text-secondary">
                <p>No events found matching the filter criteria.</p>
                <a href="/investigations/<?= $investigation['id'] ?>/timeline" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead class="table-black border-secondary font-monospace small">
                        <tr>
                            <th>#</th>
                            <th>Normalized Timestamp (UTC)</th>
                            <th>Account</th>
                            <th>Source IP</th>
                            <th>Device</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Detection Flag</th>
                            <th>Provenance</th>
                        </tr>
                    </thead>
                    <tbody class="font-monospace small">
                        <?php foreach ($events as $ev): ?>
                            <tr class="<?= $ev['is_flagged'] ? 'table-danger bg-danger bg-opacity-10 border-start border-danger border-3' : '' ?>" 
                                style="cursor: pointer;"
                                onclick="openEventModal(<?= $ev['id'] ?>)">
                                <td><?= $ev['id'] ?></td>
                                <td class="text-info"><?= $ev['timestamp'] ?></td>
                                <td class="fw-semibold text-light"><?= \Tracelabs\Core\View::escape($ev['account']) ?></td>
                                <td>
                                    <?php if (!str_starts_with($ev['ip_address'], '10.') && $ev['ip_address'] !== '127.0.0.1'): ?>
                                        <span class="badge bg-danger-subtle text-danger"><?= $ev['ip_address'] ?></span>
                                    <?php else: ?>
                                        <span class="text-secondary"><?= $ev['ip_address'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-secondary"><?= \Tracelabs\Core\View::escape($ev['device_id']) ?></td>
                                <td>
                                    <span class="badge <?= in_array($ev['action'], ['privilege_escalation', 'data_export', 'shadow_copy_delete']) ? 'bg-danger' : 'bg-secondary' ?>">
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
                                    <button class="btn btn-xs btn-outline-info py-0 px-2 small" onclick="event.stopPropagation(); openEventModal(<?= $ev['id'] ?>)">
                                        <i class="bi bi-eye"></i> Line <?= $ev['raw_line_number'] ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Event Provenance & Raw Record Inspector -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header bg-black border-secondary">
                <h5 class="modal-title font-monospace fw-bold" id="eventModalLabel"><i class="bi bi-file-earmark-code text-primary me-2"></i>Event Provenance Inspector</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="eventModalBody">
                <div class="text-center py-4 text-secondary"><div class="spinner-border spinner-border-sm" role="status"></div> Loading event metadata...</div>
            </div>
            <div class="modal-footer bg-black border-secondary">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close Inspector</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize vis-timeline
    const container = document.getElementById('visualization');
    if (container) {
        fetch('/investigations/<?= $investigation['id'] ?>/timeline/data')
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    container.innerHTML = '<div class="text-center py-5 text-secondary">No timeline events recorded yet.</div>';
                    return;
                }

                const items = new vis.DataSet(data);
                const options = {
                    height: '270px',
                    stack: true,
                    showCurrentTime: false,
                    zoomMin: 1000 * 60, // 1 minute
                    zoomMax: 1000 * 60 * 60 * 24 * 31, // 1 month
                    margin: { item: 10, axis: 5 },
                    orientation: 'top'
                };

                const timeline = new vis.Timeline(container, items, options);
                
                // Clicking an item in vis-timeline opens the event inspector modal
                timeline.on('select', function(properties) {
                    if (properties.items.length > 0) {
                        openEventModal(properties.items[0]);
                    }
                });
            })
            .catch(err => console.error('Timeline error:', err));
    }
});

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
                        <div class="fw-bold text-danger mb-1"><i class="bi bi-shield-exclamation"></i> ${ev.rule_name}</div>
                        <div class="small">${ev.plain_english_reason}</div>
                        ${ev.ml_anomaly_score > 0 ? `<div class="badge bg-danger mt-2">Isolation Forest Outlier Score: ${ev.ml_anomaly_score}</div>` : ''}
                    </div>
                `;
            }

            body.innerHTML = `
                ${anomalyHtml}
                <div class="row g-3 mb-3 font-monospace small">
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

                <div class="table-responsive mb-3 font-monospace small">
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

                <div class="small text-secondary mb-1">Original Raw Record (Line #${ev.raw_line_number} in source):</div>
                <pre class="bg-black text-light p-3 rounded border border-secondary font-monospace small mb-0">${ev.raw_data_json || 'Raw record archived'}</pre>
            `;
        })
        .catch(err => {
            body.innerHTML = '<div class="alert alert-danger">Error retrieving event record.</div>';
        });
}
</script>
