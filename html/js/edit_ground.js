function editGroundTeam(id){
    const id_field = document.getElementById("gid");
    const title = document.getElementById("groundModalLabel");
    const name = document.getElementById("gName");
    const cov = document.getElementById("gCOV");
    const driver = document.getElementById("gDriver");
    const leader = document.getElementById("gLeader");
    const passengers = document.getElementById("gPassengers");
    const status = document.getElementById("gStatus");
    const location = document.getElementById("gLocation");

    const index_map = {'Initiating': 0, 'Tasked': 1, 'Briefing': 2, 'In Progress': 3, 'RTB': 4, 'Debriefing': 5, 'Completed': 6, 'Cancelled': 7};

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        object = JSON.parse(this.responseText);
        title.innerHTML = "Mission " + object.mission + " Ground Sortie " + object.sortie
        id_field.value = object.id;
        name.value = object.name;
        cov.value = object.cov;
        driver.value = object.driver;
        leader.value = object.leader;
        passengers.value = object.passengers;
        status.getElementsByTagName("option")[index_map[object.status]].selected = "selected";
        location.value = object.location;
    }
    xhttp.onerror = function(error) {
        console.error(error);
    }
    xhttp.ontimeout = function(){
        console.error("Timeout ground edit")
        editGroundTeam(id);
    }
    xhttp.timeout = 1000;
    xhttp.open("GET", "/api/get_ground_team_json.php?id=" + id, true);
    xhttp.send();
    const modal = new bootstrap.Modal(document.getElementById("groundModal"), {keyboard: false});
    modal.show();
}

function auditGround(){
    const id_field = document.getElementById("gid");
    window.location = "/audit.php?type=ground&id=" + id_field.value;
}
