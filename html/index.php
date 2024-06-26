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
            <!-- GROUND -->
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
                                <a class="link" onclick="javascript:auditGround()">Audit Trail</a>
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="gName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="gName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gCOV">COV:</lable></td>
                                        <td style="border:0px;"><input id="gCOV" name="cov" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gDriver">Driver:</lable></td>
                                        <td style="border:0px;"><input id="gDriver" name="driver" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gLeader">GTL:</lable></td>
                                        <td style="border:0px;"><input id="gLeader" name="leader" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gPassengers">Passengers:</lable></td>
                                        <td style="border:0px;"><input type="number" min="0" id="gPassengers" name="passengers" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gStatus">Status</label></td>
                                        <td style="border:0px;">
                                            <select id="gStatus" name="status">
                                                <option value="Initiating">Initiating</option>
                                                <option value="Tasked">Tasked</option>
                                                <option value="Briefing">Briefing</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="RTB">RTB</option>
                                                <option value="Debriefing">Debriefing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="gLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="gLocation" name="location" required/></td>
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
                                        <td style="border:0px;"><input id="ngMission" name="mission" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngSortie">Sortie #:</lable></td>
                                        <td style="border:0px;"><input type="number" min="1" id="ngSortie" name="sortie" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="ngName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="ngLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="ngLocation" name="location" required/></td>
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

            <br />
            <hr />
            <br />

            <!-- AIR -->

            <div class="row">
                <div class="col-md">
                    <strong style="vertical-align:middle;">Air Sorties</strong>
                </div>
                <div class="col-md" style="text-align:right;">
                    <button style="margin-bottom:10px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAirModal">
                        New Air Sortie
                    </button>
                </div>
            </div>
            <div id="air_teams"></div>
            <!-- Edit Air Modal -->
            <div class="modal fade" id="airModal" tabindex="-1" aria-labelledby="airModalLabel" aria-hidden="true">
                <form method="POST" action="api/update_air_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="airModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input name="id" id="aid" hidden />
                                <a class="link" onclick="javascript:auditAir()">Audit Trail</a>
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="aName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="aName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aCallsign">Callsign:</lable></td>
                                        <td style="border:0px;"><input id="aCallsign" name="callsign" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aMP">MP:</lable></td>
                                        <td style="border:0px;"><input id="aMP" name="mp" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aMO">MO:</lable></td>
                                        <td style="border:0px;"><input id="aMO" name="mo" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aMS_AP">MS/AP:</lable></td>
                                        <td style="border:0px;"><input id="aMS_AP" name="ms_ap" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aStatus">Status</label></td>
                                        <td style="border:0px;">
                                            <select id="aStatus" name="status">
                                                <option value="Initiating">Initiating</option>
                                                <option value="Tasked">Tasked</option>
                                                <option value="Briefing">Briefing</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="RTB">RTB</option>
                                                <option value="Debriefing">Debriefing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="aLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="aLocation" name="location" required/></td>
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
            <!-- New Air Modal -->
            <div class="modal fade" id="newAirModal" tabindex="-1" aria-labelledby="airModalLabel" aria-hidden="true">
                <form method="POST" action="api/new_air_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newAirModalLabel">New Air Sortie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="naMission">Mission #:</lable></td>
                                        <td style="border:0px;"><input id="naMission" name="mission" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naSortie">Sortie #:</lable></td>
                                        <td style="border:0px;"><input type="number" min="1" id="naSortie" name="sortie" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="naName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="naLocation" name="location" required/></td>
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

            <br />
            <hr />
            <br />

            <!-- sUAS -->

            <div class="row">
                <div class="col-md">
                    <strong style="vertical-align:middle;">sUAS Sorties</strong>
                </div>
                <div class="col-md" style="text-align:right;">
                    <button style="margin-bottom:10px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSUASModal">
                        New sUAS Sortie
                    </button>
                </div>
            </div>
            <div id="suas_teams"></div>
            <!-- Edit sUAS Modal -->
            <div class="modal fade" id="suasModal" tabindex="-1" aria-labelledby="suasModalLabel" aria-hidden="true">
                <form method="POST" action="api/update_suas_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="suasModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input name="id" id="sid" hidden />
                                <a class="link" onclick="javascript:auditSUAS()">Audit Trail</a>
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="sName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="sName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="sGroundTeam">Ground Team:</lable></td>
                                        <td style="border:0px;"><select id="sGroundTeam" name="gt" required></select></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="sMP">MP:</lable></td>
                                        <td style="border:0px;"><input id="sMP" name="mp" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="sStatus">Status</label></td>
                                        <td style="border:0px;">
                                            <select id="sStatus" name="status">
                                                <option value="Initiating">Initiating</option>
                                                <option value="Tasked">Tasked</option>
                                                <option value="Briefing">Briefing</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="RTB">RTB</option>
                                                <option value="Debriefing">Debriefing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="sLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="sLocation" name="location" required/></td>
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
            <!-- New sUAS Modal -->
            <div class="modal fade" id="newSUASModal" tabindex="-1" aria-labelledby="suasModalLabel" aria-hidden="true">
                <form method="POST" action="api/new_suas_team.php">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newSUASModalLabel">New sUAS Sortie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table style="border:0px;">
                                    <tr>
                                        <td style="border:0px;"><label for="naMission">Mission #:</lable></td>
                                        <td style="border:0px;"><input id="naMission" name="mission" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naSortie">Sortie #:</lable></td>
                                        <td style="border:0px;"><input type="number" min="1" id="naSortie" name="sortie" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naName">Tasking:</label></td>
                                        <td style="border:0px;"><input id="naName" name="name" autocomplete="off" required/></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><label for="naLocation">Location:</label></td>
                                        <td style="border:0px;"><input id="naLocation" name="location" required/></td>
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

            <br />
            <hr />
            <br />

        <?php require("copyright.php"); ?>

        </div>
        <?php
            require("api/alert.php");
        ?>
        <script>
            const time = document.getElementById("time");
            const gt = document.getElementById("ground_teams");
            const ga = document.getElementById("groundAlert");
            const at = document.getElementById("air_teams");
            const aa = document.getElementById("airAlert");
            const st = document.getElementById("suas_teams");
            const sa = document.getElementById("suasAlert");
            update("/api/time.php", time);
            update("/api/ground_teams.php", gt, ga);
            update("/api/air_teams.php", at, aa);
            update("/api/suas_teams.php", st, sa);
            setInterval(update, 1000, "/api/time.php", time);
            setInterval(update, 1000, "/api/ground_teams.php", gt, ga);
            setInterval(update, 1000, "/api/air_teams.php", at, aa);
            setInterval(update, 1000, "/api/suas_teams.php", st, sa);
            setInterval(play_alert, 2000);
        </script>
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if(urlParams.has("type") && urlParams.has("id")){
                if(urlParams.get("type") == "ground"){
                    editGroundTeam(urlParams.get("id"));
                }else if(urlParams.get("type") == "air"){
                    editAirTeam(urlParams.get("id"));
                }else if(urlParams.get("type") == "suas"){
                    editSUASTeam(urlParams.get("id"));
                }
            }
        </script>
    </body>
</html>
