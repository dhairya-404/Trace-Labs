<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge border border-warning border-opacity-40 bg-warning bg-opacity-10 text-warning font-mono">STEP 03</span>
            <span class="text-secondary small font-mono">&bull; Structural Topology</span>
        </div>
        <h3 class="fw-bold mb-0 text-light font-sans"><i class="bi bi-diagram-3 text-warning me-2"></i>Interactive Entity-Relationship Graph</h3>
        <p class="text-secondary small mb-0 font-sans">Topological network correlating identity accounts, internal workstations, perimeter firewalls, and remote IP addresses.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/timeline" class="btn btn-outline-info btn-sm font-mono">
            <i class="bi bi-clock-history me-1"></i> Timeline
        </a>
        <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-outline-danger btn-sm font-mono fw-bold">
            <i class="bi bi-shield-exclamation me-1"></i> Anomaly Deck &rarr;
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Graph Canvas Column -->
    <div class="col-lg-9">
        <div class="card shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <!-- Clean Header with Controls and Minimal Legend -->
            <div class="card-header d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
                <!-- Legend directly in header (Clean, unobtrusive, no floating box) -->
                <div class="d-flex align-items-center gap-3 font-mono small text-secondary" style="font-size: 0.72rem;">
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #3b82f6;"></span> Account
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #64748b;"></span> Internal IP
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #d97706;"></span> External IP
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #8b5cf6;"></span> Endpoint
                    </span>
                    <span class="d-flex align-items-center gap-1 text-danger">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #dc2626;"></span> Flagged
                    </span>
                </div>

                <!-- Graph Actions -->
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary" onclick="cyZoom(0.25)" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="cyZoom(-0.25)" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                        <button type="button" class="btn btn-outline-secondary font-mono" onclick="cyFit()" title="Fit">Fit</button>
                    </div>
                    <div class="btn-group btn-group-sm font-mono">
                        <button type="button" class="btn btn-outline-secondary active" onclick="changeLayout('concentric')">Concentric</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('cose')">Force</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('breadthfirst')">Tree</button>
                    </div>
                </div>
            </div>

            <!-- Canvas with Subtle Radar Grid -->
            <div class="card-body p-0 position-relative" style="background-color: #040812; background-image: radial-gradient(rgba(56, 189, 248, 0.08) 1px, transparent 1px); background-size: 24px 24px;">
                <div id="cy" style="height: 560px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Clean Entity Inspector -->
    <div class="col-lg-3">
        <div class="card h-100 shadow-sm" style="border-radius: 12px;">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <span class="fw-semibold small font-mono text-secondary text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Entity Inspector</span>
                <span class="badge border border-secondary text-muted font-mono" style="font-size: 0.65rem;">TELEMETRY</span>
            </div>
            <div class="card-body p-3 font-mono" id="inspectorContent">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-crosshair display-6 d-block mb-2 text-secondary opacity-50"></i>
                    <p class="small mb-0">Click any entity node on the graph to inspect forensic properties and linked attack edges.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cyInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    fetch('/investigations/<?= $investigation['id'] ?>/graph/data')
        .then(res => res.json())
        .then(elements => {
            if (elements.length === 0) {
                document.getElementById('cy').innerHTML = '<div class="text-center py-5 text-secondary font-mono small">No entities mapped. Ingest an activity file first.</div>';
                return;
            }

            cyInstance = cytoscape({
                container: document.getElementById('cy'),
                elements: elements,
                style: [
                    {
                        selector: 'node',
                        style: {
                            'background-color': 'data(node_color)',
                            'label': 'data(label)',
                            'color': '#cbd5e1',
                            'font-size': '10px',
                            'font-family': 'JetBrains Mono, monospace',
                            'text-valign': 'bottom',
                            'text-margin-y': 4,
                            'width': 18,
                            'height': 18,
                            'border-width': 1.5,
                            'border-color': '#1e293b'
                        }
                    },
                    {
                        selector: 'node[?is_suspect]',
                        style: {
                            'background-color': '#dc2626',
                            'border-color': '#ef4444',
                            'border-width': 2.5,
                            'width': 22,
                            'height': 22
                        }
                    },
                    {
                        selector: 'node:selected',
                        style: {
                            'border-color': '#38bdf8',
                            'border-width': 2.5
                        }
                    },
                    {
                        selector: 'edge',
                        style: {
                            'width': 1.2,
                            'line-color': '#334155',
                            'target-arrow-color': '#334155',
                            'target-arrow-shape': 'triangle',
                            'curve-style': 'bezier',
                            'opacity': 0.7,
                            'arrow-scale': 0.8
                        }
                    },
                    {
                        selector: '.highlighted',
                        style: {
                            'line-color': '#38bdf8',
                            'target-arrow-color': '#38bdf8',
                            'width': 2.5,
                            'opacity': 1.0
                        }
                    }
                ],
                layout: {
                    name: 'concentric',
                    padding: 40,
                    animate: false
                }
            });

            // Clean click inspector
            cyInstance.on('tap', 'node', function(evt) {
                const node = evt.target;
                const d = node.data();

                cyInstance.elements().removeClass('highlighted');
                node.connectedEdges().addClass('highlighted');
                const neighbors = node.neighborhood().nodes();

                const neighborItems = [];
                neighbors.forEach(n => {
                    const nd = n.data();
                    neighborItems.push(`
                        <div class="d-flex justify-content-between py-1 border-bottom border-dark text-muted" style="font-size: 0.76rem;">
                            <span class="text-truncate me-2 text-light">${nd.label}</span>
                            <span class="text-uppercase font-mono small text-info" style="font-size: 0.65rem;">${nd.type}</span>
                        </div>
                    `);
                });

                const inspector = document.getElementById('inspectorContent');
                inspector.innerHTML = `
                    <div class="mb-3">
                        <div class="text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">${d.type}</div>
                        <div class="fw-semibold text-light text-break" style="font-size: 0.95rem;">${d.label}</div>
                        <div class="mt-1">
                            ${d.is_suspect ? '<span class="badge border border-danger border-opacity-40 text-danger bg-danger bg-opacity-10">Flagged Threat Node</span>' : '<span class="badge border border-secondary text-secondary">Normal Entity</span>'}
                        </div>
                    </div>

                    <div class="py-2 border-top border-bottom border-secondary border-opacity-25 mb-3" style="font-size: 0.78rem;">
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Total Events:</span>
                            <span class="text-light fw-bold">${d.event_count}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">First Observed:</span>
                            <span class="text-light">${d.first_seen.substring(11, 19)}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Last Observed:</span>
                            <span class="text-light">${d.last_seen.substring(11, 19)}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted text-uppercase mb-2" style="font-size: 0.68rem; letter-spacing: 0.05em;">Connected Entities (${neighbors.length})</div>
                        ${neighborItems.length ? neighborItems.join('') : '<div class="text-muted small">No direct links</div>'}
                    </div>

                    <a href="/investigations/<?= $investigation['id'] ?>/timeline?${d.type === 'ip' ? 'ip' : 'account'}=${encodeURIComponent(d.label)}" class="btn btn-cyber-primary btn-sm w-100 font-mono" style="font-size: 0.75rem;">
                        Filter in Timeline &rarr;
                    </a>
                `;
            });
        });
});

function cyZoom(amount) {
    if (cyInstance) cyInstance.zoom(cyInstance.zoom() * (1 + amount));
}

function cyFit() {
    if (cyInstance) cyInstance.fit(40);
}

function changeLayout(name) {
    if (cyInstance) {
        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
        if (window.event && window.event.target) window.event.target.classList.add('active');

        const opts = (name === 'concentric') ? { name: 'concentric', padding: 40 } :
                     (name === 'cose') ? { name: 'cose', padding: 40, nodeRepulsion: 6000 } :
                     { name: 'breadthfirst', directed: true, padding: 40 };
        cyInstance.layout(opts).run();
    }
}
</script>
