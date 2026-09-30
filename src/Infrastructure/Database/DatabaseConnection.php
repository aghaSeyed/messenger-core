<?php

declare(strict_types=1);

namespace Paya\Infrastructure\Database;

use PDO;
use PDOException;

final class DatabaseConnection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../../config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new \RuntimeException(
                    'Database connection failed: ' . $e->getMessage(),
                    (int) $e->getCode(),
                    $e
                );
            }
        }

        return self::$instance;
    }

    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
