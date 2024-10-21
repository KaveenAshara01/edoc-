<?php
class UserModel {
    private $db;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->db = $db;
    }

    // Function to fetch user by email from the webuser table
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Returns user data or null if not found
    }

    // Function to check patient credentials
    public function getPatientByEmailAndPassword($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM patient WHERE pemail = ? AND ppassword = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Returns patient data or null if not found
    }

    // Function to check admin credentials
    public function getAdminByEmailAndPassword($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE aemail = ? AND apassword = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Returns admin data or null if not found
    }

    // Function to check doctor credentials
    public function getDoctorByEmailAndPassword($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM doctor WHERE docemail = ? AND docpassword = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Returns doctor data or null if not found
    }


    // Check if email already exists in the webuser table
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Insert into the patient table
    public function createPatient($email, $name, $password, $address, $nic, $dob, $tele) {
        $stmt = $this->db->prepare("INSERT INTO patient (pemail, pname, ppassword, paddress, pnic, pdob, ptel) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $email, $name, $password, $address, $nic, $dob, $tele);
        return $stmt->execute();  // Return true if the insertion was successful
    }

    // Insert into the webuser table
    public function createWebUser($email) {
        $stmt = $this->db->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 'p')");
        $stmt->bind_param("s", $email);
        return $stmt->execute();  // Return true if the insertion was successful
    }

}
