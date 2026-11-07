-- TraceLab Enterprise Multi-Role Seed Data

-- 1. Default DFIR Team Accounts
-- Lead Investigator (analyst@tracelab.local / tracelab2026)
INSERT OR IGNORE INTO users (id, name, email, password_hash, role)
VALUES (1, 'Lead Investigator', 'analyst@tracelab.local', '$2y$10$wNqvP8RkW8xR9f7Uj9iS0e0jYn0qZ9R1yY3v5B4o6F2a0E1m5p0eK', 'Lead Examiner');

-- Incident Responder (responder@tracelab.local / responder2026)
INSERT OR IGNORE INTO users (id, name, email, password_hash, role)
VALUES (2, 'Alex Rivera', 'responder@tracelab.local', '$2y$10$3Yq9hJbK6k8K9v4z1b4o0O2w9n1rZ8Y2u3v4B5o6F1a0E2m4p1eL', 'Incident Responder');

-- Threat Intelligence Analyst (intel@tracelab.local / intel2026)
INSERT OR IGNORE INTO users (id, name, email, password_hash, role)
VALUES (3, 'Dr. Maya Lin', 'intel@tracelab.local', '$2y$10$8Xp8hIbJ5j7J8u3y0a3n9N1v8m0qY7X1t2u3A4n5E0z9D1l3o0dK', 'Threat Intel Analyst');

-- Legal & Compliance Auditor (auditor@tracelab.local / auditor2026)
INSERT OR IGNORE INTO users (id, name, email, password_hash, role)
VALUES (4, 'Sarah Sterling, Esq.', 'auditor@tracelab.local', '$2y$10$7Wo7gHaI4i6I7t2x9z2m8M0u7l9pX6W0s1t2Z3m4D9y8C0k2n9cJ', 'Legal Auditor');

-- 2. Initial Investigation Workspace
INSERT OR IGNORE INTO investigations (id, title, description, lead_analyst, status)
VALUES (1, 'Incident Alpha: Credential Stuffing & Exfiltration', 
'Multi-source log triage investigating unauthorized remote access, lateral movement, and outbound sensitive data transfer.',
'Lead Investigator', 'Active');
