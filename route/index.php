<?php 
    session_start();
    include('../app/database/dbconnection.php');
    global $conn;
    require_once('../app/controllers/UserController.php');
    require_once('../app/controllers/ActivitiesController.php');
    require_once('kernel.php')
?>