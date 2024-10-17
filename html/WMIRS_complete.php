<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    date_default_timezone_set(empty(getenv("TIMEZONE")) ? "Zulu" : getenv("TIMEZONE"));
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charSet="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>CAP EMS - WMIRS Entry</title>
        <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/style.css" rel="stylesheet">
        <script src="/js/update.js"></script>
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <p id="time"></p>
            <p>Audit Entry marked as logged in WMIRS!</p>
            <button class='btn btn-success' onclick='javascript:document.location="/WMIRS.php";'>Next</button>
        </div>
        <script>
            update("/api/time.php", document.getElementById("time"));
            setInterval(update, 1000, "/api/time.php", document.getElementById("time"));
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
