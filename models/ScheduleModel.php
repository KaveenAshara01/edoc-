<?php

require_once 'Database.php';
class ScheduleModel {
    private $db;

    // Constructor to initialize the database connection
    public function __construct() {


        $dbInstance = Database::getInstance();
$conn = $dbInstance->getConnection();

$this->db =$conn;

        // $this->db = (new Database())->connect();
    }

    // Function to add a session using prepared statements
    public function addSession($docid, $title, $date, $time, $nop, $venueid, $price) {
        // Prepare SQL query to insert session data
        $stmt = $this->db->prepare("INSERT INTO schedule (docid, title, scheduledate, scheduletime, nop, venue_id, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $this->db->error);
        }
        
        // Bind parameters and execute the statement
        $stmt->bind_param("issssii", $docid, $title, $date, $time, $nop, $venueid, $price);
        $result = $stmt->execute();

        // Check for execution errors
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }

        return $result; // Return true if the insertion was successful
    }

    // Function to retrieve all sessions
    public function getAllSessions() {
        $stmt = $this->db->prepare("SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime, schedule.nop 
                                    FROM schedule 
                                    INNER JOIN doctor ON schedule.docid = doctor.docid
                                    ORDER BY schedule.scheduledate DESC");
        if ($stmt === false) {
            die("Error preparing statement: " . $this->db->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Return all results as an associative array
    }

    // Function to get a session by its ID
    public function getSessionById($id) {
        $stmt = $this->db->prepare("SELECT * FROM schedule WHERE scheduleid = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Return the session data
    }
}
