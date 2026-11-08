<!-- Hero Section -->
<section class="landing-hero overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 border border-info border-opacity-30 font-mono small anim-hero-badge" style="background: rgba(56, 189, 248, 0.08);">
                    <i class="bi bi-shield-check text-info"></i>
                    <span class="text-info fw-semibold" style="letter-spacing: 0.04em;">OPEN SOURCE DFIR &amp; ANOMALY TRIAGE WORKBENCH</span>
                </div>
                <h1 class="display-4 fw-bold text-light mb-3 font-sans anim-hero-title" style="letter-spacing: -0.03em;">
                    A Detective's Desk for <br>
                    <span style="background: linear-gradient(135deg, #38bdf8 0%, #60a5fa 50%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Digital Activity Logs</span>
                </h1>
                <p class="lead text-secondary mb-4 font-sans anim-hero-sub" style="font-size: 1.15rem; line-height: 1.6; max-width: 620px;">
                    Ingest messy server, login, and firewall records. Compute immutable <strong>SHA-256 fingerprints</strong>, reconstruct <strong>synchronized timeline swimlanes</strong>, map <strong>entity relationship topologies</strong>, and triage threats with <strong>hybrid rules + Isolation Forest ML</strong>.
                </p>

                <div class="d-flex align-items-center gap-3 flex-wrap mb-4 anim-hero-cta">
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

                <div class="row g-2 pt-3 border-top border-secondary border-opacity-25 font-mono small text-secondary anim-hero-bullets">
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
                <div class="card p-3 shadow-lg anim-hero-mockup" style="background: #090e1a !important; border: 1px solid rgba(56, 189, 248, 0.25) !important; box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.9), 0 0 30px rgba(56, 189, 248, 0.1) !important;">
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-secondary border-opacity-40 font-mono small">
                        <span class="text-danger fw-bold"><i class="bi bi-shield-fill-exclamation me-1"></i> INCIDENT #1 TRIAGE WINDOW</span>
                        <span class="badge badge-cyber-danger font-mono d-inline-flex align-items-center gap-1" style="background: rgba(239, 68, 68, 0.18) !important; color: #fee2e2 !important; border: 1px solid rgba(239, 68, 68, 0.5) !important; font-size: 0.72rem; letter-spacing: 0.05em; padding: 4px 10px;">
                            <span class="rounded-circle d-inline-block bg-danger anim-beacon" style="width: 6px; height: 6px; box-shadow: 0 0 6px #ef4444;"></span>
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
                            <div class="p-2 rounded border border-danger border-opacity-40 d-flex align-items-center gap-2 swimlane-anim-1" style="background: rgba(239, 68, 68, 0.08); font-size: 0.74rem;">
                                <i class="bi bi-x-octagon-fill text-danger"></i>
                                <span class="text-light">login_failed</span>
                                <span class="text-secondary">&bull; admin.finance (198.51.100.44)</span>
                            </div>
                            <div class="p-2 rounded border border-danger border-opacity-40 d-flex align-items-center gap-2 swimlane-anim-2" style="background: rgba(239, 68, 68, 0.08); font-size: 0.74rem;">
                                <i class="bi bi-x-octagon-fill text-danger"></i>
                                <span class="text-light">login_failed</span>
                                <span class="text-secondary">&bull; admin.finance (198.51.100.44)</span>
                            </div>
                            <div class="p-2 rounded border border-primary border-opacity-40 d-flex align-items-center gap-2 swimlane-anim-3" style="background: rgba(59, 130, 246, 0.1); font-size: 0.74rem;">
                                <i class="bi bi-shield-lock-fill text-primary"></i>
                                <span class="text-info fw-bold">login_success</span>
                                <span class="text-secondary">&bull; admin.finance (COMPROMISED)</span>
                            </div>
                            <div class="p-2 rounded border border-warning border-opacity-40 d-flex align-items-center gap-2 swimlane-anim-4" style="background: rgba(245, 158, 11, 0.08); font-size: 0.74rem;">
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
        <div class="text-center mb-5 reveal">
            <span class="badge border border-primary text-primary font-mono px-3 py-1 mb-2">ENGINEERING CAPABILITIES</span>
            <h2 class="fw-bold font-sans text-light">Built for Incident Responders &amp; Forensic Examiners</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Designed to solve the cognitive overload of reviewing thousands of disjointed log records during high-stakes security incidents.
            </p>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-6 col-lg-4 reveal delay-1">
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
            <div class="col-md-6 col-lg-4 reveal delay-2">
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
            <div class="col-md-6 col-lg-4 reveal delay-3">
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
            <div class="col-md-6 col-lg-4 reveal delay-4">
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
            <div class="col-md-6 col-lg-4 reveal delay-5">
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
            <div class="col-md-6 col-lg-4 reveal delay-6">
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
    <div class="container text-center py-4 reveal-scale">
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

