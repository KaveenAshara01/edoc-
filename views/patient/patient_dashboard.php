<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table, .anime {
            animation: transitionIn-Y-bottom 0.5s;
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

        /* Default layout */
        .status-booking-container {
            display: flex;
            justify-content: space-between;
        }

        .status-column {
            width: 48%;
        }

        .booking-column {
            width: 48%;
        }

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

            /* Stack Status and Upcoming Booking vertically on mobile */
            .status-booking-container {
                display: flex;
                flex-direction: column;
            }

            .status-column, .booking-column {
                width: 100%; /* Full width on mobile */
                margin-bottom: 20px;
            }

            .filter-container {
                width: 100%;
            }
        }

        /* Very small screens */
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

    $totals = $_SESSION['totals'];
    $appointments = $_SESSION['appointments'];
    $username = $_SESSION['username'];
    $useremail = $_SESSION['user'];
    $today = $_SESSION['today'];
    ?>

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

                <!-- Menu Links -->
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">Home</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="../../controllers/DoctorController.php" class="non-style-link-menu">
                            <div><p class="menu-text">All Doctors</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu">
                            <div><p class="menu-text">Scheduled Sessions</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div><p class="menu-text">My Bookings</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="precords.php" class="non-style-link-menu">
                            <div><p class="menu-text">My Records</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu">
                            <div><p class="menu-text">Settings</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Main Dashboard Content -->
        <div class="dash-body" style="margin-top: 15px;">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="1" class="nav-bar">
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Home</p>
                    </td>
                    <td width="25%"></td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php echo $today; ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                            <img src="../img/calendar.svg" width="100%">
                        </button>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container doctor-header patient-header" style="border: none;width:95%" border="0">
                                <tr>
                                    <td>
                                        <h3>Welcome!</h3>
                                        <h1><?php echo $username; ?>.</h1>
                                        <p>Haven't any idea about doctors? No problem! Let's jump to
                                            <a href="doctors.php" class="non-style-link"><b>"All Doctors"</b></a> section or 
                                            <a href="schedule.php" class="non-style-link"><b>"Sessions"</b></a><br>
                                            Track your past and future appointments. Also find out the expected arrival time of your doctor.<br><br>
                                        </p>

                                        <h3>Channel a Doctor Here</h3>
                                        <form action="schedule.php" method="post" style="display: flex">
                                            <input type="search" name="search" class="input-text" placeholder="Search Doctor" list="doctors" style="width:45%;">&nbsp;&nbsp;
                                            <datalist id="doctors">
                                                <?php
                                                    foreach ($doctorList as $doctor) {
                                                        echo "<option value='{$doctor['docname']}'>";
                                                    }
                                                ?>
                                            </datalist>
                                            <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px 25px;">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>

                <!-- Status and Upcoming Bookings Section -->
                <tr>
                    <td colspan="4">
                        <div class="status-booking-container">
                            <!-- Status Section -->
                            <div class="status-column">
                                <table border="0" width="100%">
                                    <tr>
                                        <td colspan="4">
                                            <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;">
                                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                                <div>
                                                    <div class="h1-dashboard"><?php echo $totals['doctors']; ?></div><br>
                                                    <div class="h3-dashboard">All Doctors</div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                            </div>
                                        </td>
                                        <td style="width: 50%;">
                                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div>
                                                    <div class="h1-dashboard"><?php echo $totals['patients']; ?></div><br>
                                                    <div class="h3-dashboard">All Patients</div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;">
                                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div>
                                                    <div class="h1-dashboard"><?php echo $totals['appointments']; ?></div><br>
                                                    <div class="h3-dashboard">New Bookings</div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/book-hover.svg');"></div>
                                            </div>
                                        </td>
                                        <td style="width: 50%;">
                                            <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div>
                                                    <div class="h1-dashboard"><?php echo $totals['schedules']; ?></div><br>
                                                    <div class="h3-dashboard">Today's Sessions</div>
                                                </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Upcoming Bookings Section -->
                            <div class="booking-column">
                                <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Your Upcoming Bookings</p>
                                <center>
                                    <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin">Appoint. Number</th>
                                                    <th class="table-headin">Session Title</th>
                                                    <th class="table-headin">Doctor</th>
                                                    <th class="table-headin">Scheduled Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if (empty($appointments)) {
                                                        echo '<tr>
                                                            <td colspan="4">
                                                                <center>
                                                                    <img src="../img/notfound.svg" width="25%">
                                                                    <p class="heading-main12">Nothing to show here!</p>
                                                                    <a class="non-style-link" href="schedule.php">
                                                                        <button class="login-btn btn-primary-soft btn">Channel a Doctor</button>
                                                                    </a>
                                                                </center>
                                                            </td>
                                                        </tr>';
                                                    } else {
                                                        foreach ($appointments as $appointment) {
                                                            echo '<tr>
                                                                <td style="padding:30px;font-size:25px;font-weight:700;">' . $appointment['apponum'] . '</td>
                                                                <td style="padding:20px;">' . substr($appointment['title'], 0, 30) . '</td>
                                                                <td>' . substr($appointment['docname'], 0, 20) . '</td>
                                                                <td style="text-align:center;">' . $appointment['scheduledate'] . ' ' . $appointment['scheduletime'] . '</td>
                                                            </tr>';
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </center>
                            </div>
                        </div>
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
