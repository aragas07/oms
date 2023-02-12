<?php
class UserController{
    public function login($conn,$username,$password){
        $result = $conn->query("SELECT * FROM users where username = '$username' and password = '$password'");
        if(mysqli_num_rows($result) == 0){
            echo false;
        }else{
            while($res = $result->fetch_assoc()){
                $_SESSION['userloc'] = $res['municipality_id'];
                $_SESSION['usertype'] = $res['usertype'];
            }
            echo true;
        }
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
        if($type == "PERSONNEL"){
            $thead = "<tr>
                        <th>PERSONNEL</th>
                        <th>STATUS</th>
                        <th>ASSIGNMENT</th>
                        <th>TEAM</th>
                    </tr>";
            $result = $conn->query("SELECT * FROM municipality INNER JOIN users on municipality.id = users.municipality_id 
            WHERE usertype = 'personnel' and municipality.id = ".$city);
            while($get = $result->fetch_assoc()){
                $middlename = "";
                $status = "Absent";
                if(strlen($get['middlename']) > 0){
                    $middlename = substr(ucfirst($get['middlename']),0,1).".";
                }
                if($city === $_SESSION['userloc'] && $_SESSION['usertype'] === "admin"){
                    $ownMun = "<select name='personnelstatus'>
                    <option>select</option>
                    <option value='1'>On Duty</option>
                        <option value='0'>Absent</option>
                    </select>";
                }else{
                    $status = "On Duty";
                }
                $tbody .= "<tr>
                <td>".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])." ".$middlename."</td>
                <td>$ownMun</td>
                <td>".ucfirst($get["assignment"])."</td>
                <td>".ucfirst($get["assignment"])."</td>
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
        echo json_encode(['thead'=>$thead,'tbody'=>$tbody]);
    }

}