<?php
class MainController{
    public function getCity($conn){
        $result = $conn->query("SELECT * FROM municipality");
        while($res = $result->fetch_assoc()){
            echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
        }
    }

    public function attendance($conn){
        $icon = "error";
        $msg = "";
        $name = explode(", ",$_POST['name']);
        $fname = $name[1];
        $lname = $name[0];
        $getPerson = $conn->query("SELECT * FROM users where firstname like '%$fname%' AND lastname like '%$lname%' OR firstname like '%$lname%' AND lastname like '%$fname%'");
        if(mysqli_num_rows($getPerson) != 0){
            $icon = "success";
            $userid = "";
            while($person = $getPerson->fetch_assoc()){
                $userid = $person['id'];
            }
            $getStatus = $conn->query("SELECT * FROM logs WHERE users_id = $userid AND DATE(date) = CURDATE()");
            if(mysqli_num_rows($getStatus) == 0){
                $conn->query("INSERT INTO logs(users_id,date,status,timein,timeout) VALUES($userid,now(),1,now(),'')");
                $msg = 'Login';
            }else{
                $conn->query("UPDATE logs SET timeout = now() WHERE users_id = $userid AND DATE(date) = CURDATE()");
                $msg = 'Logout';
            }
        }else{
            $msg = $lname.' not found at the data';
        }
        echo json_encode(['icon'=>$icon, 'msg'=>$msg]);
    }

    public function getPersonnel($conn){
        $result = $conn->query("SELECT * FROM users WHERE usertype = 'personnel' AND municipality_id = ".$_SESSION['city_id']);
        while($get = $result->fetch_assoc()){
            $middlename = "";
            if(strlen($get['middlename']) > 0){
                $middlename = substr(ucfirst($get['middlename']),0,1).".";
            }
            echo "<option value='".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])."'>";
        }
    }
}