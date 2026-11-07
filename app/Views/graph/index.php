<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-semibold mb-0">Entity Graph</h4>
        <p class="text-secondary small mb-0 font-mono">Structural topology mapping accounts, IP addresses, and endpoints.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-outline-secondary btn-sm">
            View Detections &rarr;
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Graph Canvas Column -->
    <div class="col-lg-9">
        <div class="card">
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
                        <button type="button" class="btn btn-outline-secondary" onclick="cyFit()" title="Fit">Fit</button>
                    </div>
                    <div class="btn-group btn-group-sm font-mono">
                        <button type="button" class="btn btn-outline-secondary active" onclick="changeLayout('concentric')">Concentric</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('cose')">Force</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('breadthfirst')">Tree</button>
                    </div>
                </div>
            </div>

            <!-- Canvas -->
            <div class="card-body p-0" style="background-color: #090d16;">
                <div id="cy" style="height: 540px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Clean Entity Inspector -->
    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header py-2">
                <span class="fw-semibold small font-mono text-secondary text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Entity Inspector</span>
            </div>
            <div class="card-body p-3 font-mono" id="inspectorContent">
                <div class="text-center text-muted py-5">
                    <p class="small mb-0">Select any node on the graph to view properties and connected topology.</p>
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
                            'width': 16,
                            'height': 16,
                            'border-width': 1,
                            'border-color': '#1e293b'
                        }
                    },
                    {
                        selector: 'node[?is_suspect]',
                        style: {
                            'background-color': '#dc2626',
                            'border-color': '#ef4444',
                            'border-width': 2,
                            'width': 20,
                            'height': 20
                        }
                    },
                    {
                        selector: 'node:selected',
                        style: {
                            'border-color': '#ffffff',
                            'border-width': 2
                        }
                    },
                    {
                        selector: 'edge',
                        style: {
                            'width': 1,
                            'line-color': '#334155',
                            'target-arrow-color': '#334155',
                            'target-arrow-shape': 'triangle',
                            'curve-style': 'bezier',
                            'opacity': 0.7,
                            'arrow-scale': 0.7
                        }
                    },
                    {
                        selector: '.highlighted',
                        style: {
                            'line-color': '#38bdf8',
                            'target-arrow-color': '#38bdf8',
                            'width': 2,
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
                        <div class="d-flex justify-content-between py-1 border-bottom border-dark text-muted" style="font-size: 0.78rem;">
                            <span class="text-truncate me-2">${nd.label}</span>
                            <span class="text-uppercase" style="font-size: 0.65rem;">${nd.type}</span>
                        </div>
                    `);
                });

                const inspector = document.getElementById('inspectorContent');
                inspector.innerHTML = `
                    <div class="mb-3">
                        <div class="text-uppercase text-muted" style="font-size: 0.68rem;">${d.type}</div>
                        <div class="fw-semibold text-light text-break" style="font-size: 0.95rem;">${d.label}</div>
                        <div class="mt-1">
                            ${d.is_suspect ? '<span class="badge bg-danger-subtle text-danger border border-danger">Anomaly Target</span>' : '<span class="badge bg-secondary-subtle text-secondary">Normal</span>'}
                        </div>
                    </div>

                    <div class="py-2 border-top border-bottom border-secondary border-opacity-25 mb-3" style="font-size: 0.78rem;">
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Total Events:</span>
                            <span class="text-light">${d.event_count}</span>
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
                        <div class="text-muted text-uppercase mb-2" style="font-size: 0.68rem;">Connected Entities (${neighbors.length})</div>
                        ${neighborItems.length ? neighborItems.join('') : '<div class="text-muted small">No direct links</div>'}
                    </div>

                    <a href="/investigations/<?= $investigation['id'] ?>/timeline?${d.type === 'ip' ? 'ip' : 'account'}=${encodeURIComponent(d.label)}" class="btn btn-outline-secondary btn-sm w-100 font-mono" style="font-size: 0.75rem;">
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
        if (event && event.target) event.target.classList.add('active');

        const opts = (name === 'concentric') ? { name: 'concentric', padding: 40 } :
                     (name === 'cose') ? { name: 'cose', padding: 40, nodeRepulsion: 6000 } :
                     { name: 'breadthfirst', directed: true, padding: 40 };
        cyInstance.layout(opts).run();
    }
}
</script>
