<?php
require_once '../vendor/autoload.php';
session_start();
include '../app/database/dbconnection.php';
global $conn;
$mpdf = new Dompdf\Dompdf();

$pdf = "
<style>
    table{
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
    }

    th{
        text-align: center;
    }

    th, td{
        padding: 4px 10px;
        border: 1px solid black;
    }
    h1{
        font-weight: 700;
        color: #333;
        font-style: arial;
        text-align: center;
    }
</style>
<h1>BUREAU OF FIRE PROTECTION OPERATION MONITORING SYSTEM</h1>
<table>
    <thead>
        <tr>
            <th>Alarm status</th>
            <th>Cause</th>
            <th>LOCATION</th>
            <th>RESPONDING TEAM</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>";
     
$city = $_SESSION['city_id'];

$result = $conn->query("SELECT *, group_concat(name SEPARATOR ', ') AS teams, a.status AS astat, a.id AS aid FROM activities AS a 
INNER JOIN responded_team AS r INNER JOIN team AS t ON a.id = r.activities_id AND r.team_id = t.id 
WHERE t.municipality_id = $city GROUP BY a.id");
while($res = $result->fetch_assoc()){
    $status = "New";
    if($res['astat'] == 1){
        $status = "On working";
    }else if($res['astat'] == 2){
        $status = "Fire out";
    }
    $pdf.="<tr id='".$res['aid']."'>
    <td>".$res['alarmstatus']."</td> 
    <td>".$res['cause']."</td>
    <td>".$res['location']."</td>
    <td>".$res['teams']."</td>
    <td>".$status."</td></tr>";
}

$pdf.="</tbody>
</table>
";
$mpdf->loadHtml($pdf);
$mpdf->render();
$mpdf->stream();
?>