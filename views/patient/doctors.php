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


include("../connection.php");
    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


// Check if doctors exist in the session before trying to use it
if (!isset($_SESSION['doctors'])) {
    echo 'Doctors not found in session!';
    $doctors = [];
} else {
    $doctors = $_SESSION['doctors'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Doctors</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 999; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5); /* Black background with transparency */
        }
        .popup-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
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
    <div class="container">
    <button class="menu-toggle-btn" onclick="toggleMenu()">☰ Menu</button>
        <div class="menu" id="menuContainer">
        <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username, 0, 13); ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="patient_dashboard.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">All Doctors</p></a></div>
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
                        <a href="precords.php" class="non-style-link-menu"><div><p class="menu-text">My records</p></a></div>
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
            <table border="0" width="100%" style="margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="../controllers/DoctorController.php"><button class="login-btn btn-primary-soft btn btn-icon-back">Back</button></a>
                    </td>
                    <td>
                        <form action="../controllers/DoctorController.php" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
                            <datalist id="doctors">
                                <?php
                                if (!empty($doctors)) {
                                    foreach ($doctors as $doctor) {
                                        echo "<option value='{$doctor['docname']}'>";
                                        echo "<option value='{$doctor['docemail']}'>";
                                    }
                                }
                                ?>
                            </datalist>
                            <input type="Submit" value="Search" class="login-btn btn-primary btn">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="text-align: right;">Today's Date: <?php echo date('Y-m-d'); ?></p>
                    </td>
                    <td width="10%">
                        <button class="btn-label"><img src="../img/calendar.svg"></button>
                    </td>
                </tr>

                <!-- Display Doctors -->
                <tr>
                    <td colspan="4">
                        <p class="heading-main12">
                            All Doctors (<?php echo count($doctors); ?>)
                        </p>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Email</th>
                                            <th>Specialties</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($doctors)) {
                                            foreach ($doctors as $doctor) {



                                                $specialtyId = $doctor['specialties']; 
                                                $specialtyQuery = $database->query("SELECT sname FROM specialties WHERE id='$specialtyId'");
                                                $specialtyRow = $specialtyQuery->fetch_assoc();
                                                $specialtyName = $specialtyRow['sname'];


                                                echo '<tr>
                                                    <td>' . $doctor['docname'] . '</td>
                                                    <td>' . $doctor['docemail'] . '</td>
                                                    <td>' . $specialtyName . '</td>
                                                    <td>
                                                        <button class="btn-primary-soft btn" onclick="openModal(' . $doctor['docid'] . ', \'' . $doctor['docname'] . '\', \'' . $doctor['docemail'] . '\', \'' . $specialtyName . '\')">View</button>
                                                        <a href="../../controllers/DoctorController.php?action=session&id=' . $doctor['docid'] . '&name=' . $doctor['docname'] . '" class="non-style-link">
                                                            <button class="btn-primary-soft btn">Sessions</button>
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }
                                        } else {
                                            echo '<tr>
                                                <td colspan="4">
                                                    <center>No doctors found.</center>
                                                </td>
                                            </tr>';
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

    <!-- Modal for doctor details -->
    <div id="doctorModal" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Doctor Details</h2>
            <p id="docName">Name: </p>
            <p id="docEmail">Email: </p>
            <p id="docSpecialty">Specialty: </p>
        </div>
    </div>

    <script>
        // Function to open the modal with doctor details
        function openModal(docId, docName, docEmail, docSpecialty) {
            document.getElementById("docName").innerText = "Name: " + docName;
            document.getElementById("docEmail").innerText = "Email: " + docEmail;
            document.getElementById("docSpecialty").innerText = "Specialty: " + docSpecialty;
            document.getElementById("doctorModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("doctorModal").style.display = "none";
        }

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
