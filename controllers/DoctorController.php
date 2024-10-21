<?php
session_start();
require_once '../models/Database.php';
require_once '../models/DoctorModel.php';

// Check if the user is logged in and is a patient
if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->connect();
$doctorModel = new DoctorModel($db);

// Handle GET and POST requests
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$keyword = isset($_POST['search']) ? $_POST['search'] : null;

if ($action == 'view' && $id) {
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
}
 else {
    $doctors = $doctorModel->getAllDoctors($keyword); // Fetching doctors

// // Debugging to ensure doctors are fetched
// if (empty($doctors)) {
//     echo 'No doctors found in database.';
// } else {
//     echo '<pre>';
//     print_r($doctors); // This will print the doctors array
//     echo '</pre>';
//     exit(); // Exit to check the output
// }

$_SESSION['doctors'] = $doctors;
header('Location: ../views/patient/doctors.php');
exit();

}
?>
