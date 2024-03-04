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
    </head>
    <body>
        <?php require("nav.php"); ?>
        <div class="container">
            <p id="time"></p>
            <div class="row">
                <div class="col-md">
                    <strong style="vertical-align:middle;">Ground Sorties</strong>
                </div>
                <div class="col-md" style="text-align:right;">
                    <button style="margin-bottom:10px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newGroundModal">
                        New Ground Sortie
                    </button>
                </div>
            </div>
            <div id="ground_teams"></div>
            <!-- Edit Ground Modal -->
            <div class="modal fade" id="groundModal" tabindex="-1" aria-labelledby="groundModalLabel" aria-hidden="true">
                <form method="POST" action="api/update_ground_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="groundModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input name="id" id="gid" hidden />
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="gName">Name:</label></td>
                                        <td style="border:0px;"><input id="gName" name="name" autocomplete="off"/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gCOV">COV:</lable></td>
                                        <td style="border:0px;"><input id="gCOV" name="cov" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gDriver">Driver:</lable></td>
                                        <td style="border:0px;"><input id="gDriver" name="driver" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gLeader">GTL:</lable></td>
                                        <td style="border:0px;"><input id="gLeader" name="leader" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gPassengers">Passengers:</lable></td>
                                        <td style="border:0px;"><input type="number" min="4" id="gPassengers" name="passengers" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gStatus">Status</label></td>
                                        <td style="border:0px;">
                                            <select id="gStatus" name="status">
                                                <option value="Initiating">Initiating</option>
                                                <option value="Tasked">Tasked</option>
                                                <option value="Briefing">Briefing</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="gLocation" name="location" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- New Ground Modal -->
            <div class="modal fade" id="newGroundModal" tabindex="-1" aria-labelledby="groundModalLabel" aria-hidden="true">
                <form method="POST" action="api/new_ground_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newGroundModalLabel">New Ground Sortie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="ngMission">Mission #:</lable></td>
                                        <td style="border:0px;"><input id="ngMission" name="mission" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngSortie">Sortie #:</lable></td>
                                        <td style="border:0px;"><input type="number" min="4" id="ngSortie" name="sortie" /></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngName">Name:</label></td>
                                        <td style="border:0px;"><input id="ngName" name="name" autocomplete="off"/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="ngLocation" name="location" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            update("/api/time.php", document.getElementById("time"));
            update("/api/ground_teams.php", document.getElementById("ground_teams"));
            setInterval(update, 1000, "/api/time.php", document.getElementById("time"));
            setInterval(update, 1500, "/api/ground_teams.php", document.getElementById("ground_teams"));
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
