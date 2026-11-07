-- TraceLab 6th-Semester Project Seed Data

-- 1. Default Investigator Account (analyst@tracelab.local / tracelab2026)
INSERT OR IGNORE INTO users (id, name, email, password_hash, role)
VALUES (1, 'Lead Investigator', 'analyst@tracelab.local', '$2y$10$wNqvP8RkW8xR9f7Uj9iS0e0jYn0qZ9R1yY3v5B4o6F2a0E1m5p0eK', 'Lead Examiner');

-- 2. Initial Investigation Workspace
INSERT OR IGNORE INTO investigations (id, title, description, lead_analyst, status)
VALUES (1, 'Incident Alpha: Credential Stuffing & Exfiltration', 
'Multi-source log triage investigating unauthorized remote access, lateral movement, and outbound sensitive data transfer.',
'Lead Investigator', 'Active');
