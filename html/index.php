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
            <h6>Ground Teams</h6>
            <div id="ground_teams"></div>
            <!-- Ground Modal -->
            <div class="modal fade" id="groundModal" tabindex="-1" aria-labelledby="groundModalLabel" aria-hidden="true">
                <form method="POST" action="api/update_ground_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="groundModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Name: <input id="gName" name="name" /></label><br/>
                                <label>COV: <input id="gCOV" name="cov" /></label><br/>
                                <label>Driver: <input id="gDriver" name="driver" /></label><br/>
                                <label>GTL: <input id="gLeader" name="leader" /></label><br/>
                                <label>Passengers: <input type="number" min="4" id="gPassengers" name="passengers" /></label><br/>
                                <label>
                                    Status: <select id="gStatus" name="status">
                                        <option value="Initiating">Initiating</option>
                                        <option value="Tasked">Tasked</option>
                                        <option value="Briefing">Briefing</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </label><br/>
                                <label>Location: <input id="gLocation" name="location" /></label><br/>
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
            setInterval(update, 1000, "/api/time.php", document.getElementById("time"));
            setInterval(update, 1500, "/api/ground_teams.php", document.getElementById("ground_teams"));
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
