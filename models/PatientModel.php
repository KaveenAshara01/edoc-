<?php
class PatientModel {
    private $db;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->db = $db;
    }

    // Get patient details by email
    public function getPatientByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM patient WHERE pemail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Return patient data
    }

    // Get all doctors
    public function getAllDoctors() {
        $result = $this->db->query("SELECT * FROM doctor");
        return $result;
    }

    // Get today's schedules
    public function getTodaySchedules($today) {
        $stmt = $this->db->prepare("SELECT * FROM schedule WHERE scheduledate = ?");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get appointments for a patient for today and future dates
    // public function getPatientAppointments($patientId, $today) {
    //     $stmt = $this->db->prepare("SELECT * FROM schedule 
    //                                 INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
    //                                 INNER JOIN doctor ON schedule.docid = doctor.docid  
    //                                 WHERE appointment.pid = ? 
    //                                 AND schedule.scheduledate >= ?
    //                                 ORDER BY schedule.scheduledate ASC");
    //     $stmt->bind_param("is", $patientId, $today);
    //     $stmt->execute();
    //     return $stmt->get_result();
    // }


    public function getPatientAppointments($patientId, $today) {
        $stmt = $this->db->prepare("SELECT * FROM schedule 
                                    INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                                    INNER JOIN doctor ON schedule.docid = doctor.docid  
                                    WHERE appointment.pid = ? 
                                    AND schedule.scheduledate >= ?
                                    ORDER BY schedule.scheduledate ASC");
        $stmt->bind_param("is", $patientId, $today);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch all results into an associative array
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    
        // Close the statement
        $stmt->close();
    
        // Return the array of appointments
        return $appointments;
    }
    

    // Get total numbers for patients, doctors, appointments, and today's sessions
    public function getTotalCounts($today) {
        $patientCount = $this->db->query("SELECT * FROM patient")->num_rows;
        $doctorCount = $this->db->query("SELECT * FROM doctor")->num_rows;
        $appointmentCount = $this->db->query("SELECT * FROM appointment WHERE appodate >= '$today'")->num_rows;
        $scheduleCount = $this->db->query("SELECT * FROM schedule WHERE scheduledate = '$today'")->num_rows;
        
        return [
            'patients' => $patientCount,
            'doctors' => $doctorCount,
            'appointments' => $appointmentCount,
            'schedules' => $scheduleCount
        ];
    }
}
