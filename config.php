<?php

    class DatabaseConnection {
    private $HOSTNAME = "localhost";
    private $USERNAME = "root";
    private $PASSWORD = "";
    private $DATABASE = "restaurantbooking";
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->HOSTNAME};dbname={$this->DATABASE}";
            $this->conn = new PDO($dsn, $this->USERNAME, $this->PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Usage:
$database = new DatabaseConnection();
$pdo = $database->getConnection();
// Now you can use $pdo for your database operations.


?>