<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("objects/ground_teams.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charSet="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Civil Air Patrol Emergency Managent System</title>
        <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet">
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <h6>Ground Teams</h6>
            <table>
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
                    print("<td>".$team->checkin."</td>");
                    print("<td><button>Action</button></td>");
                    print("</tr>");
                }
                ?>
            </table>
        </div>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
