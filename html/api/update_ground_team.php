<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../objects/ground_teams.php");

if(!isset($_POST["id"]) or empty($_POST["id"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["cov"]) or empty($_POST["cov"]) or
   !isset($_POST["driver"]) or empty($_POST["driver"]) or
   !isset($_POST["leader"]) or empty($_POST["leader"]) or
   !isset($_POST["passengers"]) or (int)$_POST["passengers"] < 0 or
   !isset($_POST["status"]) or empty($_POST["status"]) or
   !isset($_POST["location"]) or empty($_POST["location"])){
    http_response_code(400);
    die();
}
$id = $_POST["id"];
$name = $_POST["name"];
$cov = $_POST["cov"];
$driver = $_POST["driver"];
$leader = $_POST["leader"];
$passengers = (int)$_POST["passengers"];
$status = $_POST["status"];
$location = $_POST["location"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("UPDATE `deployed_ground` SET `name`=?, `cov`=?, `driver`=?, ".
"`leader`=?, `passengers`=?, `status`=?, `location`=?, `checkin`=UNIX_TIMESTAMP() WHERE `id`=?");
$stmt->bind_param("ssssissi", $name, $cov, $driver, $leader, $passengers, $status, $location, $id);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}

// Audit Log
$team = new GroundTeam($id);
$stmt = $conn->prepare("INSERT INTO `audit` (`sortie_type`, `sortie_id`, `entry`, `timestamp`) VALUES".
'("ground", ?, ?, UNIX_TIMESTAMP())');
$entry = "Updated Sortie (Database ID ".$id.")\n".
"\n".
"Mission: ".$team->mission."\n".
"Sortie: ".$team->sortie."\n".
"Tasking: ".$team->name."\n".
"COV: ".$team->cov."\n".
"Driver: ".$team->driver."\n".
"GTL: ".$team->leader."\n".
"Passengers: ".$team->passengers."\n".
"Status: ".$team->status."\n".
"Location: ".$team->location;
$stmt->bind_param("is", $id, $entry);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error, "code"=>5)));
}
$stmt->close();
$conn->close();
header("Location:/");
?>
