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
        if($type == "PERSONNEL"){
            $thead = "<tr>
                        <th>PERSONNEL</th>
                        <th>STATUS</th>
                        <th>ASSIGNMENT</th>
                        <th>TEAM</th>
                    </tr>";
            $result = $conn->query("SELECT *,t.name AS team_name, u.id AS uid FROM municipality AS m INNER JOIN users AS u LEFT JOIN team AS t on m.id = u.municipality_id 
            AND u.team_id = t.id WHERE usertype = 'personnel' and m.id = ".$city);
            while($get = $result->fetch_assoc()){
                $middlename = "";
                $status = "Absent";
                $ownteam = "";
                $municipality = "";
                $team = "";
                if(strlen($get['middlename']) > 0){
                    $middlename = substr(ucfirst($get['middlename']),0,1).".";
                }
                if($city === $_SESSION['userloc'] && $_SESSION['usertype'] === "admin"){
                    // $municipality = "<select arg='".$get['uid']."' name='personnelstatus'>
                    //     <option value='0'>Absent</option>
                    //     <option value='1'>On Duty</option>
                    // </select>";
                    // $getTeam = $conn->query("SELECT * FROM team WHERE municipality_id = $city");
                    // $team = "<select name='personnelteam'>
                    //     <option value=''>select team</option>";
                    //     while($gteam = $getTeam->fetch_assoc()){
                    //         $team .= "<option value='".$gteam['id']."'>".$gteam['name']."</option>";
                    //     }
                    // "</select>";
                    $showbtn = true;
                }else{
                    $status = "On Duty";
                }
                $tbody .= "<tr>
                <td>".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])." ".$middlename."</td>
                <td>$municipality</td>
                <td>".ucfirst($get["assignment"])."</td>
                <td>$team</td>
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
                    $status = "On going";
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
        }
        echo json_encode(['thead'=>$thead,'tbody'=>$tbody, 'showbtn'=>$showbtn]);
    }

}