<!-- Inquire an Investigation & Hire for Your Company -->
<section class="py-5" id="inquire">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="badge border border-info text-info bg-info bg-opacity-10 font-mono px-3 py-1 mb-2">ENTERPRISE DFIR &amp; INCIDENT CONSULTATION</span>
            <h2 class="fw-bold font-sans text-light">Inquire an Investigation or Retain Our Team</h2>
            <p class="text-secondary mx-auto font-sans" style="max-width: 650px;">
                Facing a suspected security incident, unauthorized data egress, or needing specialized digital forensics expertise? Retain TraceLab's incident response team or deploy our investigation engine within your organization.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Left Column: 3 Engagement Models -->
            <div class="col-lg-6 reveal delay-1">
                <div class="d-flex flex-column gap-3 h-100">
                    <!-- Engagement 1: Emergency IR -->
                    <div class="feature-card p-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="p-2 rounded d-flex align-items-center justify-content-center" style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); width: 44px; height: 44px;">
                                <i class="bi bi-shield-fill-exclamation text-danger fs-4"></i>
                            </div>
                            <div>
                                <span class="badge border border-danger border-opacity-40 text-danger bg-danger bg-opacity-10 font-mono small mb-1" style="font-size: 0.68rem;">RAPID RESPONSE SLA</span>
                                <h5 class="fw-bold text-light mb-0 font-sans">1. Emergency Incident Response &amp; Triage</h5>
                            </div>
                        </div>
                        <p class="text-secondary small mb-3 font-sans">
                            Active credential stuffing, abnormal outbound data flows, or lateral movement in progress. Our examiners calculate intake SHA-256 fingerprints, reconstruct synchronized swimlanes, and deliver court-admissible dossiers for executive boards and legal counsel.
                        </p>
                        <div class="d-flex align-items-center gap-2 font-mono small text-muted" style="font-size: 0.75rem;">
                            <span><i class="bi bi-clock-history text-danger me-1"></i> 2-Hour Response SLA</span>
                            <span>&bull;</span>
                            <span>Root-Cause Attribution</span>
                        </div>
                    </div>

                    <!-- Engagement 2: Insider Threat Audit -->
                    <div class="feature-card p-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="p-2 rounded d-flex align-items-center justify-content-center" style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); width: 44px; height: 44px;">
                                <i class="bi bi-person-x-fill text-warning fs-4"></i>
                            </div>
                            <div>
                                <span class="badge border border-warning border-opacity-40 text-warning bg-warning bg-opacity-10 font-mono small mb-1" style="font-size: 0.68rem;">INSIDER EXFILTRATION</span>
                                <h5 class="fw-bold text-light mb-0 font-sans">2. Insider Threat &amp; Compromise Audit</h5>
                            </div>
                        </div>
                        <p class="text-secondary small mb-3 font-sans">
                            Suspecting unauthorized intellectual property sync, credential sharing, or off-hours privileged command execution? We correlate heterogeneous logs (Windows Event 4624, SSH, Palo Alto, AWS CloudTrail) and isolate statistical anomalies using unsupervised Isolation Forest ML.
                        </p>
                        <div class="d-flex align-items-center gap-2 font-mono small text-muted" style="font-size: 0.75rem;">
                            <span><i class="bi bi-fingerprint text-warning me-1"></i> Complete Provenance Trace</span>
                            <span>&bull;</span>
                            <span>Entity Topological Map</span>
                        </div>
                    </div>

                    <!-- Engagement 3: Dedicated Deployment -->
                    <div class="feature-card p-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="p-2 rounded d-flex align-items-center justify-content-center" style="background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.35); width: 44px; height: 44px;">
                                <i class="bi bi-hdd-network text-info fs-4"></i>
                            </div>
                            <div>
                                <span class="badge border border-info border-opacity-40 text-info bg-info bg-opacity-10 font-mono small mb-1" style="font-size: 0.68rem;">ON-PREMISES &amp; VPC</span>
                                <h5 class="fw-bold text-light mb-0 font-sans">3. Enterprise Platform Deployment</h5>
                            </div>
                        </div>
                        <p class="text-secondary small mb-3 font-sans">
                            Deploy the complete TraceLab forensics suite directly within your organization's air-gapped datacenter or private cloud VPC. Features continuous syslog daemons, Sigma YAML rule auto-importers, multi-analyst desks, and zero external telemetry leakage.
                        </p>
                        <div class="d-flex align-items-center gap-2 font-mono small text-muted" style="font-size: 0.75rem;">
                            <span><i class="bi bi-shield-lock text-info me-1"></i> Zero-Trust Air-Gapped</span>
                            <span>&bull;</span>
                            <span>Sigma Rules &amp; TimescaleDB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Investigation Intake Desk Form -->
            <div class="col-lg-6 reveal delay-2">
                <div class="card p-4 shadow-lg h-100 d-flex flex-column" style="background: #080d1a !important; border: 1px solid rgba(56, 189, 248, 0.35) !important; border-radius: 14px; box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.9), 0 0 35px rgba(56, 189, 248, 0.12) !important;">
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom border-secondary border-opacity-30">
                        <div>
                            <span class="badge border border-info border-opacity-40 text-info bg-info bg-opacity-10 font-mono small mb-1" style="font-size: 0.68rem;">
                                INTAKE DESK
                            </span>
                            <h4 class="fw-bold text-light mb-0 font-sans">Submit Investigation Inquiry</h4>
                        </div>
                        <span class="badge border border-secondary text-secondary font-mono small py-1 px-2">
                            <i class="bi bi-lock-fill text-success me-1"></i>CONFIDENTIAL // NDA
                        </span>
                    </div>

                    <!-- Success Confirmation Message (Toggled via JS) -->
                    <div id="inquirySuccessState" class="p-4 rounded-3 text-center my-auto" style="display: none; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.35);">
                        <i class="bi bi-check-circle-fill text-success display-4 mb-2 d-block"></i>
                        <h4 class="fw-bold text-light font-sans mb-1">Inquiry Docket Logged</h4>
                        <div class="badge font-mono border border-success text-success bg-dark py-1 px-3 mb-3" id="inquiryRefCode">#INQ-2026-9481</div>
                        <p class="text-secondary small font-sans mb-3 mx-auto" style="max-width: 420px;">
                            Your confidential forensic briefing has been securely queued. A Lead Incident Responder will review the parameters and reach out via encrypted communication.
                        </p>
                        <div class="font-mono small text-info">
                            Direct Emergency Dispatch: <a href="mailto:dspats1975@gmail.com" class="text-info fw-bold">dspats1975@gmail.com</a>
                        </div>
                    </div>

                    <!-- Intake Form -->
                    <form id="inquiryForm" onsubmit="handleInquirySubmit(event)" autocomplete="off" class="d-flex flex-column h-100">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="inq_company" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    Organization / Company Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-cyber" id="inq_company" placeholder="e.g. Acme Financial Technologies" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inq_email" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    Official Work Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-cyber" id="inq_email" placeholder="ciso@organization.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inq_urgency" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                Engagement Urgency &amp; Objective <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="inq_urgency" required>
                                <option value="" disabled selected>Select Incident Urgency...</option>
                                <option value="critical">🚨 Critical: Active Incursion / Data Breach (Immediate Emergency SLA)</option>
                                <option value="insider">⚠️ Urgent: Suspected Insider Threat / Account Compromise</option>
                                <option value="audit">🔍 Forensic Audit: Retrospective Post-Mortem &amp; Evidence Review</option>
                                <option value="enterprise">🏢 Enterprise Deployment: On-Premises Perimeter Architecture</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small font-mono mb-1 d-block" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                Scope of Evidence / Log Sources
                            </label>
                            <div class="d-flex flex-wrap gap-2 font-mono small">
                                <label class="badge border border-secondary border-opacity-40 text-secondary bg-dark d-flex align-items-center gap-1 p-2" style="cursor: pointer;">
                                    <input type="checkbox" name="sources[]" value="windows" class="form-check-input mt-0 me-1"> Windows Event Logs
                                </label>
                                <label class="badge border border-secondary border-opacity-40 text-secondary bg-dark d-flex align-items-center gap-1 p-2" style="cursor: pointer;">
                                    <input type="checkbox" name="sources[]" value="firewall" class="form-check-input mt-0 me-1"> Perimeter Firewalls / VPN
                                </label>
                                <label class="badge border border-secondary border-opacity-40 text-secondary bg-dark d-flex align-items-center gap-1 p-2" style="cursor: pointer;">
                                    <input type="checkbox" name="sources[]" value="linux" class="form-check-input mt-0 me-1"> Linux SSH / Syslog
                                </label>
                                <label class="badge border border-secondary border-opacity-40 text-secondary bg-dark d-flex align-items-center gap-1 p-2" style="cursor: pointer;">
                                    <input type="checkbox" name="sources[]" value="cloud" class="form-check-input mt-0 me-1"> Cloud Audit (AWS/GCP/Azure)
                                </label>
                                <label class="badge border border-secondary border-opacity-40 text-secondary bg-dark d-flex align-items-center gap-1 p-2" style="cursor: pointer;">
                                    <input type="checkbox" name="sources[]" value="web" class="form-check-input mt-0 me-1"> Web Application Feeds
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="inq_details" class="form-label text-secondary small font-mono mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                Incident Scope &amp; Brief Description
                            </label>
                            <textarea class="form-control form-control-cyber" id="inq_details" rows="3" placeholder="Brief outline of observed anomalies, anomalous IP footprints, affected systems, or specific investigative goals..."></textarea>
                        </div>

                        <div class="mt-auto pt-2">
                            <button type="submit" class="btn btn-cyber-primary w-100 py-3 font-mono fw-bold d-flex align-items-center justify-content-center gap-2">
                                <span>Transmit Confidential Inquiry</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                            <div class="d-flex justify-content-between align-items-center mt-3 small font-mono text-muted" style="font-size: 0.72rem;">
                                <span><i class="bi bi-shield-check text-success me-1"></i> Strict NDA Protocol</span>
                                <span>Emergency Dispatch: <a href="mailto:dspats1975@gmail.com" class="text-info text-decoration-none">dspats1975@gmail.com</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Trust & Assurance Badges Below Engagement Models -->
        <div class="row g-3 mt-4 pt-4 border-top border-secondary border-opacity-25 text-center font-mono small text-secondary">
            <div class="col-md-3 col-6">
                <i class="bi bi-shield-lock-fill text-info me-1"></i> End-to-End Cryptographic Custody
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-lightning-charge-fill text-danger me-1"></i> 2-Hour Emergency Response SLA
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-file-earmark-check-fill text-success me-1"></i> Court-Admissible Forensic Dossiers
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-hdd-network-fill text-warning me-1"></i> Zero-Knowledge On-Premises Ready
            </div>
        </div>
    </div>
