function update(endpoint, container){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        container.innerHTML = this.responseText;
    }
    xhttp.open("GET", endpoint, true);
    xhttp.send();
}
