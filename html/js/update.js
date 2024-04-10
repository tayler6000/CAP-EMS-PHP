function update(endpoint, container, alert=null){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        container.innerHTML = this.responseText;
        if(alert != null){
            if(this.status == 202){
                alert.value = 1;
            }else{
                alert.value = 0;
            }
        }
    }
    xhttp.open("GET", endpoint, true);
    xhttp.send();
}

function play_alert(){
    const ground = document.getElementById("groundAlert");
    const air = document.getElementById("airAlert");
    const sUAS = document.getElementById("suasAlert");
    const alert = document.getElementById("alert");
    if(ground.value == 1 || air.value == 1 || sUAS.value == 1){
        alert.play();
    }
}
