<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_POST["mission"]) or empty($_POST["mission"]) or
   !isset($_POST["name"]) or empty($_POST["name"]) or
   !isset($_POST["sortie"]) or empty($_POST["sortie"])){
    http_response_code(404);
    die();
}
$mission = $_POST["mission"];
$name = $_POST["name"];
$sortie = (int)$_POST["sortie"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("SELECT * FROM `deployed_ground` WHERE `mission`=? AND `sortie`=?");
$stmt->bind_param("si", $mission, $sortie);
$stmt->execute();
$result = $stmt->get_result();
if($result === False){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}
if($result->num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    http_response_code(409);
    header("Location:/?type=ground&id=".$row["id"]);
    die(json_encode(array("error"=>"Sortie already exists"));
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO `deployed_ground` (`mission`, `sortie`, `name`) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $mission, $sortie, $name);
$stmt->execute();
$result = $stmt->get_result();
if($result === False){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM `deployed_ground` WHERE `mission`=? AND `sortie`=?");
$stmt->bind_param("si", $mission, $sortie);
$stmt->execute();
$result = $stmt->get_result();
if($result === False){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}
if($result->num_rows == 0){
    http_response_code(500);
    header("Location:/");
    die(json_encode(array("error"=>"Unable to create Sortie"));
}
$row = mysqli_fetch_assoc($result);
header("Location:/?type=ground&id=".$row["id"]);
?>
