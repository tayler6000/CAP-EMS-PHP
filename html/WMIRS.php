<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    date_default_timezone_set(empty(getenv("TIMEZONE")) ? "Zulu" : getenv("TIMEZONE"));
    error_reporting(E_ALL);
    require_once("objects/ground_teams.php");
    require_once("objects/air_teams.php");
    require_once("objects/suas_teams.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charSet="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>CAP EMS - WMIRS Entry</title>
        <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet">
        <script src="/js/update.js"></script>
        <script>
            function mark(id){
                document.location="/api/WMIRS.php?id="+id;
            }
        </script>
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <p id="time"></p>
            <?php
                $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                $stmt = $conn->prepare('SELECT * FROM `audit` WHERE `WMIRS`="false" LIMIT 1');
                $stmt->execute();
                $result = $stmt->get_result();
                if($result === False){
                    print($conn->error);
                }
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    $id = $row["id"];
                    $sortie_id = $row["sortie_id"];
                    if($row["sortie_type"] == "ground"){
                        $sortie = new GroundTeam($sortie_id);
                        $prefix = "G";
                    }elseif($row["sortie_type"] == "air"){
                        $sortie = new AirTeam($sortie_id);
                        $prefix = "A";
                    }elseif($row["sortie_type"] == "suas"){
                        $sortie = new SUASTeam($sortie_id);
                        $prefix = "G";
                    }
                    print("Mission: ".$sortie->mission."<br />");
                    print("Sortie: ".$prefix.str_pad($sortie->sortie, 4, '0', STR_PAD_LEFT)."<br />");
                    print("<br/>");
                    print("Audit Entry:<br/>");
                    print("<textarea disabled style='width:35%;height:20em;resize:both;'>".$row["entry"]."</textarea><br/>");
                    print("<br/>");
                    print("Date: <input value='".date("d M Y", $row["timestamp"])."' disabled><br/>");
                    print("Time: ".date("Hi e", $row["timestamp"])."<br/>");
                    print("<br/>");
                    print("<br/>");
                    print("<button class='btn btn-primary' onclick='javascript:mark(".$id.")'>Mark as Logged</button>");
                }else{
                    print("All entries in WMIRS.");
                }
                $stmt->close();
                $conn->close();
            ?>
        </div>
        <script>
            update("/api/time.php", document.getElementById("time"));
            setInterval(update, 1000, "/api/time.php", document.getElementById("time"));
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
