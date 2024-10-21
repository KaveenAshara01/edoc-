<?php
    session_start();

    // Check if the user is logged in
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])==""){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    
    // Check if an ID is passed in the GET request
    if($_GET && isset($_GET['id'])) {
        
        include("../connection.php");

        $id = $_GET["id"];  // Get the appointment ID
        
        // Prepare the SQL query using placeholders
        $stmt = $database->prepare("DELETE FROM appointment WHERE appoid = ?");
        
        // Bind the appointment ID to the placeholder
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if($stmt->execute()) {
            // If deletion is successful, redirect back to the appointment page
            header("location: appointment.php");
        } else {
            echo "Error: " . $stmt->error;  // Display any errors
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "No ID provided.";
    }
?>
