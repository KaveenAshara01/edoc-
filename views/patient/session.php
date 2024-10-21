<?php
session_start();



if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}


include("../connection.php");
$userrow = $database->query("select * from patient where pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];


if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("location: ../login.php");
    exit();
}

$sessions = isset($_SESSION['sessions']) ? $_SESSION['sessions'] : [];
$doctorName = isset($_SESSION['doctor_name']) ? $_SESSION['doctor_name'] : '';
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Sessions for <?= htmlspecialchars($doctorName) ?></title>

    <style>
        .popup { animation: transitionIn-Y-bottom 0.5s; }
        .sub-table { animation: transitionIn-Y-bottom 0.5s; }
        .scroll { overflow-x: auto; }
        .dashboard-items { margin-bottom: 20px; }
        #paymentPopup { display: none; }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .header-searchbar { width: 100%; }
            .h1-search, .h3-search, .h4-search { font-size: 1em; }
            .menu-container, .sub-table { width: 100%; }
            .container { padding: 10px; }
            .dashboard-items { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Navigation Bar -->
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
                <!-- Menu Items -->
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appointment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="precords.php" class="non-style-link-menu"><div><p class="menu-text">My records</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>

        </div>

        <!-- Main Content -->
        <div class="dash-body">
            <table border="0" width="100%" style="margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="schedule.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding:11px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)">
                            Sessions for Dr. <?= htmlspecialchars($doctorName) ?> (<?= count($sessions) ?>)
                        </p>
                    </td>
                    <td width="15%" style="text-align: right;">
                        <p style="font-size: 14px; color: rgb(119, 119, 119);">Today's Date: <?= $today ?></p>
                    </td>
                </tr>

                <!-- Sessions Listing -->
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table class="sub-table scrolldown">
                                    <tbody>
                                        <?php if (empty($sessions)): ?>
                                            <tr><td colspan="6"><center>No sessions found!</center></td></tr>
                                        <?php else: ?>
                                            <?php foreach ($sessions as $session): ?>
                                                <tr>
                                                    <td style="width: 25%;">
                                                        <div class="dashboard-items search-items">
                                                            <div>
                                                                <div class="h1-search"><?= htmlspecialchars(substr($session["title"], 0, 21)) ?></div>
                                                                <div class="h3-search"><?= htmlspecialchars($session["docname"]) ?></div>
                                                                <div class="h4-search">
                                                                    Date: <?= htmlspecialchars($session["scheduledate"]) ?> | 
                                                                    Time: <?= htmlspecialchars(substr($session["scheduletime"], 0, 5)) ?>
                                                                </div>
                                                                <div class="h4-search">
                                                                    Venue: <?= htmlspecialchars($session["venue_name"]) ?>, <?= htmlspecialchars($session["venue_address"]) ?>
                                                                </div>
                                                                <div class="h4-search">
                                                                    Price: Rs. <?= number_format($session["price"], 2) ?>
                                                                </div>
                                                                <button class="login-btn btn-primary-soft btn" 
                                                                    onclick="openPaymentPopup(<?= $session['scheduleid'] ?>)">
                                                                    Book Now
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Payment Modal -->
        <div id="paymentPopup" class="overlay">
            <div class="popup">
                <h2>Payment Details</h2>
                <form id="paymentForm" action="../../controllers/BookingController.php" method="POST" onsubmit="return validatePaymentForm()">
                    <input type="text" id="cardNumber" class="input-text-popup" placeholder="Card Number (xxxx xxxx xxxx xxxx)" maxlength="19" required oninput="formatCardNumber()">
                    <input type="month" id="expiryDate" class="input-text-popup" required>
                    <input type="password" id="cvv" class="input-text-popup" placeholder="CVV" maxlength="3" required>
                    <!-- This hidden input holds the session ID -->
                    <input type="hidden" name="scheduleid" id="sessionId">
                    
                    <button type="button" class="btn btn-primary-gray" onclick="closePaymentPopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Pay</button>
                </form>
            </div>
        </div>

        <script>
            function openPaymentPopup(sessionId) {
                document.getElementById('sessionId').value = sessionId;
                document.getElementById('paymentPopup').style.display = 'block';
            }

            function closePaymentPopup() {
                document.getElementById('paymentPopup').style.display = 'none';
            }

            function validatePaymentForm() {
                const cardNumber = document.getElementById('cardNumber').value.replace(/\s+/g, '');
                const expiryDate = document.getElementById('expiryDate').value;
                const cvv = document.getElementById('cvv').value;

                // Validate card number (16 digits)
                if (!/^\d{16}$/.test(cardNumber)) {
                    alert('Invalid card number.');
                    return false;
                }

                // Validate expiry date (must not be in the past)
                const currentDate = new Date();
                const selectedDate = new Date(expiryDate);
                if (selectedDate < currentDate) {
                    alert('Invalid expiry date.');
                    return false;
                }

                // Validate CVV (3 digits)
                if (!/^\d{3}$/.test(cvv)) {
                    alert('Invalid CVV.');
                    return false;
                }

                // If validation passes, allow form submission
                return true;
            }

            function formatCardNumber() {
                const cardInput = document.getElementById('cardNumber');
                const value = cardInput.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                const formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                cardInput.value = formattedValue;
            }
        </script>
    </div>
</body>
</html>
