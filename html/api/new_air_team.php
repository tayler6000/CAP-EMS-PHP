<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_POST["mission"]) or empty($_POST["mission"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["sortie"]) or empty($_POST["sortie"]) or
   !isset($_POST["location"]) or empty($_POST["location"])){
    http_response_code(400);
    header("Location:/");
    die();
}
$mission = strtoupper($_POST["mission"]);
$name = $_POST["name"];
$sortie = (int)$_POST["sortie"];
$location = $_POST["location"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("SELECT * FROM `deployed_air` WHERE `mission`=? AND `sortie`=?");
$stmt->bind_param("si", $mission, $sortie);
$stmt->execute();
$result = $stmt->get_result();
if($result === False){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error, "code"=>1)));
}
if($result->num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    http_response_code(409);
    header("Location:/?type=air&id=".$row["id"]);
    die(json_encode(array("error"=>"Sortie already exists", "code"=>2)));
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO `deployed_air` ".
"(`mission`, `sortie`, `name`, `status`, `location`, `checkin`) VALUES ".
'(?, ?, ?, "Initiating", ?, UNIX_TIMESTAMP())');
$stmt->bind_param("siss", $mission, $sortie, $name, $location);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error, "code"=>3)));
}
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM `deployed_air` WHERE `mission`=? AND `sortie`=?");
$stmt->bind_param("si", $mission, $sortie);
$stmt->execute();
$result = $stmt->get_result();
if($result === False){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error, "code"=>4)));
}
if($result->num_rows == 0){
    http_response_code(500);
    header("Location:/");
    die(json_encode(array("error"=>"Unable to create Sortie", "code"=>5)));
}
$row = mysqli_fetch_assoc($result);

// Audit Log
$stmt = $conn->prepare("INSERT INTO `audit` (`sortie_type`, `sortie_id`, `entry`, `timestamp`) VALUES".
'("air", ?, ?, UNIX_TIMESTAMP())');
$entry = "Created Sortie (Database ID ".$row["id"].")\n".
"\n".
"Mission: ".$mission."\n".
"Sortie: ".$sortie."\n".
"Tasking: ".$name."\n".
"Location: ".$location;
$stmt->bind_param("is", $row["id"], $entry);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error, "code"=>5)));
}
$stmt->close();
$conn->close();

header("Location:/?type=air&id=".$row["id"]);
?>
