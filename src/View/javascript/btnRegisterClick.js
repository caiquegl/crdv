document.getElementById("cadastrar").addEventListener("click", (e) => {
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    e.preventDefault();
    let pass = $("#password")[0].value;
    let confirmPass = $("#passwordConfirm")[0].value;
    console.log(pass)
    if(pass == confirmPass){
        var pType = personType;
        if(pType === "pf") {
            var registerAction = "registerfisicperson";
        } else if (pType === "pj") {
            var registerAction = "registerjuridicperson";
        } else {
            var registerAction = "actionUndefined";
        }
        let data = {
            action: registerAction,
            email: $("#email")[0].value,
            password: $("#password")[0].value,
            name: $("#name")[0].value,
            surname: $("#surname")[0].value,
            cpf: $("#cpf")[0].value,
            address: `{'cep':'${$("#cep")[0].value}','rua':'${$("#rua")[0].value}','bairro':'${$("#bairro")[0].value}','cidade':'${$("#cidade")[0].value}','uf':'${$("#UF")[0].value}','numero':'${$("#numero")[0].value}'}`,
            telephone: $("#tel")[0].value,
            residentialPhone: $("#residencial")[0].value,
        }
        $.ajax({
            "url":"../../Controller/User.php",
            "method":"POST",
            "dataType" : "json",
            "data" : data,
            "success": (res) => {
                document.getElementById("loading").remove()

                if(res.sucesso != undefined){
                    window.alert(`${res.sucesso}`);
                    window.location.href = "login.php";
                } else {
                    window.alert(`${res.error}`);
                }
            }
        });
    }else{
        window.alert("Sua senha esta diferente");
    }
    
});