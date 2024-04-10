<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("../objects/air_teams.php");
    $late_offset = get_air_late() * 60;
    $warning_offset = get_air_warning() * 60;
?>
<table style="text-align:center;">
    <tr>
        <th>Mission #</th>
        <th>Sortie #</th>
        <th>Tasking</th>
        <th>Callsign</th>
        <th>MP</th>
        <th>MO</th>
        <th>MS/AP</th>
        <th>Status</th>
        <th>Location</th>
        <th>Checkin</th>
        <th>Edit</th>
    </tr>
    <?php
        $late_alarm = False;
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare('SELECT * FROM `deployed_air` WHERE `status` != "Completed" AND `status` != "Cancelled"
        UNION SELECT * FROM `deployed_air` WHERE `status` = "Completed" OR `status` = "Cancelled"');
        $stmt->execute();
        $result = $stmt->get_result();
        if($result === False){
            print($conn->error);
        }
        while($row = mysqli_fetch_assoc($result)){
            $team = new AirTeam($row["id"]);
            if($team->status === "Completed" or $team->status === "Cancelled") {
                if((time() - $warning_offset) > $team->checkin){
                    continue;
                }
                print("<tr style='background-color: lightgray;'>");
            }elseif((time() - $late_offset) > $team->checkin){
                print("<tr style='background-color: red;color: white;'>");
                $late_alarm = True;
            }elseif((time() - $warning_offset) > $team->checkin){
                print("<tr style='background-color: orange;color: white;'>");
            }else{
                print("<tr>");
            }
            print("<td>".$team->mission."</td>");
            print("<td>".$team->sortie."</td>");
            print("<td>".$team->name."</td>");
            print("<td>".$team->callsign."</td>");
            print("<td>".$team->mp."</td>");
            print("<td>".$team->mo."</td>");
            print("<td>".$team->ms_ap."</td>");
            print("<td>".$team->status."</td>");
            print("<td>".$team->location."</td>");
            print("<td>".date("d M y Hi e", $team->checkin)."</td>");
            print("<td><button type='button' class='btn btn-secondary'".
            "onclick='javascript:editAirTeam(".$team->id.")'>Edit</button></td>");
            print("</tr>");
        }
        $conn->close();
        if($late_alarm) {
            http_response_code(202);
        }
    ?>
</table>
