<?php
session_start();
require_once '../models/ScheduleModel.php';




class ScheduleController {



    private $model;

    public function __construct() {
        $this->model = new ScheduleModel();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? $_POST['action'] ?? null;

        switch ($action) {
            case 'add-session-form':
                // Redirect to add session form page
                header("Location: ../views/admin/add-new-session-view.php");
                break;
                
            case 'add-session':
                // Handle form submission to add a session
                $this->addSession();
                break;

            default:
                // Redirect back to the main schedule view
                header("Location: ../views/schedule.php");
                break;
        }
    }

    private function addSession() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
            $title = $_POST['title'];
            $docid = $_POST['docid'];
            $nop = $_POST['nop'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $venueid = $_POST['venueid'];
            $price = $_POST['price'];

            // Call the model to add the session
            if ($this->model->addSession($docid, $title, $date, $time, $nop, $venueid, $price)) {
                // Redirect to the schedule page with a success message
                header("Location: ../views/admin/schedule.php?action=session-added&title=$title");
            } else {
                // Redirect back to the form with an error message
                header("Location: ../views/admin/add-new-session-view.php?action=error&message=Failed to add session");
            }
        }
    }
}

// Create controller instance and handle request
$controller = new ScheduleController();
$controller->handleRequest();
