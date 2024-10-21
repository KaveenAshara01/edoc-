<?php
session_start();
$doctorName = isset($_SESSION['doctor_name']) ? $_SESSION['doctor_name'] : '';
?>

<form action="schedule.php" method="post">
    <input type="hidden" name="search" value="<?php echo $doctorName; ?>">
    <center>
        <h2>Redirect to Doctor's sessions?</h2>
        <div>
            <button type="submit" class="btn-primary btn">Yes</button>
            <a href="doctors.php"><button type="button" class="btn-primary btn">No</button></a>
        </div>
    </center>
</form>
