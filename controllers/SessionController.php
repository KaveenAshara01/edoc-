<?php
session_start();
require_once '../models/Database.php';
require_once '../models/SessionModel.php';

$database = new Database();
$db = $database->connect();
$sessionModel = new SessionModel($db);

// Ensure user is logged in
if (!isset($_SESSION["user"]) || ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'p')) {
    header("Location: ../views/login.php");
    exit();
}

$useremail = $_SESSION["user"];
$today = date('Y-m-d');

// Get the patient details
$patient = $sessionModel->getPatientByEmail($useremail);
if ($patient) {
    $_SESSION['userid'] = $patient["pid"];
    $_SESSION['username'] = $patient["pname"];
} else {
    header("Location: ../views/login.php");
    exit();
}

// Get doctor name from search input
$doctorName = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch sessions
$sessions = $sessionModel->getSessions($doctorName, $today);

// Store sessions and doctor name in session storage
$_SESSION['doctorName'] = $doctorName;
$_SESSION['sessions'] = $sessions;

// Redirect to the sessions view
header("Location: ../views/patient/session.php");
exit();
