<?php
session_start();
require_once '../models/Database.php';  
require_once '../models/UserModel.php'; 

// $database = new Database();
// $db = $database->connect();

$dbInstance = Database::getInstance();
$db = $dbInstance->getConnection();

$userModel = new UserModel($db);  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nic = $_SESSION['personal']['nic'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    
    if ($newpassword === $cpassword) {
        // Check if email already exists
        if ($userModel->emailExists($email)) {
            $error = '<label style="color:rgb(255, 62, 62);text-align:center;">An account already exists with this email address.</label>';
            include '../views/createAccount.php';
        } else {
           
            $userModel->createPatient($email, $name, $newpassword, $address, $nic, $dob, $tele);
            $userModel->createWebUser($email);

            
            $_SESSION["user"] = $email;
            $_SESSION["usertype"] = "p";
            $_SESSION["username"] = $fname;

            header('Location: /edoc/edoc-/controllers/PatientController.php');
            exit();
        }
    } else {
        $error = '<label style="color:rgb(255, 62, 62);text-align:center;">Passwords do not match. Please reconfirm.</label>';
        include '../views/createAccount.php';
    }
} else {
    header("Location:  ../views/patient/index.php");
    exit();
}
