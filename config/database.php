<?php
class Database {
    private $host = "localhost";
    private $dbname = "athena";
    private $username = "root";
    private $password = "123456789";
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new DatabaseException("Connection failed: " . $e->getMessage());
        }
        return $this->conn;
    }
}

class DatabaseException extends Exception {}