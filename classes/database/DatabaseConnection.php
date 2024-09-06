<?php 

namespace database;


class DatabaseConnection
{
    private static $instance;
    private $pdo;

    private function __construct()
    {
        // $dsn = 'mysql:host=localhost;dbname=foodifyr';
        // $username = 'root';
        // $password = '';

        $dsn = 'mysql:host=localhost;dbname=social';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    // Additional methods for database operations...
}





?>