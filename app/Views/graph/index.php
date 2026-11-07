<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-diagram-3 text-warning me-2"></i>Entity Relationship Graph</h3>
        <p class="text-secondary small mb-0"><code>Cytoscape.js</code> visualization mapping accounts, IP addresses, and devices across all normalized event logs.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/investigations/<?= $investigation['id'] ?>/detections" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-shield-exclamation"></i> View Anomaly Detections &rarr;
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Graph Canvas Column -->
    <div class="col-lg-9">
        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-header bg-black border-secondary d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">Cytoscape.js Engine</span>
                    <span class="text-secondary small">Click any node to isolate connections</span>
                </div>
                <!-- Layout Controls -->
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary active" onclick="changeLayout('cose')">CoSE Physics</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('circle')">Circle</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('breadthfirst')">Hierarchical</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('grid')">Grid</button>
                </div>
            </div>
            <div class="card-body p-0 bg-black position-relative">
                <div id="cy" style="height: 580px; width: 100%;"></div>

                <!-- Floating Legend -->
                <div class="position-absolute bottom-0 start-0 m-3 p-2 bg-dark bg-opacity-75 border border-secondary rounded font-monospace small" style="backdrop-filter: blur(4px); pointer-events: none;">
                    <div class="fw-bold text-secondary mb-1">Entity Legend</div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #3b82f6;"></span> Account / User
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #10b981;"></span> Internal IP
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #f97316;"></span> External IP
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #8b5cf6;"></span> Device / Host
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #ef4444;"></span> Suspect / Anomaly Target (⚠️)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Entity Inspector (Demo Step 4: Click an entity and show everything connected to it) -->
    <div class="col-lg-3">
        <div class="card bg-dark border-secondary h-100 shadow-sm" id="entityInspectorCard">
            <div class="card-header bg-black border-secondary py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-info-circle text-info me-2"></i>Entity Inspector</h5>
            </div>
            <div class="card-body p-3" id="inspectorContent">
                <div class="text-center text-secondary py-5">
                    <i class="bi bi-cursor display-6 d-block mb-3 text-secondary"></i>
                    <p class="small mb-0">Click any entity node on the canvas (e.g. <code>198.51.100.44</code> or <code>admin.finance</code>) to inspect its full activity history and connected devices.</p>
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
                document.getElementById('cy').innerHTML = '<div class="text-center py-5 text-secondary">No entities extracted yet. Upload a log file first.</div>';
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
                            'color': '#ffffff',
                            'font-size': '11px',
                            'font-family': 'monospace',
                            'text-valign': 'bottom',
                            'text-margin-y': 6,
                            'width': 'mapData(event_count, 1, 20, 24, 48)',
                            'height': 'mapData(event_count, 1, 20, 24, 48)',
                            'border-width': 2,
                            'border-color': '#000000'
                        }
                    },
                    {
                        selector: 'node[?is_suspect]',
                        style: {
                            'border-color': '#ff4444',
                            'border-width': 3,
                            'shadow-blur': 12,
                            'shadow-color': '#ef4444'
                        }
                    },
                    {
                        selector: 'node:selected',
                        style: {
                            'border-color': '#ffffff',
                            'border-width': 4
                        }
                    },
                    {
                        selector: 'edge',
                        style: {
                            'width': 'mapData(weight, 1, 10, 1.5, 4)',
                            'line-color': '#475569',
                            'target-arrow-color': '#475569',
                            'target-arrow-shape': 'triangle',
                            'curve-style': 'bezier',
                            'opacity': 0.7,
                            'label': 'data(label)',
                            'font-size': '9px',
                            'color': '#94a3b8',
                            'text-rotation': 'autorotate',
                            'text-margin-y': -8
                        }
                    },
                    {
                        selector: '.highlighted',
                        style: {
                            'line-color': '#38bdf8',
                            'target-arrow-color': '#38bdf8',
                            'opacity': 1.0,
                            'width': 3
                        }
                    }
                ],
                layout: {
                    name: 'cose',
                    animate: false,
                    padding: 40
                }
            });

            // Demo Step 4: Click an entity and show everything connected to it
            cyInstance.on('tap', 'node', function(evt) {
                const node = evt.target;
                const d = node.data();

                // Clear previous highlights
                cyInstance.elements().removeClass('highlighted');

                // Highlight connected edges and neighbor nodes
                const connectedEdges = node.connectedEdges();
                connectedEdges.addClass('highlighted');
                const neighbors = node.neighborhood();
                neighbors.nodes().select();

                // Populate Inspector Panel
                const inspector = document.getElementById('inspectorContent');
                const neighborList = [];
                neighbors.nodes().forEach(n => {
                    const nd = n.data();
                    neighborList.push(`
                        <li class="list-group-item bg-black text-light border-secondary d-flex justify-content-between align-items-center py-1">
                            <span class="small font-monospace">${nd.label}</span>
                            <span class="badge bg-secondary">${nd.type}</span>
                        </li>
                    `);
                });

                inspector.innerHTML = `
                    <div class="mb-3">
                        <span class="badge bg-secondary text-uppercase mb-1">${d.type}</span>
                        <h4 class="fw-bold text-break text-light font-monospace mb-1">${d.label}</h4>
                        ${d.is_suspect ? '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon-fill"></i> Flagged in Suspect Chain</span>' : '<span class="badge bg-success">Baseline Entity</span>'}
                    </div>

                    <div class="bg-black p-2 rounded border border-secondary font-monospace small mb-3">
                        <div class="d-flex justify-content-between text-secondary mb-1">
                            <span>Total Event Occurrences:</span>
                            <strong class="text-info">${d.event_count}</strong>
                        </div>
                        <div class="d-flex justify-content-between text-secondary mb-1">
                            <span>First Observed:</span>
                            <span class="text-light">${d.first_seen}</span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Last Observed:</span>
                            <span class="text-light">${d.last_seen}</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <strong class="text-secondary small d-block mb-1">Direct Connected Dots (${neighbors.nodes().length} entities):</strong>
                        <ul class="list-group list-group-flush border border-secondary rounded">
                            ${neighborList.join('')}
                        </ul>
                    </div>

                    <div class="mt-3">
                        <a href="/investigations/<?= $investigation['id'] ?>/timeline?${d.type === 'ip' ? 'ip' : 'account'}=${encodeURIComponent(d.label)}" class="btn btn-sm btn-outline-info w-100">
                            <i class="bi bi-clock-history"></i> Filter Timeline for this Entity
                        </a>
                    </div>
                `;
            });
        });
});

function changeLayout(name) {
    if (cyInstance) {
        cyInstance.layout({ name: name, animate: true, animationDuration: 400 }).run();
        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
        if (event && event.target) event.target.classList.add('active');
    }
}
</script>
