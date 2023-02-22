<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    $user = new UserController();
    $activities = new ActivitiesController();
    $main = new MainController();
    switch($url[2]){
        case "signup": $user->signup($conn,$_POST['username'],md5($_POST['password']),$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['municipality'],$_POST['usertype']); break;
        case "login": $user->login($conn,$_POST['username'],md5($_POST['password'])); break;
        case "getMun": $user->getMun($conn,$_POST['city']); break;
        case "getData": $user->getData($conn,$_POST['type']); break;
        case "aclist": $activities->getAcList($conn); break;
        case "getReport": $activities->getReport($conn); break;
        case "getCity": $main->getCity($conn); break;
        case "inAc": $activities->insertActivities($conn,$_POST['disaster'],$_POST['location'],$_POST['date'],$_POST['summary'],$_POST['image'],$_SESSION['city_id']); break;
        case "attendance": $main->attendance($conn); break;
        case "getPersonnel": $main->getPersonnel($conn); break;
        case "gnp": $main->getPandT($conn); break;
        case "deletePersonnel": $main->deletePersonnel($conn, $_POST['id']); break;
        case "changeTeam": $main->changeTeam($conn,$_POST['id'],$_POST['tid']); break;
        case "getnewAc": $activities->getNewActivity($conn); break;
    }
