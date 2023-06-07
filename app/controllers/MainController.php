<?php
class MainController{
    public function getCity($conn){
        $result = $conn->query("SELECT * FROM municipality");
        while($res = $result->fetch_assoc()){
            echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
        }
    }

    public function attendance($conn){
        $icon = "error";
        $msg = "";
        $cid = $_SESSION['city_id'];
        $name = explode(", ",$_POST['name']);
        $fname = $name[1];
        $lname = $name[0];
        $getPerson = $conn->query("SELECT * FROM users where firstname like '%$fname%' AND lastname like '%$lname%' 
        AND municipality_id = $cid OR firstname like '%$lname%' AND lastname like '%$fname%' AND municipality_id = $cid");
        if(mysqli_num_rows($getPerson) != 0){
            $icon = "success";
            $userid = "";
            while($person = $getPerson->fetch_assoc()){
                $userid = $person['id'];
            }
            $getStatus = $conn->query("SELECT * FROM logs WHERE users_id = $userid AND DATE(date) = CURDATE()");
            if(mysqli_num_rows($getStatus) == 0){
                $conn->query("INSERT INTO logs(users_id,date,status,timein,timeout) VALUES($userid,now(),1,now(),'')");
                $msg = 'Login';
            }else{
                $conn->query("UPDATE logs SET timeout = now() WHERE users_id = $userid AND DATE(date) = CURDATE()");
                $msg = 'Logout';
            }
        }else{
            $msg = $lname.' not found at the data';
        }
        echo json_encode(['icon'=>$icon, 'msg'=>$msg]);
    }

    public function getPersonnel($conn){
        $result = $conn->query("SELECT * FROM users WHERE usertype = 'personnel' AND municipality_id = ".$_SESSION['city_id']);
        while($get = $result->fetch_assoc()){
            $middlename = "";
            if(strlen($get['middlename']) > 0){
                $middlename = substr(ucfirst($get['middlename']),0,1).".";
            }
            echo "<option value='".ucfirst($get["lastname"]).", ".ucfirst($get["firstname"])."'>";
        }
    }
    
    public function updateTeamName($conn,$id,$name){
        $conn->query("UPDATE team SET name = '$name' WHERE id = $id");
    }

    public function getPandT($conn){
        $id = $_SESSION['city_id'];
        $getNew = $conn->query("SELECT *,users.id AS uid FROM users WHERE usertype='personnel' AND team_id is null AND municipality_id = $id");
        if(mysqli_num_rows($getNew) > 0){
            echo "<h3 class='grid-title'>New Personnel</h3>
            <div class='grid-body bcc'>";
            while($new = $getNew->fetch_assoc()){
                $getTeam = $conn->query("SELECT * FROM team WHERE municipality_id = $id");
                $middlename = "";
                if(strlen($new['middlename']) > 0){
                    $middlename = substr(ucfirst($new['middlename']),0,1).".";
                }
                echo "<div class='col-4'>
                    <div class='delete'>
                        <div class='delete-icon'></div>
                    </div>
                    <p value='".$new['uid']."'>".ucfirst($new["lastname"]).", ".ucfirst($new["firstname"])." ".$middlename."</p>
                    <div class='bubble'><h4>Set team</h4>";
                while($gteam = $getTeam->fetch_assoc()){
                    echo "<b value='".$gteam['id']."'>".$gteam['name']."</b>";
                }
                    
                    echo "</div>
                </div>";
            }
            echo "</div>";
        }
        $getTeam = $conn->query("SELECT * FROM team WHERE municipality_id = $id");
        if(mysqli_num_rows($getTeam) > 0){
            while($team = $getTeam->fetch_assoc()){
                echo "<div class='grid'><h3 id='".$team['id']."' class='grid-title'>".$team['name']."</h3><button class='grid-button'>Edit</button></div>
                <div class='grid-body bc'>";
                $getTeamMember = $conn->query("SELECT * FROM users WHERE team_id = ".$team['id']);
                while($member = $getTeamMember->fetch_assoc()){
                    $allTeam = $conn->query("SELECT * FROM team WHERE municipality_id = $id");
                    $middlename = "";
                    if(strlen($member['middlename']) > 0){
                        $middlename = substr(ucfirst($member['middlename']),0,1).".";
                    }
                    echo "<div class='col-4'>
                        <p value='".$member['id']."'>".ucfirst($member["lastname"]).", ".ucfirst($member["firstname"])." ".$middlename."</p>
                        <div class='bubble'><h4>Change team</h4>";
                        while($ateam = $allTeam->fetch_assoc()){
                            echo "<b value='".$ateam['id']."'>".$ateam['name']."</b>";
                        }
                    echo "</div>
                    </div>";
                }
                echo "</div>";
            }
        }
    }

    public function deletePersonnel($conn, $id){
        $icon = "error";
        $msg = "Sorry we have a database problem";
        $title = "Error";
        $showMessage = true;
        if($conn->query("DELETE FROM users WHERE id = $id")){
            $msg = "The personnel has been deleted";
            $icon = "success";
            $title = "Deleted!";
        }
        echo json_encode(['icon'=>$icon,'msg'=>$msg,'title'=>$title, 'showMessage'=>$showMessage]);
    }

    public function changeTeam($conn,$id,$tid){
        $icon = "error";
        $msg = "Sorry we have a database problem";
        $title = "Error";
        $showMessage = true;
        if($conn->query("UPDATE users SET team_id = $tid WHERE id = $id")){
            $showMessage = false;
        }
        echo json_encode(['icon'=>$icon,'msg'=>$id,'title'=>$tid, 'showMessage'=>$showMessage]);
    }

    public function response($conn, $id){
        $conn->query("UPDATE help SET status = 2 WHERE activities = $id AND municipality_id = ".$_SESSION['userloc']);
    }

    public function addteam($conn, $team){
        $mun = $_SESSION['userloc'];
        $conn->query("INSERT INTO team(name,municipality_id,status) VALUES('$team',$mun,0)");
        echo true;
    }

    public function getAbout($conn){
        $city = $_SESSION['city_id'];
        $text = "";
        $img = "";
        $getAbout = $conn->query("SELECT * FROM abouts WHERE municipality_id = $city");
        while($about = $getAbout->fetch_assoc()){
            $text = $about['about'];
            $img = $about['img'];
        }
        echo json_encode(['text'=>$text,'img'=>$img]);
    }

    public function updateAbout($conn, $details,$img){
        $city = $_SESSION['city_id'];
        $conn->query("UPDATE abouts SET about = '$details', img = '$img' WHERE id = $city");
        
    }

    public function addVehicle($conn, $vehicle, $type){
        $city = $_SESSION['city_id'];
        if($conn->query("INSERT INTO vehicle (vehicle,type,municipality_id) VALUES('$vehicle','$type',$city)")){
            echo true;
        }else{echo false;}
    }

    public function deleteVehicle($conn, $id){
        $conn->query("DELETE FROM vehicle WHERE id = $id");
    }
}