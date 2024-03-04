<?php
if(!isset($_POST["id"]) or empty($_POST["id"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["cov"]) or empty($_POST["cov"]) or
   !isset($_POST["driver"]) or empty($_POST["driver"]) or
   !isset($_POST["leader"]) or empty($_POST["leader"]) or
   !isset($_POST["status"]) or empty($_POST["status"]) or
   !isset($_POST["location"]) or empty($_POST["location"])){
    http_response_code(404);
    die();
}
$id = $_POST["id"];
$name = $_POST["name"];
$cov = $_POST["cov"];
$driver = $_POST["driver"];
$leader = $_POST["leader"];
$status = $_POST["status"];
$location = $_POST["location"];

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
