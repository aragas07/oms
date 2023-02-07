<?php
class ActivitiesController{
    public function insertActivities($conn,$disaster,$location,$date){
        $conn->query("INSERT INTO activities(activity,location,date,team_status) VALUES('$disaster','$location','$date',0)");

    }
}