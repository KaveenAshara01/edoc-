<?php
require_once 'Database.php';

class RecordModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); 
    }

    public function addRecord($patientId, $doctorId, $recordName, $details) {
        $stmt = $this->db->prepare("INSERT INTO records (patient_id, doctor_id, record_name, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $patientId, $doctorId, $recordName, $details);
        return $stmt->execute();
    }
}
