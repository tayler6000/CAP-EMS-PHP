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
                <?php
                $conn = mysqli_connect("localhost", getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_USER"));
                $stmt = $conn->prepare("SELECT * FROM `deployed_ground`");
                $stmt->execute();
                $result = $stmt->get_result();
                if($result === False){
                    print($conn->error);
                }
                while $row = mysqli_fetch_assoc($result){
                    print("<tr>");
                    print("<th>".$row->sortie."</th>");
                    print("<td>Name</td>");
                    print("<td>COV</td>");
                    print("<td>Driver</td>");
                    print("<td>GTL</td>");
                    print("<td>Passengers</td>");
                    print("<td>Status</td>");
                    print("<td>Location</td>");
                    print("<td>Checkin</td>");
                    print("<td>Action</td>");
                    print("</tr>");
                }
                ?>
            </table>
        </div>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
