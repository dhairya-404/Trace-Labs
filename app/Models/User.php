<?php
declare(strict_types=1);

namespace Tracelabs\Models;

use Tracelabs\Core\Database;

class User
{
    public static function findByEmail(string $email): ?array
    {
        return Database::fetch("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    }

    public static function authenticate(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return null;
    }

    public static function seedDefaultUser(): void
    {
        $users = [
            [
                'name' => 'Lead Investigator',
                'email' => 'analyst@tracelab.local',
                'hash' => password_hash('tracelab2026', PASSWORD_DEFAULT),
                'role' => 'Lead Examiner'
            ],
            [
                'name' => 'Alex Rivera',
                'email' => 'responder@tracelab.local',
                'hash' => password_hash('responder2026', PASSWORD_DEFAULT),
                'role' => 'Incident Responder'
            ],
            [
                'name' => 'Dr. Maya Lin',
                'email' => 'intel@tracelab.local',
                'hash' => password_hash('intel2026', PASSWORD_DEFAULT),
                'role' => 'Threat Intel Analyst'
            ],
            [
                'name' => 'Sarah Sterling, Esq.',
                'email' => 'auditor@tracelab.local',
                'hash' => password_hash('auditor2026', PASSWORD_DEFAULT),
                'role' => 'Legal Auditor'
            ]
        ];

        foreach ($users as $u) {
            $existing = self::findByEmail($u['email']);
            if (!$existing) {
                Database::query(
                    "INSERT INTO users (name, email, password_hash, role)
                     VALUES (:name, :email, :hash, :role)",
                    [
                        'name' => $u['name'],
                        'email' => $u['email'],
                        'hash' => $u['hash'],
                        'role' => $u['role']
                    ]
                );
            }
        }
    }
}
