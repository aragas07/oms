<?php
    $url = explode("/",$_SERVER['REQUEST_URI']);
    switch($url[2]){
        case "login": echo $sample->example(); break;
    }
?>