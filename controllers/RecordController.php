<?php
session_start();
require_once '../models/RecordModel.php';

class RecordController {
    public function __construct() {
        $this->model = new RecordModel();
    }

    public function handleRequest() {
        // Check for GET and POST methods
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
            if ($_GET['action'] === 'addRecordForm') {
                $this->showAddRecordForm();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'addRecord') {
                $this->addRecord();
            }
        }
    }

    private function showAddRecordForm() {
        // Validate patient ID
        if (isset($_GET['pid'])) {
            $patientId = $_GET['pid'];
            // Redirect to the add record form view (without including it directly)
            header("Location: ../views/doctor/add_record_view.php?pid=$patientId");
        } else {
            header('location: ../views/doctor/patient.php');
        }
    }

    private function addRecord() {


        

 
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../views/connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];

    // Retrieve doctor ID using the session email
    $doctor_email = $_SESSION["user"];
    $doctor_query = "SELECT docid FROM doctor WHERE docemail='$doctor_email'";
    $doctor_result = $database->query($doctor_query);

    if ($doctor_result->num_rows == 1) {
        $doctor = $doctor_result->fetch_assoc();
        $doctorId = $doctor["docid"];
    } else {
        echo "Doctor not found.";
        exit();
    }

        // Handle adding the record after form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recordName = $_POST["record_name"];
            $details = $_POST["details"];
            $patientId = $_POST["pid"];
            // $doctorId = $_SESSION["docid"]; // Assuming doctor ID is stored in session

            // Use model to add the record
            if ($this->model->addRecord($patientId, $doctorId, $recordName, $details)) {
                header("location: ../views/doctor/records.php?pid=$patientId");
            } else {
                echo "Failed to add record.";
            }
        }
    }
}


// Create an instance of RecordController and handle the request
$controller = new RecordController();
$controller->handleRequest();
