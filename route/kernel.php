<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    $user = new UserController();
    switch($url[2]){
        case "signup": $user->getUser($conn,$_POST['username'],md5($_POST['password']),$_POST['firstname'],$_POST['middlename'],$_POST['lastname']); break;
        case "login": $user->login($conn,$_POST['username'],md5($_POST['password'])); break;
        case "getMun": $user->getMun($conn,$_POST['city']); break;
        case "getData": $user->getData($conn,$_POST['type']); break;
        case "aclist": $user->getAcList($conn); break;
        case "getReport": $user->getReport($conn); break;
    }
