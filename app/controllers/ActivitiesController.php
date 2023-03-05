<?php
class ActivitiesController{
   
    public function getAcList($conn){
        $city = $_SESSION['city_id'];
        $result = $conn->query("SELECT * FROM activities AS a INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id WHERE t.municipality_id = $city GROUP BY a.id ORDER BY a.id DESC");
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
        $city = $_SESSION['city_id'];
        $tbody = "";
        $clickable = false;
        if($city === $_SESSION['userloc'] && $_SESSION['usertype'] === "admin"){
            $clickable = true;
            $result = $conn->query("SELECT * FROM activities WHERE status < 2");
            while($res = $result->fetch_assoc()){
                $getTeam = $conn->query("SELECT *,t.name AS tname FROM responded_team AS r INNER JOIN team AS t INNER JOIN municipality AS m ON r.team_id = t.id AND t.municipality_id = m.id WHERE activities_id = ".$res['id']);
                $status = "New";
                $team = "";
                $i = 1;
                while($gteam = $getTeam->fetch_assoc()){
                    $team .= $gteam['name']." : ".$gteam['tname'];
                    if(mysqli_num_rows($getTeam) > $i){
                        $team .= ", ";
                        $i++;
                    }
                    $status = "Work in progress";
                }
                if($res['status'] == 1){
                    $status = "Responding";
                }
                $tbody .= "<tr value='".$res['id']."'>
                    <td>".$res['activity']."</td>
                    <td>".$res['location']."</td>
                    <td>$team</td>
                    <td>".$status."</td>
                    <td hidden>".$res['summary']."</td>
                    <td hidden>".$res['image']."</td>
                </tr>";
            }
        }else if($_SESSION['usertype'] === "admin"){
            $result = $conn->query("SELECT *, group_concat(name SEPARATOR ', ') AS teams FROM activities AS a 
            INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id 
            WHERE t.municipality_id = $city GROUP BY a.id");
            while($res = $result->fetch_assoc()){
                $status = "New";
                if($res['status'] == 1){
                    $status = "Responding";
                }
                $tbody .= "<tr>
                    <td>".$res['activity']."</td>
                    <td>".$res['location']."</td>
                    <td>".$res['teams']."</td>
                    <td>".$status."</td>
                </tr>";
            }
        }
        echo json_encode(['tbody'=>$tbody, 'clickable'=>$clickable]);
    }

    public function getNewActivity($conn){
        $result = $conn->query("SELECT * FROM activities WHERE status = 0");
        echo mysqli_num_rows($result);
    }

    public function getAvailable($conn){
        $city = $_SESSION['city_id'];
        $getTeam = $conn->query("SELECT * FROM team AS t LEFT JOIN responded_team AS r ON t.id = r.team_id WHERE municipality_id = $city AND status IS NULL OR status = 1");
        $getVehicle = $conn->query("SELECT * FROM vehicle WHERE status = 1 AND municipality_id = $city");
        if(mysqli_num_rows($getTeam) > 0){
            echo "<div class='grid-cont'>
                <h3 class='grid-title'>Team</h3>
                <div class='grid-body bc'>";
            while($team = $getTeam->fetch_assoc()){
                echo "<div class='col-4'>
                    <p value='".$team['id']."'>".$team['name']."</p>
                </div>";
            }
            echo "</div>
            </div>";
        }else{
            echo "<h3 class='grid-title'>No available team</h3>";
        }
        
        if(mysqli_num_rows($getVehicle) > 0){
            echo "<table class='mt-30 box-shadow table-text-left'>
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id='vehicle' style='cursor: pointer'>";
            while($vehicle = $getVehicle->fetch_assoc()){
                echo "<tr value='".$vehicle['id']."'>
                    <td>".$vehicle['vehicle']."</td>
                    <td><div class='table-div'>".$vehicle['type']."</div></td>
                </tr>";
            }
            echo "</tbody>
            </table>";
        }else{
            echo "<h3 class='grid-title'>No available vehicle</h3>";
        }
    }
    
    public function rtcs($conn, $activities, $team, $status){
        $conn->query("UPDATE responded_team SET status = $status WHERE activities_id = $activities AND team_id = $team");
        if($status == 3){

        }
        echo 'updated';
    }
}