<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    $user = new UserController();
    switch($url[2]){
        case "signup": $user->getUser($conn,$_POST['username'],md5($_POST['password'],$_POST['firstname'],$_POST['middlename'],$_POST['lastname'])); break;
        case "login": $user->login($conn,$_POST['username'],md5($_POST['password'])); break;
    }
