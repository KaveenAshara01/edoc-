<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Patient Records</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .table-actions {
    display: inline-block;
}

.table-actions a {
    display: inline-block; /* Allows buttons to sit next to each other */
    padding: 8px 5px; /* Adjust padding to reduce button size */
    margin-right: 5px; /* Space between buttons */
    text-align: center; /* Center text within buttons */
    white-space: nowrap; /* Prevents text from wrapping */
}

/* Menu toggle for mobile view */
.menu-toggle-btn {
            display: none;
            background-color: #333;
            color: white;
            width: 100%;
            text-align: left;
            padding: 15px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
        }

        /* Adjust dashboard layout
        .dash-body {
            margin-left: 300px;
            width: calc(100% - 300px);
        } */

        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .menu {
                display: none;
                width: 100%;
            }

            .menu-toggle-btn {
                display: block;
            }

            .dash-body {
                margin: 0;
                width: 100%;
                padding-top: 60px;
            }

            /* Make sure the menu takes full width on mobile */
            .menu-container {
                width: 100%;
            }

            /* Stack items vertically on mobile */
            .dashboard-items {
                flex-direction: column;
                width: 100%;
            }

            /* Stack Status and Upcoming Booking vertically */
            .status-booking-container {
                display: flex;
                flex-direction: column; /* Stack elements vertically */
                width: 100%;
            }

            .status-column, .booking-column {
                width: 100%; /* Full width on mobile */
                padding: 10px;
            }

            .filter-container {
                width: 100%;
            }
        }

        @media (max-width: 320px) {
            .menu-toggle-btn {
                padding: 10px;
                font-size: 16px;
            }

            .profile-title {
                font-size: 12px;
            }

            .profile-subtitle {
                font-size: 10px;
            }

            .heading-sub12 {
                font-size: 10px;
            }

            .dash-body {
                padding: 5px;
            }

            .menu-btn .menu-text {
                font-size: 12px;
            }

            .h1-dashboard {
                font-size: 18px;
            }

            .h3-dashboard {
                font-size: 12px;
            }

            .filter-container {
                padding: 5px;
            }

            .sub-table {
                font-size: 10px;
            }

            .table-headin {
                font-size: 10px;
            }

            .btn-label {
                padding: 5px;
                font-size: 12px;
            }

            img {
                width: 80%;
            }
        }

    </style>
</head>
<body>
    <?php
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    
    // Import database
    include("../connection.php");
    $userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];

        $sql = "SELECT * FROM patient WHERE pid='$userid'";
        $patient = $database->query($sql)->fetch_assoc();
    

    
    ?>
    <div class="container">
    <button class="menu-toggle-btn" onclick="toggleMenu()">☰ Menu</button>
        <div class="menu" id="menuContainer">
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
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active" >
                        <a href="patient_dashboard.php" class="non-style-link-menu non-style-link-menu"><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="precords.php" class="non-style-link-menu-active"><div><p class="menu-text">My records</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="patient_dashboard.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Records of <?php echo $patient["pname"]; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0">
                            <tr>
                                <td width="50%">
                                    
                                </td>
                            </tr>
                        </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                        <thead>
                            <tr>
                                <th class="table-headin">Date</th>
                                <th class="table-headin">Name</th>
                                <th class="table-headin">Doctor</th>
                                <th class="table-headin">Details</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $records_query = "SELECT * FROM records WHERE patient_id='$userid'";
                        $records_result = $database->query($records_query);

                        if ($records_result->num_rows == 0) {
                            echo '<tr>
                                <td colspan="5">
                                <center>
                                <p class="heading-main12">No Records Found</p>
                                </center>
                                </td>
                            </tr>';
                        } else {
                            while ($record = $records_result->fetch_assoc()) {
                                $doc_query = "SELECT docname FROM doctor WHERE docid='{$record['doctor_id']}'";
                                $doc_result = $database->query($doc_query);
                                $doc = $doc_result->fetch_assoc();
                                $record['docname'] = $doc['docname'];

                                echo "<tr>
                                    <td>{$record['record_date']}</td> 
                                    <td>{$record['record_name']}</td>  
                                    <td>{$record['docname']}</td>   
                                    <td>{$record['description']}</td>  
                                   
                                </tr>";
                            }
                        }
                        ?>
                        </tbody>
                        </table>
                        </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <script>
    function toggleMenu() {
        var menu = document.getElementById("menuContainer");
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }
</script>
</body>
</html>
