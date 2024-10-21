<?php
class DoctorModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch all doctors or search for a specific doctor
    public function getAllDoctors($keyword = null) {
        if ($keyword) {
            $stmt = $this->db->prepare("SELECT * FROM doctor WHERE docemail=? OR docname=? OR docname LIKE ? OR docname LIKE ? OR docname LIKE ?");
            $likeKeyword = "%$keyword%";
            $stmt->bind_param("sssss", $keyword, $keyword, $likeKeyword, $likeKeyword, $likeKeyword);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM doctor ORDER BY docid DESC");
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $doctors = [];

        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }

        $stmt->close();
        return $doctors;
    }

    // Fetch a single doctor's details by ID
    public function getDoctorById($docid) {
        $stmt = $this->db->prepare("SELECT * FROM doctor WHERE docid=?");
        $stmt->bind_param("i", $docid);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctor = $result->fetch_assoc();
        $stmt->close();

        return $doctor;
    }

    // Get the specialties name by specialty ID
    public function getSpecialtyById($spe) {
        $stmt = $this->db->prepare("SELECT sname FROM specialties WHERE id=?");
        $stmt->bind_param("s", $spe);
        $stmt->execute();
        $result = $stmt->get_result();
        $specialty = $result->fetch_assoc();
        $stmt->close();

        return $specialty['sname'];
    }



    // Function to check if email already exists in the webuser table
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Function to create a new doctor
    public function createDoctor($name, $email, $password, $nic, $tele, $spec) {
        // Insert into doctor table
        $stmt1 = $this->db->prepare("INSERT INTO doctor (docemail, docname, docpassword, docnic, doctel, specialties) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssssi", $email, $name, $password, $nic, $tele, $spec);

        // Insert into webuser table
        $stmt2 = $this->db->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 'd')");
        $stmt2->bind_param("s", $email);

        return $stmt1->execute() && $stmt2->execute();
    }

}
?>
