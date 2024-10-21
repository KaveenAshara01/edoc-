<?php

class Database {
    private $host = 'localhost'; // Your database host
    private $db_name = 'edoc'; // Your database name
    private $username = 'root'; // Your database username
    private $password = '12345'; // Your database password
    public $conn;

    // Create a connection to the database
    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
