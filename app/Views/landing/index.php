<!-- Hero Section -->
<section class="landing-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 border border-info border-opacity-30 font-mono small" style="background: rgba(56, 189, 248, 0.08);">
                    <i class="bi bi-shield-check text-info"></i>
                    <span class="text-info fw-semibold" style="letter-spacing: 0.04em;">OPEN SOURCE DFIR &amp; ANOMALY TRIAGE WORKBENCH</span>
                </div>
                <h1 class="display-4 fw-bold text-light mb-3 font-sans" style="letter-spacing: -0.03em;">
                    A Detective's Desk for <br>
                    <span style="background: linear-gradient(135deg, #38bdf8 0%, #60a5fa 50%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Digital Activity Logs</span>
                </h1>
                <p class="lead text-secondary mb-4 font-sans" style="font-size: 1.15rem; line-height: 1.6; max-width: 620px;">
                    Ingest messy server, login, and firewall records. Compute immutable <strong>SHA-256 fingerprints</strong>, reconstruct <strong>synchronized timeline swimlanes</strong>, map <strong>entity relationship topologies</strong>, and triage threats with <strong>hybrid rules + Isolation Forest ML</strong>.
                </p>

                <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                    <a href="/playground" class="btn btn-cyber-primary px-4 py-2 font-mono fw-bold">
                        <i class="bi bi-play-circle-fill me-1"></i> Try Live Playground (Free)
                    </a>
                    <a href="/login" class="btn btn-primary px-4 py-2 font-mono fw-bold">
                        <i class="bi bi-folder2-open me-1"></i> Launch Investigation Desk &rarr;
                    </a>
                    <a href="https://github.com/dhairya-404/Trace-Labs" target="_blank" rel="noopener" class="btn btn-outline-secondary px-3 py-2 font-mono">
                        <i class="bi bi-github me-1"></i> GitHub Star
                    </a>
                </div>

                <div class="row g-2 pt-3 border-top border-secondary border-opacity-25 font-mono small text-secondary">
                    <div class="col-sm-4 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> <span>SHA-256 Chain of Custody</span>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> <span>vis-timeline Swimlanes</span>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> <span>Isolation Forest ML</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- Visual Interactive Mockup Card -->
                <div class="card p-3 shadow-lg" style="background: #090e1a !important; border: 1px solid rgba(56, 189, 248, 0.25) !important; box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.9), 0 0 30px rgba(56, 189, 248, 0.1) !important;">
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-secondary border-opacity-40 font-mono small">
                        <span class="text-danger fw-bold"><i class="bi bi-shield-fill-exclamation me-1"></i> INCIDENT #1 TRIAGE WINDOW</span>
                        <span class="badge badge-cyber-danger font-mono d-inline-flex align-items-center gap-1" style="background: rgba(239, 68, 68, 0.18) !important; color: #fee2e2 !important; border: 1px solid rgba(239, 68, 68, 0.5) !important; font-size: 0.72rem; letter-spacing: 0.05em; padding: 4px 10px;">
                            <span class="rounded-circle d-inline-block bg-danger" style="width: 6px; height: 6px; box-shadow: 0 0 6px #ef4444;"></span>
                            CRITICAL BREACH
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="small text-secondary font-mono mb-1" style="font-size: 0.72rem;">Cryptographic Fingerprint:</div>
                        <div class="p-2 rounded font-mono small text-info text-truncate border border-secondary border-opacity-40" style="background: #050811; font-size: 0.75rem;">
                            <i class="bi bi-fingerprint text-info me-1"></i>e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855
                        </div>
                    </div>

                    <div class="p-3 rounded mb-3 border border-secondary border-opacity-30" style="background: #060913;">
                        <div class="d-flex justify-content-between align-items-center small font-mono text-secondary mb-2" style="font-size: 0.72rem;">
                            <span>CHRONOLOGICAL SWIMLANES</span>
                            <span class="text-warning">Sat 7 Nov 02:14 UTC</span>
                        </div>
                        <div class="d-flex flex-column gap-2 font-mono small">
                            <div class="p-2 rounded border border-danger border-opacity-40 d-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.08); font-size: 0.74rem;">
                                <i class="bi bi-x-octagon-fill text-danger"></i>
                                <span class="text-light">login_failed</span>
                                <span class="text-secondary">&bull; admin.finance (198.51.100.44)</span>
                            </div>
                            <div class="p-2 rounded border border-danger border-opacity-40 d-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.08); font-size: 0.74rem;">
                                <i class="bi bi-x-octagon-fill text-danger"></i>
                                <span class="text-light">login_failed</span>
                                <span class="text-secondary">&bull; admin.finance (198.51.100.44)</span>
                            </div>
                            <div class="p-2 rounded border border-primary border-opacity-40 d-flex align-items-center gap-2" style="background: rgba(59, 130, 246, 0.1); font-size: 0.74rem;">
                                <i class="bi bi-shield-lock-fill text-primary"></i>
                                <span class="text-info fw-bold">login_success</span>
                                <span class="text-secondary">&bull; admin.finance (COMPROMISED)</span>
                            </div>
                            <div class="p-2 rounded border border-warning border-opacity-40 d-flex align-items-center gap-2" style="background: rgba(245, 158, 11, 0.08); font-size: 0.74rem;">
                                <i class="bi bi-arrow-up-right-circle-fill text-warning"></i>
                                <span class="text-warning">data_export</span>
                                <span class="text-secondary">&bull; 4.8 GB outbound egress stream</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center font-mono small text-secondary">
                        <span>Isolation Forest ML Outlier Score:</span>
                        <span class="badge badge-cyber-score-danger font-mono py-1 px-3 d-inline-flex align-items-center gap-1" style="background: rgba(239, 68, 68, 0.22) !important; color: #ffffff !important; border: 1px solid rgba(239, 68, 68, 0.6) !important; font-size: 0.85rem; font-weight: 700; text-shadow: 0 0 8px rgba(239, 68, 68, 0.6);">
                            <i class="bi bi-exclamation-triangle-fill text-danger me-1" style="font-size: 0.75rem;"></i>0.941 / 1.00 &bull; ANOMALOUS
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5 Forensic Capabilities Grid -->
<section class="py-5" id="features">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge border border-primary text-primary font-mono px-3 py-1 mb-2">ENGINEERING CAPABILITIES</span>
            <h2 class="fw-bold font-sans text-light">Built for Incident Responders &amp; Forensic Examiners</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Designed to solve the cognitive overload of reviewing thousands of disjointed log records during high-stakes security incidents.
            </p>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-primary bg-opacity-10 border border-primary text-primary fs-4">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">1. SHA-256 Provenance</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        Every imported CSV or JSON log artifact is cryptographically hashed at the moment of intake, generating an immutable chain of custody for court admissibility.
                    </p>
                    <span class="badge bg-secondary-subtle text-secondary font-mono small">Non-Repudiation</span>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-info bg-opacity-10 border border-info text-info fs-4">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">2. Domain Swimlanes</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        Consolidates heterogeneous timestamps into chronological swimlanes: Authentication, Network Flows, and Host Operations powered by <code>vis-timeline</code>.
                    </p>
                    <span class="badge bg-info-subtle text-info font-mono small">Zero Stacking Clutter</span>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-warning bg-opacity-10 border border-warning text-warning fs-4">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">3. Entity Topology</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        Automatically converts tabular events into an interactive <code>Cytoscape.js</code> network graph connecting user accounts, internal hosts, and suspect foreign IPs.
                    </p>
                    <span class="badge bg-warning-subtle text-warning font-mono small">Concentric Layout</span>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-danger bg-opacity-10 border border-danger text-danger fs-4">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">4. Dual-Engine Triage</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        Combines explainable deterministic rules (brute-force bursts, off-hours access, shadow copy deletion) with unsupervised <strong>Isolation Forest</strong> outlier scoring.
                    </p>
                    <span class="badge bg-danger-subtle text-danger font-mono small">FastAPI Microservice</span>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-success bg-opacity-10 border border-success text-success fs-4">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">5. Court Reports</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        One-click printable and exportable incident dossiers with complete end-to-end provenance traces linking original line numbers to final findings.
                    </p>
                    <span class="badge bg-success-subtle text-success font-mono small">PDF &bull; JSON Export</span>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded bg-primary bg-opacity-10 border border-primary text-primary fs-4">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h5 class="fw-bold text-light mb-0 font-sans">6. Dynamic Live Search</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        As-you-type search filtering that instantaneously updates both the tabular records and the graphical timeline canvas with zero page reloads.
                    </p>
                    <span class="badge bg-primary-subtle text-primary font-mono small">Sub-Millisecond Filter</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5 border-top border-bottom border-secondary border-opacity-25" style="background: radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.08) 0%, #030712 70%);">
    <div class="container text-center py-4">
        <h2 class="fw-bold font-sans text-light mb-3">Ready to Analyze Evidence in Seconds?</h2>
        <p class="text-secondary mb-4 mx-auto font-sans" style="max-width: 600px;">
            Test with our free client-side browser playground, or initialize a full workspace with our 4 pre-packaged cyber attack evaluation scenarios.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="/playground" class="btn btn-cyber-primary px-4 py-2 font-mono fw-bold">
                <i class="bi bi-play-circle-fill me-1"></i> Open Log Playground
            </a>
            <a href="/login" class="btn btn-primary px-4 py-2 font-mono fw-bold">
                <i class="bi bi-shield-lock me-1"></i> Enter Investigation Desk
            </a>
            <a href="/logs" class="btn btn-outline-secondary px-4 py-2 font-mono">
                <i class="bi bi-search me-1"></i> Browse SIEM Directory
            </a>
        </div>
    </div>
