<?php

class Database {
    private $host = 'localhost'; // Your database host
    private $db_name = 'edoc'; // Your database name
    private $username = 'root'; // Your database username
    private $password = '12345'; // Your database password
    private static $instance = null; // Static property to hold the single instance
    public $conn;

    // Make the constructor private to prevent direct instantiation
    private function __construct() {
        $this->connect();
    }

    // Create a connection to the database
    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    // Public static method to get the single instance of the class
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to get the database connection
    public function getConnection() {
        return $this->conn;
    }
}
