<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../objects/air_teams.php");

if(!isset($_POST["id"]) or empty($_POST["id"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["callsign"]) or empty($_POST["callsign"]) or
   !isset($_POST["mp"]) or empty($_POST["mp"]) or
   !isset($_POST["mo"]) or empty($_POST["mo"]) or
   !isset($_POST["ms_ap"]) or empty($_POST["ms_ap"]) or
   !isset($_POST["status"]) or empty($_POST["status"]) or
   !isset($_POST["location"]) or empty($_POST["location"])){
    http_response_code(400);
    die();
}
$id = $_POST["id"];
$name = $_POST["name"];
$callsign = $_POST["callsign"];
$mp = $_POST["mp"];
$mo = $_POST["mo"];
$ms_ap = $_POST["ms_ap"];
$status = $_POST["status"];
$location = $_POST["location"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("UPDATE `deployed_air` SET `name`=?, `callsign`=?, `mp`=?, ".
"`mo`=?, `ms_ap`=?, `status`=?, `location`=?, `checkin`=UNIX_TIMESTAMP() WHERE `id`=?");
$stmt->bind_param("sssssssi", $name, $callsign, $mp, $mo, $ms_ap, $status, $location, $id);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}

// Audit Log
$team = new AirTeam($id);
$stmt = $conn->prepare("INSERT INTO `audit` (`sortie_type`, `sortie_id`, `entry`, `timestamp`) VALUES".
'("air", ?, ?, UNIX_TIMESTAMP())');
$entry = "Updated Sortie (Database ID ".$id.")\n".
"\n".
"Mission: ".$team->mission."\n".
"Sortie: ".$team->sortie."\n".
"Tasking: ".$team->name."\n".
"Callsign: ".$team->callsign."\n".
"MP: ".$team->mp."\n".
"MO: ".$team->mo."\n".
"MS/AP: ".$team->ms_ap."\n".
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
