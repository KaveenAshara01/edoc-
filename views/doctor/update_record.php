<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Update Record</title>
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
    

    
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];

    if (isset($_GET['id'])) {
        $record_id = $_GET['id'];
        $record_query = "SELECT * FROM records WHERE record_id='$record_id'";
        $record_result = $database->query($record_query);
        $record = $record_result->fetch_assoc();
    } else {
        header("location: patient.php");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       

        $record_name = $_POST['record_name'];
        $description = $_POST['description'];

        // // Update record in the database
        // $update_query = "UPDATE records SET record_name='$record_name', description='$description' WHERE record_id='$record_id'";
        // $database->query($update_query);


        // Prepare an SQL statement for safe execution
$stmt = $database->prepare("UPDATE records SET description = ?,record_name = ?  WHERE record_id = ?");

// Bind the parameters to the query
$stmt->bind_param("ssi",  $description, $record_name,$record_id);

// Execute the query
$stmt->execute();

header("location: records.php?pid=" . $record['patient_id']); // Redirect back to records
    }
    ?>
    

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
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>



   




<div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                    <a href="records.php?pid=<?php echo $record['patient_id']; ?>">
    <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
        <font class="tn-in-text">Back</font>
    </button>
</a>

                    </td>
                    <td>
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Update Record</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                        <form action="" method="post" style="margin-top: 20px;">
                        <label for="record_name">Name:</label>
                            <input type="text" name="record_name" value="<?php echo $record['record_name']; ?>" required><br><br>
                            <textarea  rows="10" cols="80" name="description" required><?php echo $record['description']; ?></textarea><br><br>
                            <input type="submit" value=" Update Record" class="login-btn btn-primary btn" style="padding: 15px 50px;">
                        </form>
                        </center>
                    </td>
                </tr>
            </table>
        </div>



    </div>
</body>
</html>
