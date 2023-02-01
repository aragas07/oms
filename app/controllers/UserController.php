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
        try{
            $conn->query("INSERT INTO users(username,password,firstname,middlename,lastname) values('$username','$password','$firstname','$middlename','$lastname')");
            echo true;
        }catch(Exception $e){
            echo false;
        }
    }
}