</section>

<!-- Editions & SaaS Pricing Tiers (From Scaling Blueprint) -->
<section class="py-5" id="pricing">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge border border-primary text-primary font-mono px-3 py-1 mb-2">SCALING TIERS</span>
            <h2 class="fw-bold font-sans text-light">Deployment Editions &amp; Enterprise Roadmap</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                From local investigator workbenches to high-throughput enterprise security operation centers.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Tier 1: Community -->
            <div class="col-lg-4">
                <div class="feature-card d-flex flex-column">
                    <div class="border-bottom border-secondary border-opacity-25 pb-3 mb-3">
                        <span class="badge bg-secondary-subtle text-secondary font-mono mb-2">OPEN CORE</span>
                        <h4 class="fw-bold text-light mb-1 font-sans">Community Edition</h4>
                        <div class="h2 fw-bold text-light my-2 font-mono">$0 <small class="fs-6 text-secondary font-sans">/ forever</small></div>
                        <p class="text-secondary small mb-0">For solo examiners, students, and independent security researchers.</p>
                    </div>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-4 font-mono">
                        <li><i class="bi bi-check2 text-success me-2"></i>Self-Hosted (Local / Docker)</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Up to 250,000 events / case</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>SHA-256 Non-Repudiation</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>vis-timeline Swimlanes</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Cytoscape.js Entity Graph</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Isolation Forest ML Engine</li>
                    </ul>
                    <a href="https://github.com/dhairya-404/Trace-Labs" target="_blank" rel="noopener" class="btn btn-outline-secondary font-mono w-100 mt-auto">
                        <i class="bi bi-github me-1"></i> Star on GitHub
                    </a>
                </div>
            </div>

            <!-- Tier 2: Team Pro -->
            <div class="col-lg-4">
                <div class="feature-card border-primary d-flex flex-column position-relative shadow" style="background: #0d1527;">
                    <div class="position-absolute top-0 end-0 translate-middle-y me-3">
                        <span class="badge bg-primary font-mono px-3 py-1 text-light shadow">MOST POPULAR</span>
                    </div>
                    <div class="border-bottom border-primary border-opacity-25 pb-3 mb-3">
                        <span class="badge bg-primary-subtle text-primary font-mono mb-2">CSIRT &amp; SOC TEAMS</span>
                        <h4 class="fw-bold text-light mb-1 font-sans">Team Pro</h4>
                        <div class="h2 fw-bold text-primary my-2 font-mono">$79 <small class="fs-6 text-secondary font-sans">/ analyst / mo</small></div>
                        <p class="text-secondary small mb-0">For incident response teams needing shared real-time collaboration.</p>
                    </div>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-4 font-mono">
                        <li><i class="bi bi-check2 text-primary me-2"></i>Everything in Community</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i>Hosted Cloud VPC Deployment</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i>Multi-Analyst Live Collaboration</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i>Continuous Syslog Ingestion</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i>Sigma YAML Threat Rule Importer</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i>Court-Ready PDF Incident Dossiers</li>
                    </ul>
                    <a href="/login" class="btn btn-primary font-mono w-100 mt-auto">
                        Start Team Investigation &rarr;
                    </a>
                </div>
            </div>

            <!-- Tier 3: Enterprise -->
            <div class="col-lg-4">
                <div class="feature-card d-flex flex-column">
                    <div class="border-bottom border-secondary border-opacity-25 pb-3 mb-3">
                        <span class="badge bg-warning-subtle text-warning font-mono mb-2">COMPLIANCE &amp; MSSP</span>
                        <h4 class="fw-bold text-light mb-1 font-sans">Enterprise SaaS</h4>
                        <div class="h2 fw-bold text-light my-2 font-mono">Custom <small class="fs-6 text-secondary font-sans">/ annual</small></div>
                        <p class="text-secondary small mb-0">For enterprises, MSSPs, and legal firms needing SOC2 compliance.</p>
                    </div>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-4 font-mono">
                        <li><i class="bi bi-check2 text-warning me-2"></i>Unlimited Ingestion Volume</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i>SAML SSO / Okta / Azure AD</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i>WORM Immutable Storage Vault</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i>Custom Baseline ML Model Training</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i>SOC2 Type II &bull; ISO 27001 Package</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i>Dedicated Forensic Architect Support</li>
                    </ul>
                    <a href="mailto:contact@tracelab.local" class="btn btn-outline-warning font-mono w-100 mt-auto">
                        Contact Enterprise Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
