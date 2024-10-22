<?php
session_start();
require_once '../models/Database.php';
require_once '../models/SessionModel.php';

// $database = new Database();
// $db = $database->connect();

$dbInstance = Database::getInstance();
$db = $dbInstance->getConnection();

$sessionModel = new SessionModel($db);


if (!isset($_SESSION["user"]) || ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'p')) {
    header("Location: ../views/login.php");
    exit();
}

$useremail = $_SESSION["user"];
$today = date('Y-m-d');


$patient = $sessionModel->getPatientByEmail($useremail);
if ($patient) {
    $_SESSION['userid'] = $patient["pid"];
    $_SESSION['username'] = $patient["pname"];
} else {
    header("Location: ../views/login.php");
    exit();
}


$doctorName = isset($_POST['search']) ? $_POST['search'] : '';


$sessions = $sessionModel->getSessions($doctorName, $today);


$_SESSION['doctorName'] = $doctorName;
$_SESSION['sessions'] = $sessions;


header("Location: ../views/patient/session.php");
exit();
