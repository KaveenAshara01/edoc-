<?php
require_once '../models/UserModel.php';  // Assuming UserModel handles webuser table
require_once '../models/Database.php';   // Assuming Database handles the database connection

// Initialize the database connection
$database = new Database();
$db = $database->connect();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the form data
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    // Initialize UserModel to access the webuser table
    $userModel = new UserModel($db);

    // Check if the email exists in the webuser table
    $webuser = $userModel->getUserByEmail($email);  // Fetch user data from webuser table

    if ($webuser) {
        $usertype = $webuser['usertype'];  // Fetch usertype from webuser table
        
        // Now check the password in the relevant table based on the usertype
        if ($usertype === 'p') {
            // Check the patient's password
            $patient = $userModel->getPatientByEmailAndPassword($email, $password);
            if ($patient) {
                $_SESSION['user'] = $email;
                $_SESSION['usertype'] = 'p';
                header('Location:  /edoc/controllers/PatientController.php');
                exit();
            } else {
                $error = 'Invalid email or password for patient.';
            }

        } elseif ($usertype === 'a') {
            // Check the admin's password
            $admin = $userModel->getAdminByEmailAndPassword($email, $password);
            if ($admin) {
                $_SESSION['user'] = $email;
                $_SESSION['usertype'] = 'a';
                header('Location: /edoc/admin/index.php');
                exit();
            } else {
                $error = 'Invalid email or password for admin.';
            }

        } elseif ($usertype === 'd') {
            // Check the doctor's password
            $doctor = $userModel->getDoctorByEmailAndPassword($email, $password);
            if ($doctor) {
                $_SESSION['user'] = $email;
                $_SESSION['usertype'] = 'd';
                header('Location: /edoc/doctor/index.php');
                exit();
            } else {
                $error = 'Invalid email or password for doctor.';
            }
        }
    } else {
        $error = 'No account found for this email.';
    }
    
    // Include the view to re-display the login form with an error
    include '../views/login.php';
} else {
    // If it's a GET request, just show the login form
    include '../views/login.php';
}
