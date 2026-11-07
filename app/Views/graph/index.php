<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-diagram-3 text-warning me-2"></i>Entity Relationship Topology Graph</h3>
        <p class="text-secondary small mb-0"><code>Cytoscape.js</code> visualization mapping accounts, IP addresses, and workstations across all normalized logs.</p>
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
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center py-2 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary text-dark font-mono fw-bold">Cytoscape.js</span>
                    <span class="text-secondary small">Click any node to isolate connected neighbors</span>
                </div>
                <!-- Graph Controls -->
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary" onclick="cyZoom(0.3)" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="cyZoom(-0.3)" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="cyFit()" title="Fit Graph"><i class="bi bi-arrows-angle-expand"></i> Fit</button>
                    </div>
                    <!-- Layout Controls -->
                    <div class="btn-group btn-group-sm font-mono" role="group">
                        <button type="button" class="btn btn-outline-secondary active" onclick="changeLayout('cose')">CoSE Physics</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('circle')">Circle</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('breadthfirst')">Tree</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeLayout('concentric')">Concentric</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 bg-black position-relative">
                <div id="cy" style="height: 580px; width: 100%;"></div>

                <!-- Floating Legend -->
                <div class="position-absolute bottom-0 start-0 m-3 p-3 bg-dark bg-opacity-80 border border-secondary rounded font-mono small shadow" style="backdrop-filter: blur(8px); pointer-events: none;">
                    <div class="fw-bold text-secondary text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.05em;">Entity Types</div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #38bdf8;"></span> User Account
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #22c55e;"></span> Internal IP
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #f97316;"></span> External IP
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #a855f7;"></span> Host / Device
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 pt-1 border-top border-secondary">
                        <span class="rounded-circle" style="width: 12px; height: 12px; background: #ef4444; box-shadow: 0 0 6px #ef4444;"></span> Suspect Entity (⚠️)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Entity Inspector Panel -->
    <div class="col-lg-3">
        <div class="card h-100 shadow-sm" id="entityInspectorCard">
            <div class="card-header py-3">
                <h5 class="fw-bold mb-0 font-mono"><i class="bi bi-info-circle text-info me-2"></i>Entity Inspector</h5>
            </div>
            <div class="card-body p-3" id="inspectorContent">
                <div class="text-center text-secondary py-5">
                    <i class="bi bi-cursor display-6 d-block mb-3 text-secondary"></i>
                    <p class="small mb-0">Click any entity node on the canvas (e.g. <code>198.51.100.44</code> or <code>admin.finance</code>) to highlight all connected devices and review event frequency.</p>
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
                            'color': '#f8fafc',
                            'font-size': '11px',
                            'font-family': 'JetBrains Mono, monospace',
                            'text-valign': 'bottom',
                            'text-margin-y': 6,
                            'width': 'mapData(event_count, 1, 20, 26, 52)',
                            'height': 'mapData(event_count, 1, 20, 26, 52)',
                            'border-width': 2,
                            'border-color': '#000000'
                        }
                    },
                    {
                        selector: 'node[?is_suspect]',
                        style: {
                            'border-color': '#ef4444',
                            'border-width': 3,
                            'shadow-blur': 14,
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
                            'line-color': '#334155',
                            'target-arrow-color': '#334155',
                            'target-arrow-shape': 'triangle',
                            'curve-style': 'bezier',
                            'opacity': 0.75,
                            'label': 'data(label)',
                            'font-size': '9px',
                            'font-family': 'JetBrains Mono, monospace',
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

                cyInstance.elements().removeClass('highlighted');

                const connectedEdges = node.connectedEdges();
                connectedEdges.addClass('highlighted');
                const neighbors = node.neighborhood();
                neighbors.nodes().select();

                const inspector = document.getElementById('inspectorContent');
                const neighborList = [];
                neighbors.nodes().forEach(n => {
                    const nd = n.data();
                    neighborList.push(`
                        <li class="list-group-item bg-black text-light border-secondary d-flex justify-content-between align-items-center py-2 px-2">
                            <span class="small font-mono text-break">${nd.label}</span>
                            <span class="badge bg-secondary font-mono">${nd.type}</span>
                        </li>
                    `);
                });

                inspector.innerHTML = `
                    <div class="mb-3">
                        <span class="badge bg-secondary font-mono text-uppercase mb-1">${d.type}</span>
                        <h4 class="fw-bold text-break text-light font-mono mb-1">${d.label}</h4>
                        ${d.is_suspect ? '<span class="badge bg-danger font-mono"><i class="bi bi-exclamation-octagon-fill"></i> Suspect Anomaly Chain</span>' : '<span class="badge bg-success font-mono">Baseline Entity</span>'}
                    </div>

                    <div class="bg-black p-3 rounded border border-secondary font-mono small mb-3">
                        <div class="d-flex justify-content-between text-secondary mb-1">
                            <span>Events:</span>
                            <strong class="text-info">${d.event_count} occurrences</strong>
                        </div>
                        <div class="d-flex justify-content-between text-secondary mb-1">
                            <span>First Seen:</span>
                            <span class="text-light">${d.first_seen}</span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Last Seen:</span>
                            <span class="text-light">${d.last_seen}</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <strong class="text-secondary small d-block mb-1 font-mono">Connected Dots (${neighbors.nodes().length} entities):</strong>
                        <ul class="list-group list-group-flush border border-secondary rounded">
                            ${neighborList.length ? neighborList.join('') : '<li class="list-group-item bg-black text-muted small">No other connected entities</li>'}
                        </ul>
                    </div>

                    <div class="mt-3">
                        <a href="/investigations/<?= $investigation['id'] ?>/timeline?${d.type === 'ip' ? 'ip' : 'account'}=${encodeURIComponent(d.label)}" class="btn btn-sm btn-outline-info w-100 font-mono">
                            <i class="bi bi-clock-history"></i> Filter Timeline for this Entity
                        </a>
                    </div>
                `;
            });
        });
});

function cyZoom(amount) {
    if (cyInstance) {
        cyInstance.zoom(cyInstance.zoom() * (1 + amount));
    }
}

function cyFit() {
    if (cyInstance) {
        cyInstance.fit(40);
    }
}

function changeLayout(name) {
    if (cyInstance) {
        cyInstance.layout({ name: name, animate: true, animationDuration: 400 }).run();
        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
        if (event && event.target) event.target.classList.add('active');
    }
}
</script>
