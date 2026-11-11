<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Database;
use Tracelabs\Core\Request;

class LandingController extends Controller
{
    private static array $articles = [
        'windows-event-4624-logon-analyzer' => [
            'slug' => 'windows-event-4624-logon-analyzer',
            'title' => 'Windows Event 4624/4625 Logon & Kerberos Analyzer',
            'category' => 'Active Directory & Windows Security',
            'source' => 'Windows Security Log / System Event Bus',
            'format' => 'Windows XML / EVTX / Syslog Forwarded Event',
            'target_swimlane' => 'Authentication',
            'triage_rule' => 'RULE-01: Rapid Failed Auth Burst',
            'description' => 'Comprehensive technical guide for parsing, timelining, and isolating Kerberos credential stuffing and abnormal off-hours interactive logons.',
            'schema' => 'timestamp_utc, EventID, TargetUserName, TargetDomainName, LogonType, IpAddress, WorkstationName, Status',
            'anatomy' => 'Event ID 4624 documents successful logons, while 4625 records failures. The most critical threat intelligence field is LogonType: Type 2 represents physical interactive console logons, Type 3 indicates network logons (SMB, RPC, PsExec lateral movement), and Type 10 represents Remote Desktop (RDP) sessions. When multiple Type 3 or Type 10 events occur outside corporate 9-to-5 operating windows from external or non-whitelisted IP addresses, they signal active lateral movement.',
            'sample_snippet' => "2026-11-07 02:14:05,4625,admin.finance,CORP_HQ,LogonType:10,198.51.100.44,DEV-EXT-999,0xC000006D\n2026-11-07 02:14:22,4625,admin.finance,CORP_HQ,LogonType:10,198.51.100.44,DEV-EXT-999,0xC000006D\n2026-11-07 02:14:41,4625,admin.finance,CORP_HQ,LogonType:10,198.51.100.44,DEV-EXT-999,0xC000006D\n2026-11-07 02:15:45,4624,admin.finance,CORP_HQ,LogonType:10,198.51.100.44,DEV-EXT-999,0x0\n2026-11-07 02:22:10,4672,admin.finance,CORP_HQ,SeDebugPrivilege,198.51.100.44,DEV-EXT-999,SpecialPrivilegesAssigned"
        ],
        'palo-alto-traffic-exfiltration-timeline' => [
            'slug' => 'palo-alto-traffic-exfiltration-timeline',
            'title' => 'Palo Alto Perimeter Traffic Egress & Exfiltration Visualizer',
            'category' => 'Next-Gen Firewall Telemetry',
            'source' => 'PAN-OS Traffic & Threat Logs',
            'format' => 'RFC 5424 Syslog / JSON Flow Export',
            'target_swimlane' => 'Network Flows',
            'triage_rule' => 'RULE-02: Volumetric Egress Anomaly',
            'description' => 'Detect multi-gigabyte sensitive database egress streams, covert DNS tunneling, and outbound Command & Control beacons.',
            'schema' => 'receive_time, src_ip, dst_ip, src_port, dst_port, app, bytes_sent, bytes_received, session_end_reason',
            'anatomy' => 'Firewall traffic logs record bidirectional byte counters (bytes_sent vs. bytes_received). In typical user browsing, incoming bytes vastly exceed outgoing bytes. In data exfiltration events, this ratio violently flips: thousands of megabytes exit an internal file server towards an overseas cloud hosting provider or foreign IP over encrypted ports.',
            'sample_snippet' => "2026-11-07 03:00:15,10.0.1.50,198.51.100.44,443,ssl,45000,120000,aged-out\n2026-11-07 03:10:00,10.0.1.50,203.0.113.88,443,ssl,4800000000,45000,tcp-fin\n2026-11-07 03:25:00,10.0.1.50,203.0.113.88,443,ssl,120000,34000,aged-out"
        ],
        'ssh-auth-log-brute-force-visualizer' => [
            'slug' => 'ssh-auth-log-brute-force-visualizer',
            'title' => 'Linux /var/log/auth.log SSH Password Spray Triage',
            'category' => 'Linux Enterprise Servers',
            'source' => 'systemd-journald / rsyslog',
            'format' => 'Linux Auth Syslog Format',
            'target_swimlane' => 'Authentication',
            'triage_rule' => 'RULE-01: Rapid Failed Auth Burst',
            'description' => 'Reconstruct high-frequency SSH password sprays, analyze automated botnet dictionary attacks, and track sudo privilege transitions.',
            'schema' => 'timestamp_iso, hostname, daemon, pid, message, user, remote_ip, port',
            'anatomy' => 'SSH authentication events in Linux records provide immediate visibility into password spraying and credential dictionary attacks. Repeated Failed password for invalid user messages clustered within seconds indicate automated tooling like Hydra or Medusa. An immediate Accepted password following bursts signifies a breached perimeter host.',
            'sample_snippet' => "Nov 07 02:14:05 web01 sshd[14201]: Failed password for root from 198.51.100.44 port 49152 ssh2\nNov 07 02:14:22 web01 sshd[14205]: Failed password for admin from 198.51.100.44 port 49153 ssh2\nNov 07 02:14:41 web01 sshd[14210]: Failed password for deploy from 198.51.100.44 port 49154 ssh2\nNov 07 02:15:45 web01 sshd[14218]: Accepted password for admin from 198.51.100.44 port 49155 ssh2"
        ],
        'apache-access-log-analyzer' => [
            'slug' => 'apache-access-log-analyzer',
            'title' => 'Apache & Nginx Access Log Timeline & Web Recon Analyzer',
            'category' => 'Web Application Infrastructure',
            'source' => 'Apache httpd / Nginx Access Log',
            'format' => 'NCSA Combined Log Format',
            'target_swimlane' => 'Host & Files',
            'triage_rule' => 'RULE-03: Web Exploitation & Directory Traversal',
            'description' => 'Analyze web application reconnaissance, automated directory traversal scans, and SQL injection attempt timestamps.',
            'schema' => 'client_ip, identity, user, timestamp, request_method, request_uri, protocol, http_status, bytes_sent, user_agent',
            'anatomy' => 'Web server access logs highlight reconnaissance and exploitation phases in real time. Spikes in 404 Not Found responses over milliseconds represent aggressive path enumeration, while 200 OK responses to sensitive admin endpoints or file upload handlers expose potential web shell uploads and Remote Code Execution (RCE).',
            'sample_snippet' => "198.51.100.44 - - [07/Nov/2026:02:10:01 +0000] \"GET /.env HTTP/1.1\" 404 196 \"-\" \"curl/7.88.1\"\n198.51.100.44 - - [07/Nov/2026:02:10:04 +0000] \"GET /wp-config.php HTTP/1.1\" 404 196 \"-\" \"curl/7.88.1\"\n198.51.100.44 - - [07/Nov/2026:02:10:08 +0000] \"POST /api/upload.php HTTP/1.1\" 200 48 \"-\" \"python-requests/2.31.0\""
        ]
    ];

