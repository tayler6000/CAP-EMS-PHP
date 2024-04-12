<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charSet="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Civil Air Patrol Emergency Managent System</title>
        <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet">
        <script src="/js/update.js"></script>
        <script src="/js/edit_ground.js"></script>
        <script src="/js/edit_air.js"></script>
        <script src="/js/edit_suas.js"></script>
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <p id="time"></p>
            <h2>Search Sorties</h2>
            <form>
                <table style="border:0px;margin:initial;width:initial;">
                    <tr>
                        <td style="border-width:0px"><label for="type">Sortie Type:</label></td>
                        <td style="border-width:0px">
                            <select id="type" name="type">
                                <option value="any">Any</option>
                                <option value="ground">Ground</option>
                                <option value="air">Air</option>
                                <option value="suas">sUAS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-width:0px"><label for="mission">Mission Number:</label></td>
                        <td style="border-width:0px"><input id="mission" name="mission" type="text"></td>
                    </tr>
                    <tr>
                        <td style="border-width:0px"><label for="sortie">Sortie Number:</label></td>
                        <td style="border-width:0px"><input id="sortie" name="sortie" type="number" min="1"></td>
                    </tr>
                </table>
                <button class="btn btn-primary">Search</button><br><br>
                <?php if(!empty($_GET["type"])){ ?>
                <hr>
                <h4>Search Results:</h4>
                <?php
                    $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                    $type = $_GET["type"];
                    $mission = $_GET["mission"];
                    $sortie = (int)$_GET["sortie"];
                    $mission_search = "%".$mission."%";
                    $sortie_search = "%".$sortie."%";
                    if($type == "any"){
                        $stmt = $conn->prepare("SELECT `id`, `mission`, `sortie`, `name`, 'ground' as `type` FROM `deployed_ground` WHERE `mission` LIKE ? AND `sortie` LIKE ? UNION ".
                        "SELECT `id`, `mission`, `sortie`, `name`, 'air' as `type` FROM `deployed_air` WHERE `mission` LIKE ? AND `sortie` LIKE ? UNION ".
                        "SELECT `id`, `mission`, `sortie`, `name`, 'suas' as `type` FROM `deployed_suas` WHERE `mission` LIKE ? AND `sortie` LIKE ?");
                        $stmt->bind_param("ssssss", $mission_search, $sorite_search, $mission_search, $sorite_search, $mission_search, $sorite_search);
                    }elseif($type == "ground"){
                        $stmt = $conn->prepare("SELECT *, 'ground' as `type` FROM `deployed_ground` WHERE `mission` LIKE ? AND `sortie` LIKE ?");
                        $stmt->bind_param("ss", $mission_search, $sorite_search);
                    }elseif($type == "air"){
                        $stmt = $conn->prepare("SELECT *, 'air' as `type` FROM `deployed_air` WHERE `mission` LIKE ? AND `sortie` LIKE ?");
                        $stmt->bind_param("ss", $mission_search, $sorite_search);
                    }elseif($type == "suas"){
                        $stmt = $conn->prepare("SELECT *, 'suas' as `type` FROM `deployed_suas` WHERE `mission` LIKE ? AND `sortie` LIKE ?");
                        $stmt->bind_param("ss", $mission_search, $sorite_search);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result === False){
                        print($conn->error);
                    }
                    if($result->num_rows === 0){
                        print("No results.");
                    }
                    $beautify = array("air"=>"Air", "ground"=>"Ground", "suas"=>"sUAS");
                    while($row = mysqli_fetch_assoc($result)){
                        print("<a class='link' href='/audit.php?type=".$row["type"]."&id=".$row["id"]."'>Mission ".
                              $row["mission"]." / ".$beautify[$row["type"]]." Sortie ".$row["sortie"]."</a>: ".
                              $row["name"]."<br>"
                        );
                    }
                    $conn->close();
                ?>
                <?php } ?>
            </form>
        </div>
        <script>
            const time = document.getElementById("time");
            update("/api/time.php", time);
            setInterval(update, 1000, "/api/time.php", time);
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
