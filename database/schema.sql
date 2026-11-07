-- TraceLab 6th-Semester Project Database Schema
-- Digital Activity Log Normalization, Timeline, Entity-Linking & Dual-Engine Anomaly Detection

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(64) DEFAULT 'Investigator',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS investigations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    lead_analyst VARCHAR(128) NOT NULL,
    status VARCHAR(64) DEFAULT 'Active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS raw_files (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    filename VARCHAR(255) NOT NULL,
    file_format VARCHAR(32) NOT NULL,
    sha256_hash VARCHAR(64) NOT NULL,
    file_size INTEGER DEFAULT 0,
    raw_event_count INTEGER DEFAULT 0,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    file_id INTEGER NOT NULL,
    raw_line_number INTEGER DEFAULT 0,
    timestamp DATETIME NOT NULL,
    account VARCHAR(128) DEFAULT 'unknown',
    ip_address VARCHAR(64) DEFAULT '0.0.0.0',
    device_id VARCHAR(128) DEFAULT 'unassigned',
    action VARCHAR(128) NOT NULL,
    status VARCHAR(64) NOT NULL,
    details TEXT,
    raw_data_json TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    FOREIGN KEY (file_id) REFERENCES raw_files(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS entities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    type VARCHAR(32) NOT NULL, -- 'account', 'ip', 'device'
    value VARCHAR(128) NOT NULL,
    event_count INTEGER DEFAULT 1,
    first_seen DATETIME NOT NULL,
    last_seen DATETIME NOT NULL,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    UNIQUE(investigation_id, type, value)
);

CREATE TABLE IF NOT EXISTS entity_links (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    source_entity_id INTEGER NOT NULL,
    target_entity_id INTEGER NOT NULL,
    relation_type VARCHAR(64) NOT NULL, -- 'authenticated_from', 'used_device', 'targeted'
    event_id INTEGER,
    weight INTEGER DEFAULT 1,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    FOREIGN KEY (source_entity_id) REFERENCES entities(id) ON DELETE CASCADE,
    FOREIGN KEY (target_entity_id) REFERENCES entities(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS findings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    investigation_id INTEGER NOT NULL,
    event_id INTEGER NOT NULL,
    detection_source VARCHAR(32) NOT NULL, -- 'RULE_BASED' or 'MACHINE_LEARNING'
    rule_name VARCHAR(128),
    severity VARCHAR(32) NOT NULL DEFAULT 'MEDIUM', -- 'CRITICAL', 'HIGH', 'MEDIUM', 'LOW'
    plain_english_reason TEXT NOT NULL,
    ml_anomaly_score REAL DEFAULT 0.0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (investigation_id) REFERENCES investigations(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
