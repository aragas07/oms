<?php
class ActivitiesController{
    public function insertActivities($conn,$disaster,$location,$date,$summary){
        if($conn->query("INSERT INTO activities(activity,location,date,summary,team_status) VALUES('$disaster','$location','$date','$summary',0)")){
            echo true;
        }else{
            echo false;
        }
    }
}