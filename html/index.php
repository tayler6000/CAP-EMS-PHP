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
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <h6>Ground Teams</h6>
            <table>
                <tr>
                    <th>Sortie #</th>
                    <th>Name</th>
                    <th>COV</th>
                    <th>Driver</th>
                    <th>GTL</th>
                    <th>Passengers</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Checkin</th>
                    <th>Action</th>
                </tr>
            </table>
        </div>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
