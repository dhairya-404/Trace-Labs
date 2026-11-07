<?php
declare(strict_types=1);

/**
 * Tracelabs System Configuration
 * Digital Forensics & Incident Investigation Platform
 */

return [
    'app_name' => 'TRACELABS // DFIR',
    'app_env' => 'development',
    'version' => '1.0.0-PROD',
    'timezone' => 'UTC',
    
    // Database Configuration (SQLite default with PDO; MySQL ready)
    'db' => [
        'driver' => 'sqlite',
        'database' => __DIR__ . '/../database/tracelabs.sqlite',
        // Optional MySQL configuration
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
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
