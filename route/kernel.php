<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    switch($url[2]){
        case "signup": UserController::class->getUser(); break;
    }
?>