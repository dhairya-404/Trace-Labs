<div class="container py-5">
    <div class="text-center mb-5">
        <span class="badge border border-primary text-primary font-mono px-3 py-1 mb-2">SIEM LOG FORMAT DIRECTORY</span>
        <h1 class="fw-bold font-sans text-light">Enterprise Log Timeline &amp; Threat Analyzers</h1>
        <p class="text-secondary mx-auto font-sans" style="max-width: 650px;">
            In-depth guides, raw format breakdowns, and visual forensic timeline patterns for every major operating system, firewall, and authentication server log.
        </p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Windows Event 4624 -->
        <div class="col-md-6">
            <div class="feature-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-mono">WINDOWS SECURITY</span>
                    <span class="badge bg-secondary font-mono small">Event ID 4624 / 4625</span>
                </div>
                <h4 class="fw-bold text-light mb-2 font-sans">
                    <a href="/logs/windows-event-4624-logon-analyzer" class="text-light text-decoration-none hover-text-primary">
                        Windows Logon &amp; Kerberos Ticket Analyzer
                    </a>
                </h4>
                <p class="text-secondary small mb-3">
                    Analyze Windows Event Log ID 4624 (Successful Logon) and 4625 (Failed Logon). Reconstruct Pass-the-Hash, Kerberoasting, and abnormal off-hours interactive logons across Active Directory domain controllers.
                </p>
                <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 font-mono small">
                    <span class="text-secondary">Attack Vector: Credential Stuffing</span>
                    <a href="/logs/windows-event-4624-logon-analyzer" class="text-info text-decoration-none fw-bold">View Guide &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Palo Alto Firewall -->
        <div class="col-md-6">
            <div class="feature-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle font-mono">PERIMETER FIREWALL</span>
                    <span class="badge bg-secondary font-mono small">Traffic &amp; Threat Logs</span>
                </div>
                <h4 class="fw-bold text-light mb-2 font-sans">
                    <a href="/logs/palo-alto-traffic-exfiltration-timeline" class="text-light text-decoration-none hover-text-warning">
                        Palo Alto Traffic Egress &amp; Exfiltration Visualizer
                    </a>
                </h4>
                <p class="text-secondary small mb-3">
                    Parse PAN-OS traffic and threat flow logs. Timeline multi-gigabyte anomalous outbound TLS flows to overseas destination IPs, identify DNS tunneling, and isolate lateral subnet scans.
                </p>
                <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 font-mono small">
                    <span class="text-secondary">Attack Vector: Data Exfiltration</span>
                    <a href="/logs/palo-alto-traffic-exfiltration-timeline" class="text-warning text-decoration-none fw-bold">View Guide &rarr;</a>
                </div>
            </div>
        </div>

        <!-- SSH Auth Log -->
        <div class="col-md-6">
            <div class="feature-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle font-mono">LINUX AUTH.LOG</span>
                    <span class="badge bg-secondary font-mono small">sshd &amp; PAM Sessions</span>
                </div>
                <h4 class="fw-bold text-light mb-2 font-sans">
                    <a href="/logs/ssh-auth-log-brute-force-visualizer" class="text-light text-decoration-none hover-text-danger">
                        Linux SSH Authentication &amp; Brute-Force Triage
                    </a>
                </h4>
                <p class="text-secondary small mb-3">
                    Standardize Linux `/var/log/auth.log` records. Reconstruct rapid burst SSH connection attempts, detect distributed password sprays, and alert on sudo privilege escalations.
                </p>
                <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 font-mono small">
                    <span class="text-secondary">Attack Vector: SSH Password Spray</span>
                    <a href="/logs/ssh-auth-log-brute-force-visualizer" class="text-danger text-decoration-none fw-bold">View Guide &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Apache Web Access -->
        <div class="col-md-6">
            <div class="feature-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-info-subtle text-info border border-info-subtle font-mono">WEB SERVER ACCESS</span>
                    <span class="badge bg-secondary font-mono small">Combined Log Format</span>
                </div>
                <h4 class="fw-bold text-light mb-2 font-sans">
                    <a href="/logs/apache-access-log-analyzer" class="text-light text-decoration-none hover-text-info">
                        Apache &amp; Nginx Access Log Timeline Analyzer
                    </a>
                </h4>
                <p class="text-secondary small mb-3">
                    Ingest Nginx/Apache Combined Access Logs. Timeline automated directory fuzzing, SQL injection probes, and web shell execution trails with millisecond precision.
                </p>
                <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 font-mono small">
                    <span class="text-secondary">Attack Vector: Web Reconnaissance</span>
                    <a href="/logs/apache-access-log-analyzer" class="text-info text-decoration-none fw-bold">View Guide &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
