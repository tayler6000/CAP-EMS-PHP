function editSUASTeam(id){
    const id_field = document.getElementById("sid");
    const title = document.getElementById("suasModalLabel");
    const name = document.getElementById("sName");
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

        loadAvailableGroundTeams(id, object.gt_id, object.gt);
    }
    xhttp.onerror = function(error) {
        console.error(error);
        editSUASTeam(id)
    }
    xhttp.ontimeout = function(){
        console.error("Timeout sUAS edit")
        editSUASTeam(id);
    }
    xhttp.timeout = 1000;
    xhttp.open("GET", "/api/get_suas_team_json.php?id=" + id, true);
    xhttp.send();
}

function loadAvailableGroundTeams(id, gt_id, gt){
    const gt = document.getElementById("sGroundTeam");
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        object = JSON.parse(this.responseText);
        gt.innerHTML = "";  // Remove previous options
        let found = (gt_id === null ? True : False)
        // Create "Not Assigned" Option
        option = document.createElement("option");
        option.value = "null";
        option.innerText = "Not Assigned";
        if(found){
            option.selected = "selected"
        }
        gt.appendChild(option);
        // Create all active ground team options
        for(const key in object){
            option = document.createElement("option");
            option.value = key;
            option.innerText = object[key];
            if(key === gt_id){
                option.selected = "selected"
            }
            gt.appendChild(option);
        }
        // If we are already assigned a team that was not created, then add it
        if(!found){
            option = document.createElement("option");
            option.value = gt_id;
            option.innerText = gt;
            option.selected = "selected"
            gt.appendChild(option);
        }
    }
    xhttp.onerror = function(error) {
        console.error(error);
        editSUASTeam(id)
    }
    xhttp.ontimeout = function(){
        console.error("Timeout sUAS edit")
        editSUASTeam(id);
    }
    xhttp.timeout = 1000;
    xhttp.open("GET", "/api/get_suas_team_json.php?id=" + id, true);
    xhttp.send();
    const modal = new bootstrap.Modal(document.getElementById("suasModal"), {keyboard: false});
    modal.show();
}

function auditSUAS(){
    const id_field = document.getElementById("sid");
    window.location = "/audit.php?type=suas&id=" + id_field.value;
}
