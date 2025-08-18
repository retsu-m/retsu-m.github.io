<?php

class Database
{
    private static $pdo;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            // ROOT_PATH is defined in public/index.php
            $config = require ROOT_PATH . '/config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $config['user'], $config['password'], $options);
            } catch (\PDOException $e) {
                // In a real app, you'd log this error, not just throw it
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }
}
