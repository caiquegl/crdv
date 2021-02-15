let userEdit = {}
function abreModal(a, b, c, d,e ,f ,g){
    let dress = JSON.parse(f.replaceAll('\\', '').replaceAll("'", '"'))

    userEdit = {
        id: a,
        nome: b,
        sobrenome: c,
        email: d,
        phone: e,
        endereco: dress,
        cpf: g
    }
    $('#myModal').modal('show');
    console.log(dress)


    $("#nameAtualizar")[0].value = userEdit.nome
    $("#surnameAtualizar")[0].value = userEdit.sobrenome
    $("#emailAtualizar")[0].value = userEdit.email
    $("#telAtualizar")[0].value = userEdit.phone
    $("#cpfAtualizar")[0].value = userEdit.cpf
    $("#cepAtualizar")[0].value = dress.cep
    $("#ruaAtualizar")[0].value = dress.rua
    $("#numeroAtualizar")[0].value = dress.numero
    $("#bairroAtualizar")[0].value = dress.bairro
    $("#cidadeAtualizar")[0].value = dress.cidade
    $("#UFAtualizar")[0].value = dress.uf

  }

function atualizarCliente() {

    let dress = {
        cep: $("#cepAtualizar")[0].value,
        rua: $("#ruaAtualizar")[0].value,
        numero: $("#numeroAtualizar")[0].value,
        bairro: $("#bairroAtualizar")[0].value,
        cidade: $("#cidadeAtualizar")[0].value,
        uf: $("#UFAtualizar")[0].value,
    }
    var formData = new FormData();
    formData.append('email', $("#emailAtualizar")[0].value);
    formData.append('name', $("#nameAtualizar")[0].value);
    formData.append('surname', $("#surnameAtualizar")[0].value);
    formData.append('cpf', $("#cpfAtualizar")[0].value);
    formData.append('address', JSON.stringify(dress));
    formData.append('telephone', $("#telAtualizar")[0].value);
    formData.append('action', 'validateUpdateUser');
    
    $.ajax({
        url: "../../../../Controller/User.php",
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
function fechaModal(e){
    console.log(e);
    $('#myModal').modal('hide');
}

function deleteCliente(){
    let value = window.confirm("Você realmente quer excluir?");
    if(value == true){
        $('#myModal').modal('hide');
    }
}


$("#cepAtualizar")[0].onfocusout = () => {
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    console.log($("#cepAtualizar")[0])
    if($("#cepAtualizar")[0].value.length == 8){
        var cep = $("#cepAtualizar")[0].value.replace("-","");
        var url = `https://viacep.com.br/ws/${cep}/json/`
        $.ajax({
            "url":url,
            "method":"GET",
            "dataType" : "json",
            "success" : (res) => {
                document.getElementById("loading").remove()
               document.getElementById("ruaAtualizar").value = res.logradouro;
               document.getElementById("bairroAtualizar").value = res.bairro;
               document.getElementById("cidadeAtualizar").value = res.localidade;
               document.getElementById("UFAtualizar").value = res.uf;
            }
        });
    }

}

function listUser() {
    let string = "";
    document.getElementById("loading").innerHTML = `
        <div class="loader">
            <h1>Carregando...</h1>
        </div>
    `;

    $.ajax({
        url: "../../../../Controller/User.php",
        method:"post",
        data: {
            action: "listalluser"
        },
        success: (res) => {
            document.getElementById("loading").remove()

            res.forEach(x => {

                let table = `
                <tr>
                <td style="text-align: center; width: 5%">${x.id}</td>
                <td style="text-align: center;">${x.name}</td>
                <td style="text-align: center;">${x.surname}</td>
                <td style="text-align: center;">${x.cpf}</td>
                <td style="text-align: center;">${x.telephone}</td>
                <td>
                    <div style="display: flex; justify-content: center;" >
                        <button style="border: none;" onclick="abreModal(${x.id}, '${x.name}', '${x.surname}', '${x.email}', '${x.telephone}', '${x.address}', '${x.cpf}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                        </button>
                        <button style="border: none;" onclick="deleteCliente()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </button>
                    </div>
                </td>
                </tr>
                        `

                        string += table;
            });
            window.document.getElementById('tableUser').innerHTML = string;
        }
    });

}

listUser();