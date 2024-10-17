<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_GET["id"]) or empty($_GET["id"])){
    http_response_code(400);
    die();
}
$id = $_GET["id"];

$conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
$stmt = $conn->prepare("UPDATE `audit` SET `WMIRS`='true' WHERE `id`=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($conn->error){
    http_response_code(500);
    die(json_encode(array("error"=>$conn->error)));
}

// Audit Log
$stmt->close();
$conn->close();
header("Location:/WMIRS_complete.php");
?>