</section>

<script>
function handleInquirySubmit(event) {
    event.preventDefault();
    const company = document.getElementById('inq_company').value;
    const email = document.getElementById('inq_email').value;
    const urgency = document.getElementById('inq_urgency').value;
    const details = document.getElementById('inq_details').value;

    const sources = Array.from(document.querySelectorAll('input[name="sources[]"]:checked')).map(cb => cb.value).join(', ');

    // Generate random incident reference docket
    const randCode = Math.floor(1000 + Math.random() * 9000);
    const docketId = '#INQ-2026-' + randCode;
    
    // Switch to success view
    const form = document.getElementById('inquiryForm');
    const successState = document.getElementById('inquirySuccessState');
    const refCodeEl = document.getElementById('inquiryRefCode');
    
    if (refCodeEl) refCodeEl.innerText = docketId;
    if (form) form.style.display = 'none';
    if (successState) successState.style.display = 'block';

    // Construct mailto backup for direct transmission
    const subject = encodeURIComponent(`[${docketId}] Investigation Inquiry: ${company} (${urgency})`);
    const body = encodeURIComponent(
        `INCIDENT INQUIRY BRIEF:\n` +
        `----------------------------------------\n` +
        `Docket Code: ${docketId}\n` +
        `Organization: ${company}\n` +
        `Contact Email: ${email}\n` +
        `Urgency Level: ${urgency}\n` +
        `Evidence Sources: ${sources || 'Not specified'}\n\n` +
        `Incident Summary & Scope:\n${details}\n` +
        `----------------------------------------\n` +
        `Transmitted via TraceLab Emergency Incident Desk`
    );

    // Also trigger mail client as backup channel
    setTimeout(() => {
        window.location.href = `mailto:dspats1975@gmail.com?subject=${subject}&body=${body}`;
    }, 1200);
}
</script>
