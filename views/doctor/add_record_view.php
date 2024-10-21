<?php
session_start();

// Ensure the user is logged in as a doctor
if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'd') {
    header("location: ../login.php");
    exit();
}

// Check if patient ID (pid) is set in the URL
if (isset($_GET['pid'])) {
    $patientId = $_GET['pid'];
} else {
    // If no patient ID is provided, redirect back to the patient list
    header("location: patient.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Add New Record</title>
</head>
<body>
    <div class="container">
        <div class="dash-body">
            <table border="0" width="100%" style="margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="../views/records.php?pid=<?= $patientId; ?>">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding:11px;width:125px">Back</button>
                        </a>
                    </td>
                    <td>
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)">
                            Add New Record
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <form action="../../controllers/RecordController.php" method="POST" style="margin-top: 20px;">
                                <input type="hidden" name="action" value="addRecord">
                                <input type="hidden" name="pid" value="<?= $patientId; ?>">
                                <input type="text" name="record_name" placeholder="Enter record name" required><br><br>
                                <textarea name="details" rows="10" cols="80" placeholder="Enter record details" required></textarea><br><br>
                                <input type="submit" value="Add Record" class="login-btn btn-primary btn" style="padding: 15px 50px;">
                            </form>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
