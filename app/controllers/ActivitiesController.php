<?php
class ActivitiesController{
    public function insertActivities($conn){
        echo json_encode(["disaster"=>$_POST['disaster'],"location"=>$_POST['location']]);
    }
}