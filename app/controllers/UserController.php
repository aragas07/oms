<?php
class UserController{
    public function login($conn,$username,$password){
        $result = $conn->query("SELECT * FROM users INNER JOIN municipality ON users.municipality_id = municipality.id WHERE username = '$username' OR badge = '$username' AND password = '$password' AND team_id IS NULL AND usertype != 'personnel'");
        $login = false;
        $loc = "";
        $badge = "";
        $sample = [];
        if(mysqli_num_rows($result) != 0){
            while($res = $result->fetch_assoc()){
                $_SESSION['userloc'] = $res['municipality_id'];
                $_SESSION['usertype'] = $res['usertype'];
                $loc = $res['name'];
                $badge = $res['badge'];
                $sample[] = $res;
            }
            $login = true;
        }
        echo json_encode(['login'=>$login, 'location'=>$loc, 'badge'=>$badge, 'auth'=>$_SESSION['usertype'], 'sample'=>$sample]);
    }

    public function signup($conn,$password,$firstname,$middlename,$lastname,$municipality,$usertype,$badge){
        $admin = false;
        $registered = false;
        $result = $conn->query("SELECT * FROM users WHERE badge = $badge");
        $message = "Sorry the $badge badge has already exist";
        if($result->num_rows == 0){
            if($conn->query("INSERT INTO users(password,firstname,middlename,lastname,usertype,municipality_id,badge)
            values('$password','$firstname','$middlename','$lastname','$usertype',$municipality,'$badge')")){
                $_SESSION['userloc'] = $municipality;
                $_SESSION['usertype'] = $usertype;
                if($usertype == 'admin'){
                    $admin = true;
                }
                $message = 'The data has been successfully added';
                $registered = true;
            }
        }
        echo json_encode(['success'=>$registered,'message'=>$message]);
        // $this->login($conn,$badge,$password);
    }

    public function updateAdmin($conn){
        extract($_POST);
        $success = false;
        $pass = md5($password);
        $result = $conn->query("SELECT * FROM users WHERE badge = $badge AND id = $id");
        $message = "Sorry the $badge badge has already exist";
        if($result->num_rows > 0){
            if($conn->query("UPDATE users SET password='$pass', firstname='$firstname', middlename='$middlename', lastname='$lastname',
            municipality_id=$municipality,badge='$badge' WHERE id = $id")){
                $success = true;
                $message = 'The data has been successfully updated';
            }
        }else{
            $resuult = $conn->query("SELECT * FROM users WHERE badge = $badge");
            if($resuult->num_rows == 0){
                if($conn->query("UPDATE users SET password='$pass', firstname='$firstname', middlename='$middlename', lastname='$lastname',
                municipality_id=$municipality,badge='$badge' WHERE id = $id")){
                    $success = true;
                    $message = 'The data has been successfully updated';
                }
            }
        }
        echo json_encode(['success'=>$success, 'message'=>$message]);
    }
    
    public function updatePersonnel($conn){
        extract($_POST);
        $success = false;
        $pass = md5($password);
        $result = $conn->query("SELECT * FROM users WHERE badge = $badge AND id = $id");
        $message = "Sorry the $badge badge has already exist";
        if($result->num_rows > 0){
            if($conn->query("UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname',
            municipality_id=$municipality,badge='$badge' WHERE id = $id")){
                $success = true;
                $message = 'The data has been successfully updated';
            }
        }else{
            $resuult = $conn->query("SELECT * FROM users WHERE badge = $badge");
            if($resuult->num_rows == 0){
                if($conn->query("UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname',
                municipality_id=$municipality,badge='$badge' WHERE id = $id")){
                    $success = true;
                    $message = 'The data has been successfully updated';
                }
            }
        }
        echo json_encode(['success'=>$success, 'message'=>$message]);
    }

    public function getAdmin($conn,$type){
        $result = $conn->query("SELECT *,u.id AS uid FROM users AS u INNER JOIN municipality AS m ON u.municipality_id = m.id WHERE usertype = '$type'");
        $tbody = '';
        while($row = $result->fetch_assoc()){
            $tbody .= "<tr id='{$row['uid']}'>
                <td>{$row['badge']}</td>
                <td>{$row['firstname']}</td>
                <td>{$row['middlename']}</td>
                <td>{$row['lastname']}</td>
                <td>{$row['name']}</td>
                <td><button class='s-update'>Update</button></td>
            </tr>";
        }
        echo json_encode(['tbody'=>$tbody]);
    }
    public function getAllMun($conn){
        $city = $_SESSION['userloc'];
        $getHomeTown = $conn->query("SELECT * FROM municipality WHERE id = $city");
        $getAll = $conn->query("SELECT * FROM municipality WHERE id != $city");
        $hometown = [];
        $all = array();
        $samp = "";
        while($homeTown = $getHomeTown->fetch_assoc()){
            $hometown = ['name'=>$homeTown['name'], 'img'=>$homeTown['img']];
        }
        while($All = $getAll->fetch_assoc()){
            array_push($all, ['name'=>$All['name'],'img'=>$All['img']]);
        }
        echo json_encode(['hometown'=>$hometown, 'all'=>$all]);
    }

    public function getMun($conn,$city){
        $result = $conn->query("SELECT * FROM municipality WHERE name = '$city'");
        while($res = $result->fetch_assoc()){
            echo json_encode(["name"=>$res['name'],"img"=>$res['img'], "city"=>$res['id']]);
            $_SESSION['city_id'] = $res['id'];
        }
    }

    public function getData($conn,$type){
        $thead = "";
        $tbody = "";
        $city = $_SESSION['city_id'];
        $showbtn = false;
        if($city === $_SESSION['userloc'] && $_SESSION['usertype'] === "admin"){
            $showbtn = true;
        }
        if($type == "PERSONNEL"){
            $thead = "<tr>
                        <th>PERSONNEL</th>
                        <th>STATUS</th>
                        <th>TEAM</th>
                    </tr>";
            $result = $conn->query("SELECT *, u.id AS uid FROM users AS u LEFT JOIN team AS t ON u.team_id = t.id WHERE usertype = 'personnel' AND u.municipality_id = ".$city);
            while($get = $result->fetch_assoc()){
                $status = "Absent";
                $ownteam = "";
                $middlename = "";
                if(strlen($get['middlename']) > 0){
                    $middlename = substr(ucfirst($get['middlename']),0,1).".";
                }
                $duty = "";
                $duty = "Off duty";
                $assignment = "";
                $onDuty = $conn->query("SELECT * FROM logs WHERE users_id = ".$get['uid']." AND DATE(date) = CURDATE()");
                if(mysqli_num_rows($onDuty) > 0){
                    $duty = "On duty";
                    while($out = $onDuty->fetch_assoc()){
                        if($out['timeout'] != '00:00:00'){
                            $duty = "Off duty";
                        }
                        $assignment = $out['assignment'];
                    }
                }
                $tbody .= "<tr>
                <td>".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])." ".$middlename."</td>
                <td>$duty</td>
                <td>".$get['name']."</td>
                </tr>";
            }
        }else if($type == "VEHICLE"){
            $thead = "<tr>
                        <th>VEHICLE #</th>
                        <th>TYPE</th>
                        <th>STATUS</th>
                    </tr>";
            $result = $conn->query("SELECT * FROM vehicle WHERE municipality_id = ".$city);
            while($res = $result->fetch_assoc()){
                $status = "";
                if($res['status'] == 0){
                    $status = "Available";
                }else if($res['status'] == 1){
                    $status = "On use";
                }else{
                    $status = "Under maintenance";
                }
                $vehicle = "";
                $type = "";
                if($showbtn){
                    $vehicle = "<input type='text' class='form-control vehicle-status' value='".$res['vehicle']."'/>";
                    $type = "<input type='text' class='form-control type-status' value='".$res['type']."'";
                }else{
                    $vehicle = $res['vehicle'];
                    $type = $res['type'];
                }
                $tbody .= "<tr>
                        <td>$vehicle</td>
                        <td>$type</td>";
                if($showbtn){
                    $tbody .= "<td>
                            <select style='width:150px' class='vehStatus' id='".$res['id']."'>
                                <option ";if($res['status'] == 0){$tbody .= "selected";} $tbody .= " value=0>Available</option>
                                <option ";if($res['status'] == 1){$tbody .= "selected";} $tbody .= " value=1>On use</option>
                                <option ";if($res['status'] == 2){$tbody .= "selected";} $tbody .= " value=2>Under maintenance</option>
                            </select>
                            <button value='".$res['id']."' class='deletebtn rbutton'>Delete</button>
                        </td>";
                }else{
                    $tbody .= "<td>".$status."</td>";
                }
                $tbody .= "</tr>";
            }
        }else if($type == "TEAM"){
            $thead = "<tr>
                        <th>NAME</th>
                        <th>LOCATION</th>
                        <th>OCCUPANCY</th>
                        <th>STATUS</th>
                    </tr>";
            $getTeam = $conn->query("SELECT *,t.status AS tstat FROM team AS t INNER JOIN responded_team AS r INNER JOIN 
            activities AS a ON t.id = r.team_id AND r.activities_id = a.id WHERE t.municipality_id = $city AND a.status != 2");
            while($get = $getTeam->fetch_assoc()){
                $status = "";
                $ts = $get['tstat'];
                if($showbtn){
                    $status = "<select id='".$get['team_id']."'>
                    <option";
                    if($ts == 1){ $status .= " selected ";}
                    $status .= " value='1'>On going</option>
                    <option";
                    if($ts == 2){ $status .= " selected ";}
                    $status .= " value='2'>On working</option>
                    </select>";
                }else if($ts == 0){$status = "Available";}
                else if($ts == 1){$status = "On going";}
                else{$status = "On working";}
                $tbody .= "<tr>
                            <td>".$get['name']."</td>
                            <td>".$get['location']."</td>
                            <td>".$get['occcupancy']."</td>
                            <td>$status</td>
                        </tr>";
            }
        }else{
            $thead = "<tr>
                        <th>ALARM STATUS</th>
                        <th>LOCATION</th>
                        <th>STATUS</th>
                    </tr>";
            $result = $conn->query("SELECT * FROM activities WHERE municipality_id = $city AND status < 2");
            while($res = $result->fetch_assoc()){
                $status = "";
                if($showbtn){
                    $status = '<select id='.$res['id'].'>
                        <option ';
                        if($res['status'] == 1) $status .= 'selected';
                        $status .= ' value="1">Currently working</option>
                        <option ';
                        if($res['status'] == 2) $status .= 'selected';
                        $status .= ' value="2">Done</option>
                    </select>';
                }else{
                    if($res['status'] == 0){
                        $status = "Currently working";
                    }else if($res['status'] == 1){
                        $status = "Currently working";
                    }else{
                        $status = "Done";
                    }
                }
                $tbody .= "<tr>
                    <td>".$res['alarmstatus']."</td>
                    <td>".$res['location']."</td>
                    <td>$status</td>
                </tr>";
            }
        }
        echo json_encode(['thead'=>$thead,'tbody'=>$tbody, 'showbtn'=>$showbtn, 'city'=>$city]);
    }

    public function askhelp($conn){
        $mun = $conn->query("SELECT * FROM municipality WHERE id != ".$_SESSION['userloc']);
        echo '<table><thead><tr><th>Municipality list</th></tr></thead><tbody style="cursor:pointer" id="municipality">';
        while($get = $mun->fetch_assoc()){
            echo '<tr value="'.$get['id'].'"><td><div class="table-div">'.$get['name'].' <b>❏</b></div></td></tr>';
        }
        echo '</tbody></table>';
    }
 
    public function sendrequest($conn, $id){
        $LastActivity = $conn->query("SELECT * FROM activities ORDER BY id DESC LIMIT 1");
        while($get = $LastActivity->fetch_assoc()){
            $acid = $get['id'];
            $conn->query("INSERT INTO help(municipality_id,activities,status) VALUES($id,$acid,0)");
        }
    }

    public function getAttendance($conn,$month){
        $city = $_SESSION['city_id'];
        $personnel = array();
        $getPersonnel = $conn->query("SELECT * FROM users WHERE municipality_id = $city AND team_id IS NOT NULL");
        while($get = $getPersonnel->fetch_assoc()){
            $middlename = "";
            if(strlen($get['middlename']) > 0){
                $middlename = substr(ucfirst($get['middlename']),0,1).".";
            }
            $attendance = array();
            $getattendance = $conn->query("SELECT * FROM logs WHERE MONTH(date) = $month AND users_id = ".$get['id']." ORDER BY date ASC");
            while($getDay = $getattendance->fetch_assoc()){
                $getAssignment = $conn->query("SELECT * FROM activities WHERE id = ".intval($getDay['assignment']));
                $assignment = array();
                while($getAs = $getAssignment->fetch_assoc()){
                    array_push($assignment,['activity'=>$getAs['activity'],'location'=>$getAs['location'],'summary'=>$getAs['summary']]);
                }
                array_push($attendance,['date'=>$getDay['date'],'assignment'=>$assignment,'timein'=>$getDay['timein'],'timeout'=>$getDay['timeout']]);   
            }
            array_push($personnel,['personnel'=>ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])." ".$middlename, 'attend'=>$attendance, 'id'=>$get['id']]);
        }
        echo json_encode($personnel);
    }

    public function insertStaff($conn){
        extract($_POST);
        $success = 'error';
        $city = $_SESSION['city_id'];
        $text = "";
        $res = $conn->query("INSERT INTO users(badge,firstname,middlename,lastname,usertype,municipality_id) VALUES('$badge','$firstname','$middlename','$lastname','personnel',$city)");
        if($res){
            $success = 'success';
            $text = $badge.' has been added';
        }
        echo json_encode(['icon'=>$success,'msg'=>$text]);
    }
}