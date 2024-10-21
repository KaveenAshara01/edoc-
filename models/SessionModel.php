<?php
class SessionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch patient by email
    public function getPatientByEmail($email) {
        $sql = "SELECT * FROM patient WHERE pemail = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return as an associative array
    }

    // Fetch all sessions based on doctor name and date
    public function getSessions($doctorName, $today) {
        $sql = "SELECT schedule.*, doctor.docname, venue.name AS venue_name, venue.address AS venue_address 
                FROM schedule 
                INNER JOIN doctor ON schedule.docid = doctor.docid 
                INNER JOIN venue ON schedule.venue_id = venue.venue_id 
                WHERE schedule.scheduledate >= ? 
                AND LOWER(doctor.docname) LIKE LOWER(CONCAT('%', ?, '%'))
                ORDER BY schedule.scheduledate ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $today, $doctorName);
        $stmt->execute();
        $result = $stmt->get_result();

        // Convert result to an array of sessions
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        return $sessions; // Return the array of sessions
    }
}
