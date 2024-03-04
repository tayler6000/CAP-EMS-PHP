<?php
if(!isset($_GET["id"]) or empty($_GET["id"])){
    http_response_code(404);
    die();
}
require_once("../objects/ground_teams.php");
$id = (int)$_GET["id"];
try{
    $team = new GroundTeam($id);
    echo($team->jsonify());
}catch(Exception $e){
    http_response_code(404);
    die();
}
?>
