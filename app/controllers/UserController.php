<?php
class UserController{
    public function login($conn,$username,$password){
        $result = $conn->query("SELECT * FROM users where username = '$username' and password = '$password'");
        if(mysqli_num_rows($result) == 0){
            echo false;
        }else{
            echo true;
        }
    }

    public function getUser($conn,$username,$password,$firstname,$middlename,$lastname){
        $conn->query("INSERT INTO users(username,password,firstname,middlename,lastname) values('$username','$password','$firstname','$middlename','$lastname')");
        echo true;
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
        if($type == "PERSONNEL"){
            $thead = "<tr>
                        <th>PERSONNEL</th>
                        <th>STATUS</th>
                        <th>ASSIGNMENT</th>
                    </tr>";
            $result = $conn->query("SELECT * FROM team INNER JOIN personnel ON team.id = personnel.team_id WHERE team.municipality_id = ".$_SESSION['city_id']);
            while($get = $result->fetch_assoc()){
                $middlename = "";
                $status = "Absent";
                if($get["status"] == 1){
                    $status = "On duty";
                }
                if(strlen($get['middlename']) > 0){
                    $middlename = substr(ucfirst($get['middlename']),0,1).".";
                }
                $tbody .= '<tr>
                <td>'.ucfirst($get["lastname"]).', '.ucfirst($get['firstname'])." ".$middlename.'</td>
                <td>'.$status.'</td>
                <td>'.ucfirst($get["assignment"]).'</td>
                </tr>';
            }
        }else if($type == "VEHICLE"){
            $thead = "<tr>
                        <th>VEHICLE #</th>
                        <th>TYPE</th>
                        <th>STATUS</th>
                    </tr>";
            $result = $conn->query("SELECT * FROM vehicle WHERE municipality_id = ".$_SESSION['city_id']);
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
        echo json_encode(['thead'=>$thead,'tbody'=>$tbody]);
    }

    public function getAcList($conn){
        $city = $_SESSION['city_id'];
        $result = $conn->query("SELECT * FROM team AS t INNER JOIN activities AS a ON t.id = a.team_id WHERE t.municipality_id = $city ORDER BY a.id DESC");
        $activity = "";
        $location = "";
        $date = "";
        while($res = $result->fetch_assoc()){
            $activity .= "<p>".$res['activity']."</p>";
            $location .= "<p>".$res['location']."</p>";
            $date .= "<p>".$res['date']."</p>";
        }
        echo json_encode(['activity'=>$activity,'location'=>$location,'date'=>$date]);
    }

    public function getReport($conn){
        $result = $conn->query("SELECT *,m.name AS city FROM municipality AS m INNER JOIN team AS t INNER JOIN activities AS a 
        ON t.id = a.team_id and m.id = t.municipality_id WHERE municipality_id = ".$_SESSION['city_id']);
        while($res = $result->fetch_assoc()){
            $status = "";
            if($res['team_status'] == 1){
                $status = "Responded to incident";
            }
            echo "<tr>
                <td>".$res['activity']."</td>
                <td>".$res['location']."</td>
                <td>".$res['city'].": ".$res['name']."</td>
                <td>".$status."</td>
            </tr>";
        }
    }
}