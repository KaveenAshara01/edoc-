<?php
session_start();


if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}

// Import database
include("../connection.php");
$userrow = $database->query("SELECT * FROM doctor WHERE docemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["docid"];
$username = $userfetch["docname"];

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

    <style>



input[type="text"], textarea {
    width: 80%;
    padding: 10px;
    margin: 10px 0;
    border: 2px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    font-family: Arial, sans-serif;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus, textarea:focus {
    border-color: #4A90E2;
    box-shadow: 0 0 8px rgba(74, 144, 226, 0.6);
    outline: none;
}

textarea {
    resize: none;
}

.login-btn {
    margin-top: 20px;
    cursor: pointer;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

input[type="submit"] {
    font-size: 18px;
    padding: 15px 30px;
    background-color: #4A90E2;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #357ABD;
}



    </style>
</head>
<body>


<div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>

    <div class="container">
        <div class="dash-body">
            <table border="0" width="100%" style="margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="../doctor/records.php?pid=<?= $patientId; ?>">
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
