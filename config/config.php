<?php
declare(strict_types=1);

/**
 * Tracelabs System Configuration
 * Digital Forensics & Incident Investigation Platform
 */

// Determine SQLite path (supports persistent local storage or serverless writable /tmp on Vercel)
$sqlitePath = __DIR__ . '/../database/tracelabs.sqlite';
if (getenv('VERCEL') || (!is_writable(dirname($sqlitePath)) && !is_writable($sqlitePath))) {
    $tmpDb = sys_get_temp_dir() . '/tracelabs.sqlite';
    if (!file_exists($tmpDb) && file_exists($sqlitePath)) {
        @copy($sqlitePath, $tmpDb);
    }
    $sqlitePath = $tmpDb;
}

return [
    'app_name' => 'TRACELABS // DFIR',
    'app_env' => getenv('APP_ENV') ?: 'development',
    'version' => '1.0.0-PROD',
    'timezone' => 'UTC',
    
    // Database Configuration (SQLite default with PDO; MySQL ready)
    'db' => [
        'driver' => 'sqlite',
        'database' => $sqlitePath,
        // Optional MySQL configuration
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int)(getenv('DB_PORT') ?: 3306),
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4'
    ],

    // Security & Hash Algorithms for Forensic Verification
    'forensics' => [
        'primary_hash' => 'sha256',
        'secondary_hash' => 'md5',
        'investigator_roles' => ['Lead Examiner', 'Incident Responder', 'Malware Analyst', 'Evidence Custodian', 'Legal Auditor'],
        'default_retention_days' => 365,
    ]
];
