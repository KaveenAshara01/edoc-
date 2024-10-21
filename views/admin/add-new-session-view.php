<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Add New Session</title>
</head>
<body>
    <div class="container">
        <div class="popupedit">
            <center>
                <a class="close" href="../views/schedule.php">&times;</a>
                <h2>Add New Session</h2>
                <form action="../controllers/ScheduleController.php" method="POST" class="add-new-form">
                    <input type="hidden" name="action" value="add-session">
                    
                    <label for="title">Session Title:</label>
                    <input type="text" name="title" class="input-text" placeholder="Session Title" required><br>

                    <label for="docid">Select Doctor:</label>
                    <select name="docid" class="box" required>
                        <option value="" disabled selected>Select Doctor</option>
                        <?php 
                        // Fetch doctor list dynamically
                        $doctors = $this->model->getDoctors();
                        while ($doctor = $doctors->fetch_assoc()) {
                            echo "<option value='{$doctor['docid']}'>{$doctor['docname']}</option>";
                        }
                        ?>
                    </select><br><br>

                    <label for="venueid">Select Venue:</label>
                    <select name="venueid" class="box" required>
                        <option value="" disabled selected>Select Venue</option>
                        <?php 
                        // Fetch venue list dynamically
                        $venues = $this->model->getVenues();
                        while ($venue = $venues->fetch_assoc()) {
                            echo "<option value='{$venue['venue_id']}'>{$venue['address']}</option>";
                        }
                        ?>
                    </select><br><br>

                    <label for="nop">Number of Patients:</label>
                    <input type="number" name="nop" class="input-text" min="1" required><br>

                    <label for="date">Session Date:</label>
                    <input type="date" name="date" class="input-text" min="<?= date('Y-m-d'); ?>" required><br>

                    <label for="time">Session Time:</label>
                    <input type="time" name="time" class="input-text" required><br>

                    <label for="price">Doctor's Price:</label>
                    <input type="number" step="0.01" name="price" class="input-text" required><br>

                    <input type="submit" value="Add Session" class="login-btn btn-primary btn">
                </form>
            </center>
        </div>
    </div>
</body>
</html>
