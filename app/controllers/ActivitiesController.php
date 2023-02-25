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
        $result = $conn->query("SELECT * FROM activities WHERE status < 2");
        while($res = $result->fetch_assoc()){
            $status = "New";
            if($res['status'] == 1){
                $status = "Responding";
            }
            echo "<tr>
                <td>".$res['activity']."</td>
                <td>".$res['location']."</td>
                <td></td>
                <td>".$status."</td>
                <td hidden>".$res['summary']."</td>
                <td hidden>".$res['image']."</td>
            </tr>";
        }
    }

    public function getNewActivity($conn){
        $result = $conn->query("SELECT * FROM activities WHERE status = 0");
        echo mysqli_num_rows($result);
    }

    public function getAvailable($conn){
        $city = $_SESSION['city_id'];
        $getTeam = $conn->query("SELECT * FROM team AS t LEFT JOIN responded_team AS r ON t.id = r.team_id WHERE municipality_id = $city AND status IS NULL");
        $getVehicle = $conn->query("SELECT * FROM vehicle WHERE municipality_id = $city");
        echo "<div class='grid-cont'>
            <h3 class='grid-title'>Team</h3>
            <div class='grid-body bc'>";
        while($team = $getTeam->fetch_assoc()){
            echo "<div class='col-4'>
                <p>".$team['name']."</p>
            </div>";
        }
        echo "</div>
        </div>";
        
        echo "<table class='mt-30 box-shadow table-text-left'>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody id='vehicle' style='cursor: pointer'>";
        while($vehicle = $getVehicle->fetch_assoc()){
            echo "<tr>
                <td>".$vehicle['vehicle']."</td>
                <td><div class='table-div'>".$vehicle['type']."</div></td>
            </tr>";
        }
        echo "</tbody>
        </table>";
    }
}