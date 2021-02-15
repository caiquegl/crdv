let idProduto;


document.getElementById("cadastrar").addEventListener("click", (e) => {
    e.preventDefault();

    console.log($("#uploadArquivos")[0].files[0])
    if ($("#uploadArquivos")[0].files[0] == undefined || $("#newDescricao")[0].value.length === 0) {
        window.alert("Porfavor preencha todos os campos!!!")
    }else{

        let files = $("#uploadArquivos")[0].files[0]
        var formData = new FormData()
        formData.append('file', files);
        formData.append('descricao', $("#newDescricao")[0].value);


        $.ajax({
            url: "../../Controller/User.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',

            success: function(res) {
                console.log(res);
            }
        });
    }
})

function abreModal(e){
    idProduto = e;
    $('#myModal').modal('show');
}
function fechaModal(e){
    console.log(e);
    $('#myModal').modal('hide');
}

function deleteBanner(e){
    let value = window.confirm("Você realmente quer excluir?");
    if(value == true){
        $('#myModal').modal('hide');
    }
}


document.getElementById("atualizar").addEventListener("click", (e) => {
    e.preventDefault();

    if ($("#editUpload")[0].files[0] == undefined || $("#editDescricao")[0].value.length === 0) {
        window.alert("Porfavor preencha todos os campos!!!")
    }else{

        let files = $("#editUpload")[0].files[0]
        var formData = new FormData()
        formData.append('file', files);
        formData.append('descricao', $("#editDescricao")[0].value);
        formData.append('id', idProduto);


        $.ajax({
            url: "../../Controller/User.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',

            success: function(res) {
                console.log(res);
            }
        });
        $('#myModal').modal('hide');
    }
})