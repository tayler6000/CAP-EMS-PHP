<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("../objects/ground_teams.php");
    $late_offset = 35 * 60;
    $warning_offset = 30 * 60;
?>
<table style="text-align:center;">
    <tr>
        <th>Mission #</th>
        <th>Sortie #</th>
        <th>Name</th>
        <th>COV</th>
        <th>Driver</th>
        <th>GTL</th>
        <th>Passengers</th>
        <th>Status</th>
        <th>Location</th>
        <th>Checkin</th>
        <th>Action</th>
    </tr>
    <?php
        $late_alarm = False;
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare('SELECT * FROM `deployed_ground` WHERE `status` != "Completed" AND `status` != "Cancelled"
        UNION SELECT * FROM `deployed_ground` WHERE `status` = "Completed" OR `status` = "Cancelled"');
        $stmt->execute();
        $result = $stmt->get_result();
        if($result === False){
            print($conn->error);
        }
        while($row = mysqli_fetch_assoc($result)){
            $team = new GroundTeam($row["id"]);
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
            print("<td>".$team->cov."</td>");
            print("<td>".$team->driver."</td>");
            print("<td>".$team->leader."</td>");
            print("<td>".$team->passengers."</td>");
            print("<td>".$team->status."</td>");
            print("<td>".$team->location."</td>");
            print("<td>".date("d M y Hi e", $team->checkin)."</td>");
            print("<td><button type='button' class='btn btn-secondary'>Action</button></td>");
            print("</tr>");
        }
        if($late_alarm) {
            require("alert.php");
        }
    ?>
</table>
