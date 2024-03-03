<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("../objects/ground_teams.php");
?>
<table style="text-align:center;">
    <tr>
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
        $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
        $stmt = $conn->prepare("SELECT * FROM `deployed_ground`");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result === False){
            print($conn->error);
        }
        while($row = mysqli_fetch_assoc($result)){
            $team = new GroundTeam($row["sortie"]);
            print("<tr>");
            print("<td>".$team->sortie."</td>");
            print("<td>".$team->name."</td>");
            print("<td>".$team->cov."</td>");
            print("<td>".$team->driver."</td>");
            print("<td>".$team->leader."</td>");
            print("<td>".$team->passengers."</td>");
            print("<td>".$team->status."</td>");
            print("<td>".$team->location."</td>");
            print("<td>".date("d M y Hi e", $team->checkin)."</td>");
            print("<td><button>Action</button></td>");
            print("</tr>");
        }
    ?>
</table>
