<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    $user = new UserController();
    $activities = new ActivitiesController();
    $main = new MainController();
    switch($url[2]){
        case "signup": $user->signup($conn,md5($_POST['password']),$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['municipality'],$_POST['usertype'],$_POST['badge']); break;
        case "login": $user->login($conn,$_POST['username'],md5($_POST['password'])); break;
        case "getMun": $user->getMun($conn,$_POST['city']); break;
        case "getData": $user->getData($conn,$_POST['type']); break;
        case "aclist": $activities->getAcList($conn); break;
        case "getReport": $activities->getReport($conn, $_POST['type']); break;
        case "getCity": $main->getCity($conn); break;
        case "inAc": $activities->insertActivities(
            $conn,
            $_POST['receivecall'],
            $_POST['location'],
            $_POST['dispatched'],
            $_POST['arrivalscene'],
            $_POST['alarmstatus'],
            $_POST['fireout'],
            $_POST['occupancy'],
            $_POST['fatality'],
            $_POST['damage'],
            $_POST['cause'],
            $_POST['returnedunit'],
            $_POST['commander'],
            $_POST['commandercontact'],
            $_POST['sender'],
            $_POST['contact'],
            $_POST['firetruck'],
            $_POST['image'],
            $_POST['summary'],
            $_SESSION['city_id'],
        ); break;
        case "upAc": $activities->updateActivities(
                $conn,
                $_POST['rcall'],
                $_POST['loc'],
                $_POST['dispatched'],
                $_POST['arrivalscene'],
                $_POST['astatus'],
                $_POST['fireout'],
                $_POST['occupancy'],
                $_POST['fatality'],
                $_POST['damage'],
                $_POST['cause'],
                $_POST['returnedunit'],
                $_POST['commander'],
                $_POST['commandercontact'],
                $_POST['sender'],
                $_POST['firetruck'],
                $_POST['suma'],
                $_SESSION['city_id'],
                $_POST['reportid']
            ); break;
        case "attendance": $main->attendance($conn); break;
        case "getPersonnel": $main->getPersonnel($conn); break;
        case "gnp": $main->getPandT($conn); break;
        case "deletePersonnel": $main->deletePersonnel($conn, $_POST['id']); break;
        case "changeTeam": $main->changeTeam($conn,$_POST['id'],$_POST['tid']); break;
        case "getnewAc": $activities->getNewActivity($conn); break;
        case "getAvailable": $activities->getAvailable($conn); break;
        case "rteam": $activities->rteam($conn, $_POST['tid'], $_POST['aid']); break;
        case "rveh": $activities->rveh($conn, $_POST['id'], $_POST['aid']); break;
        case "rtcs": $activities->rtcs($conn, $_POST['activities'], $_POST['team'], $_POST['status']); break;
        case "updateVehicle": $activities->updateVeh($conn, $_POST['id'], $_POST['stats'], $_POST['response'], $_POST['vehicle'], $_POST['type']); break;
        case 'askhelp': $user->askhelp($conn); break;
        case 'sendrequest': $user->sendrequest($conn, $_POST['id']); break;
        case 'glTeam': $main->glTeam($conn); break;
        case 'addteam': $main->addteam($conn, $_POST['team']); break;
        case 'response': $main->response($conn,$_POST['id']); break;
        case 'updateTeam': $activities->updateTeam($conn,$_POST['id'],$_POST['value'], true); break;
        case 'updateInc': $activities->updateInc($conn,$_POST['id'],$_POST['value']); break;
        case 'getAttendance': $user->getAttendance($conn,$_POST['month']); break;
        case 'getAllMun': $user->getAllMun($conn); break;
        case 'getAbout': $main->getAbout($conn); break;
        case 'updateAbout': $main->updateAbout($conn,$_POST['details'],$_POST['img']); break;
        case 'updateTeamName': $main->updateTeamName($conn,$_POST['id'],$_POST['name']); break;
        case 'addVehicle': $main->addVehicle($conn,$_POST['vehiclename'],$_POST['type']); break;
        case 'deleteVehicle': $main->deleteVehicle($conn,$_POST['id']); break;
        case 'insertStaff': $user->insertStaff($conn,$_POST['badge'],$_POST['firstname'],$_POST['middlename'],$_POST['lastname']); break;
        case 'getAdmin': $user->getAdmin($conn,$_POST['type']); break;
        case 'updateadmin': $user->updateAdmin($conn); break;
        case 'updatepersonnel': $user->updatePersonnel($conn); break;
    }