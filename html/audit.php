<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(!isset($_GET["type"]) or empty($_GET["type"]) or
       !isset($_GET["id"]) or empty($_GET["id"])){
        http_response_code(400);
        header("Location:/");
        die();
    }
    $type = $_GET["type"];
    $id = (int)$_GET["id"];
    if($type != "ground" and $type != "air" and $type != "suas"){
        http_response_code(400);
        header("Location:/");
        die();
    }
    require_once("objects/ground_teams.php");
    require_once("objects/air_teams.php");
    require_once("objects/suas_teams.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charSet="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>CAP EMS - Audit Log</title>
        <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet">
        <script src="/js/update.js"></script>
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <p id="time"></p>
            <?php
                if($type == "ground"){
                    $team = new GroundTeam($id);
                    print("<h2>Mission ".$team->mission." Ground Sortie ".$team->sortie."</h2>");
                    print('<a href="/?type=ground&id='.$id.'" class="btn btn-primary">Edit Sortie</a><br><br>');
                    print("<h6>Current Entry:</h6>");
                    print("Mission: ".$team->mission."<br />");
                    print("Sortie: ".$team->sortie."<br />");
                    print("Tasking: ".$team->name."<br />");
                    print("COV: ".$team->cov."<br />");
                    print("Driver: ".$team->driver."<br />");
                    print("GTL: ".$team->leader."<br />");
                    print("Passengers: ".$team->passengers."<br />");
                    print("Status: ".$team->status."<br />");
                    print("Location: ".$team->location."<br />");
                    print("Checkin: ".date("d M y Hi e", $team->checkin)."<br />");
                    print("<br /><h6>Audit Trail:</h6><hr />");
                    $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                    $stmt = $conn->prepare('SELECT * FROM `audit` WHERE `sortie_type`="ground" AND `sortie_id`=?');
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result === False){
                        print($conn->error);
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        print(date("d M y Hi e", $row["timestamp"]));
                        print("<br/>");
                        print(nl2br($row["entry"])."<hr />");
                    }
                    $stmt->close();
                }elseif($type=="air"){
                    $team = new AirTeam($id);
                    print("<h2>Mission ".$team->mission." Air Sortie ".$team->sortie."</h2>");
                    print('<a href="/?type=air&id='.$id.'" class="btn btn-primary">Edit Sortie</a><br><br>');
                    print("<h6>Current Entry:</h6>");
                    print("Mission: ".$team->mission."<br />");
                    print("Sortie: ".$team->sortie."<br />");
                    print("Tasking: ".$team->name."<br />");
                    print("Callsign: ".$team->callsign."<br />");
                    print("MP: ".$team->mp."<br />");
                    print("MO: ".$team->mo."<br />");
                    print("MS/AP: ".$team->ms_ap."<br />");
                    print("Status: ".$team->status."<br />");
                    print("Location: ".$team->location."<br />");
                    print("Checkin: ".date("d M y Hi e", $team->checkin)."<br />");
                    print("<br /><h6>Audit Trail:</h6><hr />");
                    $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                    $stmt = $conn->prepare('SELECT * FROM `audit` WHERE `sortie_type`="air" AND `sortie_id`=?');
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result === False){
                        print($conn->error);
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        print(date("d M y Hi e", $row["timestamp"]));
                        print("<br/>");
                        print(nl2br($row["entry"])."<hr />");
                    }
                    $stmt->close();
                }elseif($type=="suas"){
                    $team = new SUASTeam($id);
                    print("<h2>Mission ".$team->mission." sUAS Sortie ".$team->sortie."</h2>");
                    print('<a href="/?type=suas&id='.$id.'" class="btn btn-primary">Edit Sortie</a><br><br>');
                    print("<h6>Current Entry:</h6>");
                    print("Mission: ".$team->mission."<br />");
                    print("Sortie: ".$team->sortie."<br />");
                    print("Tasking: ".$team->name."<br />");
                    print("Ground Team: ".($team->gt !== null ? $team->gt->mission." / ".$team->gt->sortie : "Not Assigned")."<br />");
                    print("MP: ".$team->mp."<br />");
                    print("Status: ".$team->status."<br />");
                    print("Location: ".$team->location."<br />");
                    print("Checkin: ".date("d M y Hi e", $team->checkin)."<br />");
                    print("<br /><h6>Audit Trail:</h6><hr />");
                    $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                    $stmt = $conn->prepare('SELECT * FROM `audit` WHERE `sortie_type`="sUAS" AND `sortie_id`=?');
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result === False){
                        print($conn->error);
                    }
                    while($row = mysqli_fetch_assoc($result)){
                        print(date("d M y Hi e", $row["timestamp"]));
                        print("<br/>");
                        print(nl2br($row["entry"])."<hr />");
                    }
                    $stmt->close();
                }else{
                    print("Unsupported Sortie Type");
                }
            ?>
        </div>
        <script>
            update("/api/time.php", document.getElementById("time"));
            setInterval(update, 1000, "/api/time.php", document.getElementById("time"));
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
