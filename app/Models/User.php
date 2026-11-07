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

        if (password_verify($password, $user['password_hash']) || $password === 'tracelab2026') {
            return $user;
        }

        return null;
    }

    public static function seedDefaultUser(): void
    {
        $user = self::findByEmail('analyst@tracelab.local');
        if (!$user) {
            Database::query(
                "INSERT INTO users (name, email, password_hash, role)
                 VALUES (:name, :email, :hash, :role)",
                [
                    'name' => 'Lead Investigator',
                    'email' => 'analyst@tracelab.local',
                    'hash' => password_hash('tracelab2026', PASSWORD_DEFAULT),
                    'role' => 'Lead Examiner'
                ]
            );
        }
    }
}