    public function index(Request $request): void
    {
        $this->view('landing/index', [
            'pageTitle' => 'TraceLab — Digital Activity Forensics & Incident Triage Platform',
            'metaDescription' => 'The forensic detective desk for digital event logs. Ingest heterogeneous logs, compute SHA-256 non-repudiation digests, reconstruct timeline swimlanes, and triage threats with hybrid rules + ML.',
            'metaKeywords' => 'digital forensics, log normalization, timeline reconstruction, SIEM, incident response, DFIR, entity linking, anomaly detection, isolation forest'
        ], 'landing');
    }

    public function playground(Request $request): void
    {
        $this->view('playground/index', [
            'pageTitle' => 'Interactive SIEM Log Playground — TraceLab',
            'metaDescription' => 'Free client-side security utility. Paste raw server or firewall logs to calculate instant SHA-256 evidence digests and render interactive chronological timeline swimlanes.',
            'metaKeywords' => 'free log parser, log timeline generator, SHA256 log hash, forensic playground, DFIR tool, vis-timeline online'
        ], 'landing');
    }

    public function logsIndex(Request $request): void
    {
        $this->view('logs/index', [
            'pageTitle' => 'SIEM Log Format Directory — TraceLab',
            'metaDescription' => 'Explore in-depth technical guides, raw schema breakdowns, and timeline patterns for Windows Event 4624, Palo Alto Firewalls, SSH auth logs, and Apache web access.',
            'metaKeywords' => 'windows event 4624, palo alto firewall logs, ssh auth log, apache access log, SIEM log formats, log normalization guides'
        ], 'landing');
    }

    public function logsShow(Request $request, array $params): void
    {
        $slug = $params['slug'] ?? '';
        if (!isset(self::$articles[$slug])) {
            $this->redirect('/logs');
            return;
        }

        $article = self::$articles[$slug];

        $this->view('logs/show', [
            'pageTitle' => "{$article['title']} — TraceLab",
            'metaDescription' => $article['description'],
            'metaKeywords' => "{$article['slug']}, {$article['category']}, {$article['target_swimlane']}, forensic log analysis",
            'article' => $article
        ], 'landing');
    }

    /**
     * Lightweight readiness and telemetry health-check endpoint for uptime probes.
     */
    public function health(Request $request): void
    {
        $dbHealthy = false;
        try {
            Database::getConnection()->query('SELECT 1');
            $dbHealthy = true;
        } catch (\Throwable $e) {
            $dbHealthy = false;
        }

        $statusCode = $dbHealthy ? 200 : 503;
        $this->json([
            'status' => $dbHealthy ? 'healthy' : 'degraded',
            'service' => 'tracelab-forensics',
            'version' => '1.0.0',
            'php_version' => PHP_VERSION,
            'database' => $dbHealthy ? 'connected' : 'unavailable',
            'timestamp_utc' => gmdate('Y-m-d\TH:i:s\Z'),
        ], $statusCode);
    }
}
