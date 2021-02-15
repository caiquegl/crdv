function buscar(event){
    var input = document.getElementsByClassName("txtBusca")[0];
    var query = input.value;
    if(event.keyCode === 13){
        window.location.href = `buscar.php?query=${query}`;
    }
}