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
        if($conn->query("INSERT INTO activities(activity,location,date,summary,image,municipality_id,status) VALUES('$disaster','$location','$date','$summary','$image',$municipality,0)")){
            $getId = $conn->query("SELECT id FROM activities ORDER BY id DESC LIMIT 1");
           while($get = $getId->fetch_assoc()){
                echo json_encode(['success'=>true, 'id'=>$get['id']]);
            }
        }else{
            echo false;
        }
    }

    public function getReport($conn,$type){
        $city = $_SESSION['city_id'];
        $tbody = "";
        $thead = "<tr>
            <th>INCIDENT TYPE</th>
            <th>LOCATION</th>
            <th>RESPONDING TEAM</th>
            <th>STATUS</th>
        </tr>";
        $clickable = false;
        if($city === $_SESSION['userloc'] && $_SESSION['usertype'] === "admin"){
            if($type == 0){
                $result = $conn->query("SELECT * FROM activities WHERE municipality_id = $city AND status < 2");
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
                        $status = "On working";
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
            }else{
                $thead = "<tr>
                    <th>REQUESTED BY</th>
                    <th>INCIDENT TYPE</th>
                    <th>LOCATION</th>
                </tr>";
                $result = $conn->query("SELECT *,a.id AS aid FROM help AS h INNER JOIN activities AS a INNER JOIN municipality AS m ON h.activities = a.id AND a.municipality_id = m.id WHERE h.municipality_id = $city AND a.status < 2");
                while($res = $result->fetch_assoc()){
                    $tbody .= "<tr value='".$res['aid']."'>
                        <td>".$res['name']."</td>
                        <td>".$res['activity']."</td>
                        <td>".$res['location']."</td>
                        <td hidden></td>
                        <td hidden>".$res['summary']."</td>
                        <td hidden>".$res['image']."</td>
                    </tr>";
                }
            }
            $clickable = true;
            
        }else if($_SESSION['usertype'] === "admin"){
            $result = $conn->query("SELECT *, group_concat(name SEPARATOR ', ') AS teams FROM activities AS a 
            INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id 
            WHERE t.municipality_id = $city GROUP BY a.id");
            while($res = $result->fetch_assoc()){
                $status = "New";
                if($res['status'] == 1){
                    $status = "On working";
                }else if($res['status'] == 2){
                    $status = "Done";
                }
                $tbody .= "<tr>
                    <td>".$res['activity']."</td>
                    <td>".$res['location']."</td>
                    <td>".$res['teams']."</td>
                    <td>".$status."</td>
                </tr>";
            }
        }
        echo json_encode(['thead'=>$thead, 'tbody'=>$tbody, 'clickable'=>$clickable]);
    }

    public function getNewActivity($conn){
        $result = $conn->query("SELECT * FROM help WHERE status = 0 AND municipality_id = ".$_SESSION['userloc']);
        echo mysqli_num_rows($result);
    }

    public function getAvailable($conn){
        $city = $_SESSION['city_id'];
        $getTeam = $conn->query("SELECT * FROM team WHERE municipality_id = $city AND status = 0");
        $getVehicle = $conn->query("SELECT * FROM vehicle WHERE status = 0 AND municipality_id = $city");
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
                    <td><div class='table-div'>".$vehicle['type']." <b>❏</b></div></td>
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
    }
    
    public function rteam($conn, $tid, $aid){
        $conn->query("INSERT INTO responded_team(activities_id,team_id) VALUES($aid,$tid)");
        $conn->query("UPDATE team SET status = 1 WHERE id = $tid");
        $getAct = $conn->query("SELECT * FROM users WHERE team_id = $tid");
        while($get = $getAct->fetch_assoc()){
            $conn->query("UPDATE logs SET assignment = $aid WHERE date = curdate() AND users_id = ".$get['id']);
        }
    }

    public function rveh($conn,$id,$aid){
        $conn->query("UPDATE vehicle SET status = 1 WHERE id = $id");
        $conn->query("INSERT INTO responding_vehicle(activity_id,vehicle_id) VALUES($aid,$id)");
    }

    public function updateTeam($conn, $id, $value, $bool){
        $conn->query("UPDATE team SET status = $value WHERE id = $id");
        if($bool){
            $getAct = $conn->query("SELECT * FROM activities AS a INNER JOIN responded_team AS r ON a.id = r.activities_id WHERE status < 2 AND team_id = $id");
            while($get = $getAct->fetch_assoc()){
                $conn->query("UPDATE activities SET status = 1 WHERE id = ".$get['id']);
            }
        }
    }
    
    public function updateVeh($conn, $id, $stats, $response){
        if($response){
            $conn->query("UPDATE vehicle SET status = $stats WHERE id = $id");
            echo json_encode(['onUse'=>false, 'success'=>"Successfully to update the data", "vehicle_id"=>$id]);
        }else{
            $isUse = $conn->query("SELECT * FROM vehicle WHERE id = $id");
            while($is = $isUse->fetch_assoc()){
                if($is['status'] == 1 && $stats != 1){
                    echo json_encode(['onUse'=>true, 'vehicle'=>$is['vehicle'], 'vehicle_id'=>$id]);
                }else{
                    $conn->query("UPDATE vehicle SET status = $stats WHERE id = $id");
                    echo json_encode(['onUse'=>false,'vehicle_id'=>$id]);
                }
            }
        }
    }

    public function updateInc($conn, $id, $value){
        $conn->query("UPDATE activities SET status = $value WHERE id = $id");
        $respondt = $conn->query("SELECT * FROM responded_team WHERE activities_id = $id");
        $respondv = $conn->query("SELECT * FROM responding_vehicle WHERE activity_id = $id");
        while($get = $respondt->fetch_assoc()){
            $this->updateTeam($conn,$get['team_id'],0,false);
        }
        while($get = $respondv->fetch_assoc()){
            $this->updateVeh($conn,$get['vehicle_id'],0,1);
        }
    }
}