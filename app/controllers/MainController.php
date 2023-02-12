<?php
class MainController{
    public function getCity($conn){
        $result = $conn->query("SELECT * FROM municipality");
        while($res = $result->fetch_assoc()){
            echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
        }
    }
}