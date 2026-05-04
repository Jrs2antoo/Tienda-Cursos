<?php
namespace Jrs2a\TiendaCursos\Core;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function connect(): PDO {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        // Comprueba que la conexión sigue viva, si no reconecta
        try {
            self::$connection->query('SELECT 1');
        } catch (PDOException $e) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    private static function createConnection(): PDO {
        $host   = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user   = $_ENV['DB_USER'];
        $pass   = $_ENV['DB_PASS'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}