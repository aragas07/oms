<?php

namespace app\controller;
class UserController{

    public function getUser(){
        $conn->query("INSERT INTO users(username,password) values('argie','arehoiwsd')");
    }
}