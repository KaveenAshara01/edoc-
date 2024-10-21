<?php
session_start();
require_once '../models/Database.php';
require_once '../models/DoctorModel.php';

// Check if the user is logged in and is an admin (change based on your requirements)
if (!isset($_SESSION["user"]) ) {
    header("Location: ../views/login.php");
    exit();
}

// Initialize database connection
$database = new Database();
$db = $database->connect();
$doctorModel = new DoctorModel($db);

// Handle GET and POST requests
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$keyword = isset($_POST['search']) ? $_POST['search'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    // Handling form submission to add new doctor
    $name = $_POST['name'];
    $email = $_POST['email'];
    $nic = $_POST['nic'];
    $tele = $_POST['Tele'];
    $spec = $_POST['spec'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if passwords match
    if ($password !== $cpassword) {
        header("Location: ../views/admin/add_doctor.php?action=add&error=2");  // Error: Password mismatch
        exit();
    }

    // Check if email already exists
    if ($doctorModel->emailExists($email)) {
        header("Location: ../views/admin/add_doctor.php?action=add&error=1");  // Error: Email already exists
        exit();
    }

    // Add doctor to database
    if ($doctorModel->createDoctor($name, $email, $password, $nic, $tele, $spec)) {
        header("Location: ../views/admin/doctors.php?action=add&success=1");  // Success: Doctor added
        exit();
    } else {
        header("Location: ../views/admin/add_doctor.php?action=add&error=3");  // Error: General error
        exit();
    }

} elseif ($action == 'view' && $id) {
    // Fetch specific doctor details
    $doctor = $doctorModel->getDoctorById($id);
    $specialtyName = $doctorModel->getSpecialtyById($doctor['specialties']);

    // Store doctor details in session
    $_SESSION['doctor'] = $doctor;
    $_SESSION['specialty'] = $specialtyName;

    // Redirect to the doctor view page
    header('Location: ../views/patient/view_doctor.php');
    exit();

} elseif ($action == 'session' && $id) {
    // Redirect to the SessionController with the doctor ID
    $_SESSION['doctor_name'] = $_GET['name'];
    header('Location: ../controllers/SessionController.php?action=view&id=' . $id);
    exit();
} else {
    // Fetch all doctors or search by keyword
    $doctors = $doctorModel->getAllDoctors($keyword); 

    // Store the list of doctors in session and redirect to the doctors listing page
    $_SESSION['doctors'] = $doctors;
    $specialtyName = $doctorModel->getSpecialtyById($doctor['specialties']);
    $_SESSION['specialty'] = $specialtyName;
    header('Location: ../views/patient/doctors.php');
    exit();
}
