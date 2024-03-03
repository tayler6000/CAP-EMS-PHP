function update(endpoint, container_id){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById(container_id).innerHTML = this.responseText;
    }
    xhttp.open("GET", endpoint, true);
    xhttp.send();
}
