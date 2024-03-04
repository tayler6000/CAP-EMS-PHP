<?php
if(!isset($_GET["id"]) or empty($_GET["id"]) or
   !isset($_GET["name"]) or empty($_GET["name"]) or
   !isset($_GET["cov"]) or empty($_GET["cov"]) or
   !isset($_GET["driver"]) or empty($_GET["driver"]) or
   !isset($_GET["leader"]) or empty($_GET["leader"]) or
   !isset($_GET["status"]) or empty($_GET["status"]) or
   !isset($_GET["location"]) or empty($_GET["location"])){
    http_response_code(404);
    die();
}
$id = $_GET["id"];
$name = $_GET["name"];
$cov = $_GET["cov"];
$driver = $_GET["driver"];
$leader = $_GET["leader"];
$status = $_GET["status"];
$location = $_GET["location"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("UPDATE `deployed_ground` SET `name`=?, `cov`=?, `driver`=?, ".
"`leader`=?, `passengers`=?, `status`=?, `location`=?, `checkin`=UNIX_TIMESTAMP() WHERE `id`=?");
$stmt->bind_param("ssssissi", $id);
$stmt->execute();
if($result === False){
    http_response_code(500);
    die($conn->error);
}
header("Location:/");
?>
