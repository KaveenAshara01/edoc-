<?php
session_start();

// Fetch specific doctor details from session
$doctor = isset($_SESSION['doctor']) ? $_SESSION['doctor'] : null;
$specialty = isset($_SESSION['specialty']) ? $_SESSION['specialty'] : null;

if (!$doctor) {
    echo "Doctor not found!";
    exit();
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
    <title>Doctor Details</title>
</head>
<body>
    <div class="container">
        <h2>Doctor Details</h2>
        <p>Name: <?php echo $doctor['docname']; ?></p>
        <p>Email: <?php echo $doctor['docemail']; ?></p>
        <p>Specialty: <?php echo $specialty; ?></p>
        <p>NIC: <?php echo $doctor['docnic']; ?></p>
        <p>Telephone: <?php echo $doctor['doctel']; ?></p>
        <a href="../controllers/DoctorController.php"><button>Back</button></a>
    </div>
</body>
</html>
