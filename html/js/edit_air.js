function editAirTeam(id){
    const id_field = document.getElementById("aid");
    const title = document.getElementById("airModalLabel");
    const name = document.getElementById("aName");
    const callsign = document.getElementById("aCOV");
    const mp = document.getElementById("aMP");
    const mo = document.getElementById("aMO");
    const ms_ap = document.getElementById("aMS_AP");
    const status = document.getElementById("aStatus");
    const location = document.getElementById("aLocation");

    const index_map = {'Initiating': 0, 'Tasked': 1, 'Briefing': 2, 'In Progress': 3, 'RTB': 4, 'Debriefing': 5, 'Completed': 6, 'Cancelled': 7};

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        object = JSON.parse(this.responseText);
        title.innerHTML = "Mission " + object.mission + " Air Sortie " + object.sortie
        id_field.value = object.id;
        name.value = object.name;
        callsign.value = object.callsign;
        mp.value = object.mp;
        mo.value = object.mo;
        ms_ap.value = object.ms_ap;
        status.getElementsByTagName("option")[index_map[object.status]].selected = "selected";
        location.value = object.location;
    }
    xhttp.onerror = function(error) {
        console.error(error);
        editAirTeam(id)
    }
    xhttp.ontimeout = function(){
        editAirTeam(id);
    }
    xhttp.timeout = 1000;
    xhttp.open("GET", "/api/get_air_team_json.php?id=" + id, true);
    xhttp.send();
    const modal = new bootstrap.Modal(document.getElementById("airModal"), {keyboard: false});
    modal.show();
}

function auditAir(){
    const id_field = document.getElementById("aid");
    window.location = "/audit.php?type=air&id=" + id_field.value;
}
