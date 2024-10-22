<?php
    session_start();

    
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])==""){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    
   
    if($_GET && isset($_GET['id'])) {
        
        include("../connection.php");

        $id = $_GET["id"];  
        
        
        $stmt = $database->prepare("DELETE FROM appointment WHERE appoid = ?");
        
        
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if($stmt->execute()) {
            
            header("location: appointment.php");
        } else {
            echo "Error: " . $stmt->error;  // Display any errors
        }
        
        
        $stmt->close();
    } else {
        echo "No ID provided.";
    }
?>
