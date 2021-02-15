var response;

function callback(res){
    response = res;
}
let itemsS = "[{\"description\": \"Controle\",\"quantity\": \"1\",\"item_id\": \"1\",\"price_cents\": \"6808\"}]";

$btnJoin = document.getElementById("btn_entrar").addEventListener("click", () => {
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    var email = $("input#campo_email")[0].value;
    var password = $("input#campo_password")[0].value;
    
    $.ajax({
        "url" : "../../Controller/User.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "loginuser",
            "email" : email,
            "password": password
        },
        "success": (res) => {
            document.getElementById("loading").remove()
            callback(res);
            if(res.sucesso){
                window.localStorage.user = res;
                window.location.href = res.goto;
            } else {
                alert(`${res.error}`);
            }
        }
    });
}); 