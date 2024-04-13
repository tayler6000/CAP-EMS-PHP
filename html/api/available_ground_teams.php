<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("../objects/ground_teams.php");

    $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
    $stmt = $conn->prepare('SELECT * FROM `deployed_ground` WHERE `status` != "Completed" AND `status` != "Cancelled"');
    $stmt->execute();
    $result = $stmt->get_result();
    if($result === False){
        print($conn->error);
    }
    $ret = array();
    while($row = mysqli_fetch_assoc($result)){
        $team = new GroundTeam($row["id"]);
        $ret[$team->id] = $team->mission." / ".$team->sortie;
    }
    $conn->close();
    echo(json_encode($ret));
?>
