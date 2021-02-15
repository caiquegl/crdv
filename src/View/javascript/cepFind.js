$(document).ready(() => {
    $("#tel").mask("(00) 0 0000-0000");
    $("#cpf").mask("000.000.000-00");
    $("#cep").mask("00000-000");
    $("#UF").mask("SS");
    $("#residencial").mask("(00) 0000-0000");
});

$("#cep")[0].onfocusout = () => {
    if($("#cep")[0].value.length == 9){
        var cep = $("#cep")[0].value.replace("-","");
        var url = `https://viacep.com.br/ws/${cep}/json/`
        $.ajax({
            "url":url,
            "method":"GET",
            "dataType" : "json",
            "success" : (res) => {
               document.getElementById("rua").value = res.logradouro;
               document.getElementById("bairro").value = res.bairro;
               document.getElementById("cidade").value = res.localidade;
               document.getElementById("UF").value = res.uf;
            }
        });
    }

}
