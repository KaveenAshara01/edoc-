<?php
session_start();
require_once '../models/Database.php';
require_once '../models/PatientModel.php';

$database = new Database();
$db = $database->connect();
$patientModel = new PatientModel($db);

// Check if the user is logged in and if they are a patient
if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("Location: ../login.php");
    exit();
}

$useremail = $_SESSION["user"];

// Fetch patient information
$patient = $patientModel->getPatientByEmail($useremail);
if ($patient) {
    $userid = $patient["pid"];
    $username = $patient["pname"];
} else {
    header("Location: ../login.php");
    exit();
}

// Get today's date
date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

// Get the total counts for patients, doctors, appointments, and today's sessions
$totals = $patientModel->getTotalCounts($today);

// Get appointments for this patient
$appointments = $patientModel->getPatientAppointments($userid, $today);

// Store data in the session to pass it to the view
$_SESSION['totals'] = $totals;
$_SESSION['appointments'] = $appointments;
$_SESSION['username'] = $username;
$_SESSION['today'] = $today;

// Redirect to the dashboard view (instead of including it directly)
header('Location: ../views/patient/patient_dashboard.php');
exit();
