<?php
class MainController{
    public function getCity($conn){
        $result = $conn->query("SELECT * FROM municipality");
        while($res = $result->fetch_assoc()){
            echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
        }
    }

    public function attendance($conn){
        
    }

    public function getPersonnel($conn){
        $result = $conn->query("SELECT * FROM users WHERE usertype = 'personnel' AND municipality_id = ".$_SESSION['city_id']);
        while($get = $result->fetch_assoc()){
            $middlename = "";
            if(strlen($get['middlename']) > 0){
                $middlename = substr(ucfirst($get['middlename']),0,1).".";
            }
            echo "<option value='".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])." ".$middlename."'>";
        }
    }
}