<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Schedule</title>
    <style>
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 999;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
        }
        .popup-overlay {
            display: none; /* Hidden by default */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }
        .popup.show, .popup-overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        if (empty($_SESSION["user"]) || $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
            exit();
        }
    } else {
        header("location: ../login.php");
        exit();
    }

    include("../connection.php");

    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');
    ?>

    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@edoc.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php">
                                        <input type="button" value="Log out" class="logout-btn btn-primary-soft btn">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Dashboard</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Doctors</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Schedule</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Appointment</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Patients</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="schedule.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Schedule Manager</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
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
                        <div style="display: flex;margin-top: 40px;">
                            <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">
                                Schedule a Session
                            </div>
                            <button id="addSessionBtn" class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">
                                Add a Session
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            All Sessions (<?php echo $database->query("SELECT * FROM schedule")->num_rows; ?>)
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <td width="10%"></td>
                                    <td width="5%" style="text-align: center;">Date:</td>
                                    <td width="30%">
                                        <form action="" method="post">
                                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                    </td>
                                    <td width="5%" style="text-align: center;">Doctor:</td>
                                    <td width="30%">
                                        <select name="docid" class="box filter-container-items" style="width:90%;height: 37px;margin: 0;">
                                            <option value="" disabled selected hidden>Choose Doctor</option>
                                            <?php
                                            $doctors = $database->query("SELECT * FROM doctor ORDER BY docname ASC");
                                            while ($row = $doctors->fetch_assoc()) {
                                                echo "<option value='{$row['docid']}'>{$row['docname']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px;margin:0;width:100%">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>

                <?php
                // Filtering logic
                $sqlmain = "SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime, schedule.nop 
                            FROM schedule 
                            INNER JOIN doctor ON schedule.docid = doctor.docid";

                if ($_POST) {
                    $conditions = [];
                    if (!empty($_POST["sheduledate"])) {
                        $sheduledate = $_POST["sheduledate"];
                        $conditions[] = "schedule.scheduledate='$sheduledate'";
                    }

                    if (!empty($_POST["docid"])) {
                        $docid = $_POST["docid"];
                        $conditions[] = "doctor.docid=$docid";
                    }

                    if ($conditions) {
                        $sqlmain .= " WHERE " . implode(' AND ', $conditions);
                    }
                }

                $sqlmain .= " ORDER BY schedule.scheduledate DESC";
                $result = $database->query($sqlmain);
                ?>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Session Title</th>
                                            <th class="table-headin">Doctor</th>
                                            <th class="table-headin">Scheduled</th>
                                            <th class="table-headin">Booking limit</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows == 0) {
                                            echo '
                                            <tr>
                                                <td colspan="5">
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        <p class="heading-main12">No sessions found!</p>
                                                        <a href="schedule.php">
                                                            <button class="login-btn btn-primary-soft btn">
                                                                &nbsp; Show all Sessions &nbsp;
                                                            </button>
                                                        </a>
                                                    </center>
                                                </td>
                                            </tr>';
                                        } else {
                                            while ($row = $result->fetch_assoc()) {
                                                $scheduleid = $row["scheduleid"];
                                                $title = $row["title"];
                                                $docname = $row["docname"];
                                                $scheduledate = $row["scheduledate"];
                                                $scheduletime = $row["scheduletime"];
                                                $nop = $row["nop"];

                                                echo '
                                                <tr>
                                                    <td>' . htmlspecialchars($title) . '</td>
                                                    <td>' . htmlspecialchars($docname) . '</td>
                                                    <td style="text-align:center;">' . $scheduledate . ' ' . $scheduletime . '</td>
                                                    <td style="text-align:center;">' . $nop . '</td>
                                                    <td>
                                                        <div style="display:flex;justify-content: center;">
                                                            <a href="?action=view&id=' . $scheduleid . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-view">View</button>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=edit&id=' . $scheduleid . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-edit">Edit</button>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=drop&id=' . $scheduleid . '&name=' . urlencode($title) . '" class="non-style-link">
                                                                <button class="btn-primary-soft btn button-icon btn-delete">Remove</button>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td>
                </tr>

                <!-- Add Session Modal -->
                <div class="popup-overlay" id="popupOverlay"></div>
                <div class="popup" id="addSessionPopup">
                    <form id="addSessionForm" action="../../controllers/ScheduleController.php?action=add-session" method="POST">
                        <h2>Add New Session</h2>
                        <label for="title">Session Title:</label>
                        <input type="text" name="title" required><br><br>

                        <label for="docid">Select Doctor:</label>
                        <select name="docid" required>
                            <?php
                            $doctors = $database->query("SELECT * FROM doctor ORDER BY docname ASC");
                            while ($row = $doctors->fetch_assoc()) {
                                echo "<option value='{$row['docid']}'>{$row['docname']}</option>";
                            }
                            ?>
                        </select><br><br>

                        <label for="venueid">Select Venue:</label>
                        <select name="venueid" required>
                            <?php
                            $venues = $database->query("SELECT * FROM venue ORDER BY venue_id ASC");
                            while ($row = $venues->fetch_assoc()) {
                                echo "<option value='{$row['venue_id']}'>{$row['address']}</option>";
                            }
                            ?>
                        </select><br><br>

                        <label for="nop">Number of Patients:</label>
                        <input type="number" name="nop" min="1" required><br><br>

                        <label for="date">Session Date:</label>
                        <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required><br><br>

                        <label for="time">Session Time:</label>
                        <input type="time" name="time" required><br><br>

                        <label for="price">Doctor's Price:</label>
                        <input type="number" step="0.01" name="price" required><br><br>

                        <button type="submit" class="login-btn btn-primary">Add Session</button>
                        <button type="button" id="closePopupBtn" class="btn-primary">Cancel</button>
                    </form>
                </div>
            </table>
        </div>
    </div>



    <?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? null;

    // Handle adding a new session
    if ($action === 'add-session') {
        
    }

    // Handle viewing a session
    elseif ($action === 'view' && $id) {
    $session = $database->query("
        SELECT s.scheduleid, s.title, s.scheduledate, s.scheduletime, s.price, 
               d.docname, v.address 
        FROM schedule s 
        INNER JOIN doctor d ON s.docid = d.docid 
        INNER JOIN venue v ON s.venue_id = v.venue_id 
        WHERE s.scheduleid = $id
    ")->fetch_assoc();

    $patients = $database->query("
        SELECT p.pid, p.pname, a.apponum, p.ptel 
        FROM appointment a 
        INNER JOIN patient p ON a.pid = p.pid 
        WHERE a.scheduleid = $id
    ");

    echo '
    <div id="popup1" class="overlay">
        <div class="popupedit" style="width: 70%; max-width: 800px;">
            <center>
                <a class="close" href="schedule.php">&times;</a>
                <h2 style="margin-bottom: 15px;">Session Details</h2>

                <table class="sub-table" border="0" style="width: 80%; margin-bottom: 20px; text-align: left;">
                    <tr>
                        <th style="width: 30%; padding: 8px;">Title:</th>
                        <td style="padding: 8px;">' . htmlspecialchars($session['title']) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 8px;">Doctor:</th>
                        <td style="padding: 8px;">' . htmlspecialchars($session['docname']) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 8px;">Venue:</th>
                        <td style="padding: 8px;">' . htmlspecialchars($session['address']) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 8px;">Date:</th>
                        <td style="padding: 8px;">' . htmlspecialchars($session['scheduledate']) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 8px;">Time:</th>
                        <td style="padding: 8px;">' . htmlspecialchars($session['scheduletime']) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 8px;">Price:</th>
                        <td style="padding: 8px;">' . number_format($session['price'], 2) . '</td>
                    </tr>
                </table>

                <h3 style="margin-top: 20px; text-align: left; width: 80%;">Registered Patients (' . $patients->num_rows . ')</h3>
                <div class="abc scroll" style="width: 80%; max-height: 250px; overflow-y: auto;">
                    <table class="sub-table scrolldown" border="0" style="width: 100%; text-align: center;">
                        <thead>
                            <tr>
                                <th style="padding: 10px; width: 20%;">Patient ID</th>
                                <th style="padding: 10px; width: 35%;">Name</th>
                                <th style="padding: 10px; width: 25%;">Appointment No</th>
                                <th style="padding: 10px; width: 20%;">Phone</th>
                            </tr>
                        </thead>
                        <tbody>';

    if ($patients->num_rows > 0) {
        while ($patient = $patients->fetch_assoc()) {
            echo '
            <tr>
                <td style="padding: 10px;">' . htmlspecialchars($patient['pid']) . '</td>
                <td style="padding: 10px;">' . htmlspecialchars($patient['pname']) . '</td>
                <td style="padding: 10px;">' . htmlspecialchars($patient['apponum']) . '</td>
                <td style="padding: 10px;">' . htmlspecialchars($patient['ptel']) . '</td>
            </tr>';
        }
    } else {
        echo '
            <tr>
                <td colspan="4" style="text-align: center; padding: 15px;">
                    <p>No patients registered for this session.</p>
                </td>
            </tr>';
    }

    echo '
                        </tbody>
                    </table>
                </div>

                <a href="schedule.php" class="non-style-link">
                    <button class="btn-primary btn" style="margin-top: 20px;">Back to Schedule</button>
                </a>
            </center>
        </div>
    </div>';
}



    // Handle editing a session
    elseif ($action === 'edit' && $id) {
        $session = $database->query("SELECT * FROM schedule WHERE scheduleid = $id")->fetch_assoc();

        echo '
        <div id="popup1" class="overlay">
            <div class="popupedit">
                <center>
                    <a class="close" href="schedule.php">&times;</a>
                    <h2>Edit Session</h2>
                    <form action="edit-session.php" method="POST" class="add-new-form">
                        <input type="hidden" name="scheduleid" value="' . $id . '">

                        <label for="title">Session Title:</label>
                        <input type="text" name="title" class="input-text" value="' . $session['title'] . '" required><br>

                        <label for="docid">Select Doctor:</label>
                        <select name="docid" class="box">';
        
        $doctors = $database->query("SELECT * FROM doctor ORDER BY docname ASC");
        while ($doctor = $doctors->fetch_assoc()) {
            $selected = $doctor['docid'] == $session['docid'] ? 'selected' : '';
            echo "<option value='{$doctor['docid']}' $selected>{$doctor['docname']}</option>";
        }

        echo '
                        </select><br><br>

                        <label for="venueid">Select Venue:</label>
                        <select name="venueid" class="box">';

        $venues = $database->query("SELECT * FROM venue ORDER BY venue_id ASC");
        while ($venue = $venues->fetch_assoc()) {
            $selected = $venue['venue_id'] == $session['venue_id'] ? 'selected' : '';
            echo "<option value='{$venue['venue_id']}' $selected>{$venue['address']}</option>";
        }

        echo '
                        </select><br><br>

                        <label for="nop">Number of Patients:</label>
                        <input type="number" name="nop" class="input-text" value="' . $session['nop'] . '" required><br>

                        <label for="date">Session Date:</label>
                        <input type="date" name="date" class="input-text" value="' . $session['scheduledate'] . '" required><br>

                        <label for="time">Session Time:</label>
                        <input type="time" name="time" class="input-text" value="' . $session['scheduletime'] . '" required><br>

                        <label for="price">Doctor\'s Price:</label>
                        <input type="number" step="0.01" name="price" class="input-text" value="' . $session['price'] . '" required><br>

                        <input type="submit" value="Save Changes" class="login-btn btn-primary btn">
                    </form>
                </center>
            </div>
        </div>';
    }

    // Handle deleting a session
    elseif ($action === 'drop' && $id) {
        echo '
       <div id="popup1" class="overlay">
            <div class="popupedit">
                <center>
                    <h2>Are you sure?</h2>
                    <p>You want to delete this session?</p>
                    <a href="delete-session.php?id=' . $id . '" class="non-style-link">
                        <button class="btn-primary">Yes</button>
                    </a>
                    <a href="schedule.php" class="non-style-link">
                        <button class="btn-primary">No</button>
                    </a>
                </center>
            </div>
        </div>';
    }
}
?>

    <script>
        // JavaScript to handle modal
        const addSessionBtn = document.getElementById('addSessionBtn');
        const addSessionPopup = document.getElementById('addSessionPopup');
        const popupOverlay = document.getElementById('popupOverlay');
        const closePopupBtn = document.getElementById('closePopupBtn');

        addSessionBtn.addEventListener('click', () => {
            addSessionPopup.classList.add('show');
            popupOverlay.classList.add('show');
        });

        closePopupBtn.addEventListener('click', () => {
            addSessionPopup.classList.remove('show');
            popupOverlay.classList.remove('show');
        });

        popupOverlay.addEventListener('click', () => {
            addSessionPopup.classList.remove('show');
            popupOverlay.classList.remove('show');
        });
    </script>
</body>
</html>
