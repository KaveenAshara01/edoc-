<?php
session_start();

if (isset($_SESSION["user"])) {
    if (empty($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
        exit();
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
    exit();
}

include("../models/BookingModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'Pay' button was clicked
    if (isset($_POST["scheduleid"])) {
        // Get the schedule ID and user ID from the session and form
        $scheduleid = $_POST["scheduleid"];
        $userid = $_SESSION['userid'];

        // Create a new booking without any card validation (handled client-side)
        $bookingModel = new BookingModel();
        $apponum = $bookingModel->createAppointment($scheduleid, $userid);

        if ($apponum) {
            // Redirect to 'appointment.php' with a success message
            header("Location: ../views/patient/appointment.php");
            exit();
        } else {
            echo "Failed to book the appointment. Please try again.";
        }
    } else {
        echo "Invalid request.";
    }
}
?>
