<?php
class UserController{
    public function login($conn,$username,$password){
        $result = $conn->query("SELECT * FROM users INNER JOIN municipality ON users.municipality_id = municipality.id where username = '$username' and password = '$password'");
        $login = false;
        $loc = "";
        if(mysqli_num_rows($result) != 0){
            while($res = $result->fetch_assoc()){
                $_SESSION['userloc'] = $res['municipality_id'];
                $_SESSION['usertype'] = $res['usertype'];
                $loc = $res['name'];
            }
            $login = true;
        }
        echo json_encode(['login'=>$login, 'location'=>$loc]);
    }
 
    public function signup($conn,$username,$password,$firstname,$middlename,$lastname,$municipality,$usertype){
        if($conn->query("INSERT INTO users(username,password,firstname,middlename,lastname,usertype,municipality_id) 
        values('$username','$password','$firstname','$middlename','$lastname','$usertype',$municipality)")){
                $_SESSION['userloc'] = $municipality;
                $_SESSION['usertype'] = $usertype;
            echo true;
        }else{
            echo false;
        }
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
                        <th>ASSIGNMENT</th>
                        <th>TEAM</th>
                    </tr>";
            $result = $conn->query("SELECT *, u.id AS uid FROM users AS u LEFT JOIN team AS t ON u.team_id = t.id WHERE usertype = 'personnel' AND u.municipality_id = ".$city);
            while($get = $result->fetch_assoc()){
                $middlename = "";
                $status = "Absent";
                $ownteam = "";
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
                <td>$assignment</td>
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
                if($res['status'] == 1){
                    $status = "Available";
                }else if($res['status'] == 2){
                    $status = "On use";
                }
                $tbody .= "<tr>
                        <td>".$res['vehicle']."</td>
                        <td>".$res['type']."</td>
                        <td>".$status."</td>
                    </tr>";
            }
        }else{
            $thead = "<tr>
                        <th>INCIDENT TYPE</th>
                        <th>LOCATION</th>
                        <th>RESPONDING TEAM</th>
                        <th>STATUS OF TEAM</th>
                    </tr>";
            $result = $conn->query("SELECT *,r.status AS rstatus FROM activities AS a INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id WHERE t.municipality_id = $city");
            while($res = $result->fetch_assoc()){
                $status = "";
                if($res['rstatus'] == 1){
                    $status = "On going";
                }else if($res['rstatus'] == 2){
                    $status = "On working";
                }else{
                    $status = "Done";
                }
                $tbody .= "<tr value='".$res['activities_id']."|".$res['team_id']."'>
                <td>".$res['activity']."</td>
                <td>".$res['location']."</td>
                <td>".$res['name']."</td>
                <td>$status</td>
                </tr>";
            }
        }
        echo json_encode(['thead'=>$thead,'tbody'=>$tbody, 'showbtn'=>$showbtn, 'city'=>$city]);
    }

}