<?php
require_once 'Database.php';

class BookingModel {
    private $db;

    public function __construct() {
//         $dbInstance = Database::getInstance();
// $conn = $dbInstance->getConnection();

// $this->db =$conn;


$this->db = Database::getInstance()->getConnection();
        // $this->db = (new Database())->connect(); 
    }

    public function createAppointment($scheduleid, $userid) {
        // Fetch the max apponum and increment it using a prepared statement
        $stmt = $this->db->prepare("SELECT MAX(apponum) AS max_apponum FROM appointment");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $apponum = $row['max_apponum'] ? $row['max_apponum'] + 1 : 1;

        // Insert appointment into the database using a prepared statement
        $stmt = $this->db->prepare("INSERT INTO appointment (pid, apponum, scheduleid) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userid, $apponum, $scheduleid);
        $stmt->execute();

        // Return the apponum if the insertion was successful
        return $stmt->affected_rows > 0 ? $apponum : false;
    }
}
