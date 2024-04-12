<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../objects/suas_teams.php");

if(!isset($_POST["id"]) or empty($_POST["id"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["gt"]) or empty($_POST["gt"]) or
   !isset($_POST["mp"]) or empty($_POST["mp"]) or
   !isset($_POST["status"]) or empty($_POST["status"]) or
   !isset($_POST["location"]) or empty($_POST["location"])){
    http_response_code(400);
    die();
}
$id = $_POST["id"];
$name = $_POST["name"];
$gt = $_POST["gt"] == "null" ? null : (int)$_POST["gt"];
$mp = $_POST["mp"];
$status = $_POST["status"];
$location = $_POST["location"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("UPDATE `deployed_suas` SET `name`=?, `ground_id`=?, `mp`=?, ".
"`status`=?, `location`=?, `checkin`=UNIX_TIMESTAMP() WHERE `id`=?");
$stmt->bind_param("sssssi", $name, $gt, $mp, $status, $location, $id);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}

// Audit Log
$team = new SUASTeam($id);
$stmt = $conn->prepare("INSERT INTO `audit` (`sortie_type`, `sortie_id`, `entry`, `timestamp`) VALUES".
'("suas", ?, ?, UNIX_TIMESTAMP())');
$entry = "Updated Sortie (Database ID ".$id.")\n".
"\n".
"Mission: ".$team->mission."\n".
"Sortie: ".$team->sortie."\n".
"Tasking: ".$team->name."\n".
"Ground Team: ".($team->gt !== null ? "<a href='/audit.php?type=ground&id=".
                 $team->gt_id."'>".$team->gt->mission." / ".$team->gt->sortie : "Not Assigned")."</a>\n".
"MP: ".$team->mp."\n".
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
