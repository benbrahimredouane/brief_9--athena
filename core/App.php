<?php
class App {
    private $db;

    public function __construct() {
        session_start();
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getConnection() {
        return $this->db;
    }

    public static function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    public static function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public static function hasRole($role) {
        return $_SESSION['user_role'] === $role;
    }
}