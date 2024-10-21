<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save the personal details into the session
    $_SESSION["personal"] = array(
        'fname'   => $_POST['fname'],
        'lname'   => $_POST['lname'],
        'address' => $_POST['address'],
        'nic'     => $_POST['nic'],
        'dob'     => $_POST['dob'],
    );

    // Redirect to the account creation page
    header("Location: /edoc/edoc-/views/createAccount.php");
    exit();
} else {
    // If the request is not POST, redirect back to the signup form
    header("Location: /edoc/edoc-/views/signup.php");
    exit();
}
