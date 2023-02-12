<?php
class ActivitiesController{
   
    public function getAcList($conn){
        $city = $_SESSION['city_id'];
        $result = $conn->query("SELECT * FROM activities AS a INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id WHERE t.municipality_id = $city ORDER BY a.id DESC");
        $activity = "";
        $location = "";
        $date = "";
        $image = "";
        while($res = $result->fetch_assoc()){
            $activity .= "<p>".$res['activity']."</p>";
            $location .= "<p>".$res['location']."</p>";
            $date .= "<p>".$res['date']."</p>";
            $image .= "<div class='col-4'><img src='".$res['image']."'></div>";
        }
        echo json_encode(['activity'=>$activity,'location'=>$location,'date'=>$date,'image'=>$image,'selfMun'=>$city === $_SESSION['userloc']]);
    }

    public function insertActivities($conn,$disaster,$location,$date,$summary,$image,$municipality){
        if($conn->query("INSERT INTO activities(activity,location,date,summary,team_status,image,municipality_id,status) VALUES('$disaster','$location','$date','$summary',0,'$image',$municipality,0)")){
            echo true;
        }else{
            echo false;
        }
    }

    public function getReport($conn){
        $result = $conn->query("SELECT * FROM activities AS a INNER JOIN municipality AS m ON a.municipality_id = m.id WHERE municipality_id = ".$_SESSION['city_id']);
        while($res = $result->fetch_assoc()){
            $status = "";
            if($res['team_status'] == 1){
                $status = "Responded to incident";
            }
            echo "<tr>
                <td>".$res['activity']."</td>
                <td>".$res['location']."</td>
                <td>Team from ".$res['name']."</td>
                <td>".$status."</td>
            </tr>";
        }
    }
}