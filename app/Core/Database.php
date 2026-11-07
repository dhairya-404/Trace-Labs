<?php
declare(strict_types=1);

namespace Tracelabs\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config.php';
            $dbConfig = $config['db'];

            try {
                if ($dbConfig['driver'] === 'sqlite') {
                    $dbPath = $dbConfig['database'];
                    $dbDir = dirname($dbPath);
                    if (!is_dir($dbDir)) {
                        mkdir($dbDir, 0777, true);
                    }
                    $isNew = !file_exists($dbPath);

                    self::$instance = new PDO("sqlite:" . $dbPath);
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    self::$instance->exec('PRAGMA foreign_keys = ON;');

                    if ($isNew || filesize($dbPath) === 0) {
                        self::initializeSchema(self::$instance);
                    }
                } else {
                    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset={$dbConfig['charset']}";
                    self::$instance = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                die("Forensic Database Connection Failure: " . htmlspecialchars($e->getMessage()));
            }
        }

        return self::$instance;
    }

    private static function initializeSchema(PDO $pdo): void
    {
        $schemaFile = __DIR__ . '/../../database/schema.sql';
        $seedFile = __DIR__ . '/../../database/seed.sql';

        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            $pdo->exec($sql);
        }

        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            $pdo->exec($seedSql);
        }
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetch(string $sql, array $params = []): ?array
    {
        $res = self::query($sql, $params)->fetch();
        return $res ?: null;
    }

    public static function lastInsertId(): string
    {
        return self::getConnection()->lastInsertId();
    }
}
