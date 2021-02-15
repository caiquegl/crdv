let list;
function fechaModal(e){
    console.log(e);
    $('#modalVisualizar').modal('hide');
}

function deletePedido(e){
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    let value = window.confirm("Você realmente quer excluir?");
    if(value == true){
        var formData = new FormData()
        formData.append('oId', e);
        formData.append('action', 'delorder');

        $.ajax({
            url: "../../../../Controller/Order.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',
            success: function(res) {
                document.getElementById("loading").remove()
                alert("Pedido excluido com sucesso");
                window.location.reload();

            }
        });
    }
}

function listAll(){
    document.getElementById("loading").innerHTML = `
        <div class="loader">
            <h1>Carregando...</h1>
        </div>
    `;
    $.ajax({
        url: "../../../../Controller/Order.php",
        dataType : "json",
        data: {
            action: 'selectall'
        },
        type: 'post',
        success: function(res) {
            let data = [];
            document.getElementById("loading").remove()
            res.forEach(x => {
                let obj = {
                    address: JSON.parse(x.address.replaceAll("\\", "").replaceAll("'", '"')),
                    id: x.id,
                    payment: JSON.parse(x.payment.replaceAll("\\", "").replaceAll("'", '"')),
                    products: JSON.parse(x.products.replaceAll("\\", "").replaceAll("'", '"')),
                    receiver: JSON.parse(x.receiver.replaceAll("\\", "").replaceAll("'", '"')),
                }
                data.push(obj)
            });
            list = data;
            organizar();
        }
    });
}
listAll()


function organizar(){
    let dataForm = "";

    list.forEach(x => {
        let string = `
            <tr>
                <td style="text-align: center; width: 5%">${x.id}</td>
                <td style="text-align: center; width: 25%">${x.products[0].name}</td>
                <td style="text-align: center; width: 10%">1</td>
                <td style="text-align: center; width: 15%">R$ ${x.payment.total}</td>
                <td style="text-align: center; width: 35%">${x.receiver.name}</td>
                <td>
                    <div style="display: flex; justify-content: center;" >
                        <button style="border: none;" onclick="deletePedido(${x.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </button>
                        <button style='border: none;' onclick='visualizar(${x.id})'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        `
        dataForm += string
    });

    window.document.getElementById('table').innerHTML = dataForm;
}

function visualizar(x) {

    $('#modalVisualizar').modal('show');
    var formData = new FormData()
    formData.append('action', 'idorder');
    formData.append('oId', x);


    $.ajax({
        url: "../../../../Controller/Order.php",
        cache: false,
        contentType: false,
        processData: false,
        dataType : "json",
        data: formData,
        type: 'post',
        success: function(res) {

            let data = [];
            res.forEach(x => {
                let obj = {
                    address: jQuery.parseJSON(x.address.replaceAll("\\", "")),
                    id: x.id,
                    payment: jQuery.parseJSON(x.payment.replaceAll("\\", "")),
                    products: jQuery.parseJSON(x.products.replaceAll("\\", "")),
                    receiver: jQuery.parseJSON(x.receiver.replaceAll("\\", "")),
                }
                data.push(obj)
            });
            console.log(data)
            $("#compradorView")[0].value = data[0].receiver.name;
            $("#cpfView")[0].value = data[0].receiver.cpf;
            $("#emailView")[0].value = data[0].receiver.email;
            $("#residencialPhone")[0].value = data[0].receiver.residentialPhone;
            $("#phoneView")[0].value = data[0].receiver.telephone;
            $("#ruaView")[0].value = data[0].address.rua;
            $("#bairroView")[0].value = data[0].address.bairro;
            $("#cepView")[0].value = data[0].address.cep;
            $("#cidadeView")[0].value = data[0].address.cidade;
            $("#numeroView")[0].value = data[0].address.numero;

            let stringProduct = "";
            data[0].products.forEach(x => {
                let string = `
                <div class="form-group" style="margin-top: 20px;">
                    <label for="nome" class="form-label">Nome:</label>
                    <input disabled class="viewInput" value="${x.name}">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="nome" class="form-label">Quantidade:</label>
                    <input disabled class="viewInput" value="${x.amount}">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="nome" class="form-label">Valor do produto:</label>
                    <input disabled class="viewInput" value="${x.price}">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="nome" class="form-label">SKU do produto:</label>
                    <input disabled class="viewInput" value="${x.sku}">
                </div>
                <hr>
                `
                stringProduct += string;
            })
            window.document.getElementById('viewProdutos').innerHTML = stringProduct;

            $("#valorTotalView")[0].value = data[0].payment.total;
            $("#valorEnvioView")[0].value = data[0].payment.sendPrice;
            $("#formPaymentView")[0].value = data[0].payment.paymentForm;

            console.log(data);
        }
    });

}