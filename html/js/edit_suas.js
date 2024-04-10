function editSUASTeam(id){
    const id_field = document.getElementById("sid");
    const title = document.getElementById("suasModalLabel");
    const name = document.getElementById("sName");
    const gt = document.getElementById("sGroundTeam");
    const mp = document.getElementById("sMP");
    const status = document.getElementById("sStatus");
    const location = document.getElementById("sLocation");

    const index_map = {'Initiating': 0, 'Tasked': 1, 'Briefing': 2, 'In Progress': 3, 'RTB': 4, 'Debriefing': 5, 'Completed': 6, 'Cancelled': 7};

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        object = JSON.parse(this.responseText);
        title.innerHTML = "Mission " + object.mission + " sUAS Sortie " + object.sortie
        id_field.value = object.id;
        name.value = object.name;
        mp.value = object.mp;
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
    xhttp.open("GET", "/api/get_suas_team_json.php?id=" + id, true);
    xhttp.send();
    const modal = new bootstrap.Modal(document.getElementById("airModal"), {keyboard: false});
    modal.show();
}

function auditAir(){
    const id_field = document.getElementById("aid");
    window.location = "/audit.php?type=air&id=" + id_field.value;
}
