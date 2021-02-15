let list;

document.getElementById("cadastrar").addEventListener("click", (e) => {
    ;
    e.preventDefault();

    if ($("#fileUpload")[0].files[0] == undefined || $("#desc")[0].value == undefined || $("#price")[0].value == undefined || $("#nome")[0].value == undefined)  {
        window.alert("Por favor preencha todos os campos!!!")
    }else{
        let files = $("#fileUpload")[0].files[0]
        var formData = new FormData();
        formData.append('sendFormat', $("#sendFormat")[0].value);
        formData.append('productImage', files);
        formData.append('action', 'registerproduct');
        formData.append('name', $("#nome")[0].value);
        formData.append('desc', $("#desc")[0].value);
        formData.append('volumnPrice', $("#volumnPrice")[0].value);
        formData.append('price', $("#price")[0].value);
        formData.append('amount', $("#amount")[0].value);
        formData.append('distributionCenter', $("#distribuidora")[0].value);
        formData.append('lastStock', $("#lastStock")[0].value);
        formData.append('model', $("#model")[0].value);
        formData.append('productsInStock', $("#productsInStock")[0].value);
        formData.append('sector', $("#sector")[0].value);
        formData.append('diameter', $("#diameter")[0].value);
        formData.append('heigth', $("#heigth")[0].value);
        formData.append('weight', $("#weight")[0].value);
        formData.append('width', $("#width")[0].value);
        formData.append('length', $("#length")[0].value);
        formData.append('fabricator', $("#fabricator")[0].value);
        formData.append('specifications', $("#specifications")[0].value);
        formData.append('sku', `sku-${$("#sku")[0].value}`);
        
        $.ajax({
            url: "../../../../Controller/Product.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',

            success: function(res) {
                document.getElementById("loading").remove()

                alert("Cadastro realizado com sucesso!");
                
            }
        });
    }
})

function abreModal(a){
    console.log(a);
    list = a;
    $('#myModal').modal('show');
    $("#nomeEdit")[0].value = a.name;
    $("#sendFormatEdit")[0].value = a.sendFormat;
    $("#volumnPriceEdit")[0].value = a.volumnPrice;
    $("#amountEdit")[0].value = a.amount;
    $("#distribuidoraEdit")[0].value = a.cd;
    $("#descEdit")[0].value = a.desc;
    $("#lastStockEdit")[0].value = a.lastStock;
    $("#modelEdit")[0].value = a.model;
    $("#priceEdit")[0].value = a.price;
    $("#productsInStockEdit")[0].value = a.productsInStock;
    $("#sectorEdit")[0].value = a.sector;
    $("#diameterEdit")[0].value = a.diameter;
    $("#heigthEdit")[0].value = a.heigth;
    $("#weightEdit")[0].value = a.weight;
    $("#widthEdit")[0].value = a.width;
    $("#lengthEdit")[0].value = a.length;
    $("#fabricatorEdit")[0].value = a.fabricator;
    $("#specificationsEdit")[0].value = a.specifications;
    $("#skuEdit")[0].value = a.sku;
}
function fechaModal(){
    $('#myModal').modal('hide');
    $('#modalVisualizar').modal('hide');
}

function visualizar(a){
    list = a;
    console.log(list);
    $('#modalVisualizar').modal('show');
    $("#nomeView")[0].value = a.name;
    $("#amountView")[0].value = a.amount;
    $("#distribuidoraView")[0].value = a.cd;
    $("#descView")[0].value = a.desc;
    $("#lastStockView")[0].value = a.lastStock;
    $("#modelView")[0].value = a.model;
    $("#priceView")[0].value = a.price;
    $("#productsInStockView")[0].value = a.productsInStock;
    $("#sectorView")[0].value = a.sector;
    $("#diameterView")[0].value = a.diameter;
    $("#heigthView")[0].value = a.heigth;
    $("#weightView")[0].value = a.weight;
    $("#widthView")[0].value = a.width;
    $("#lengthView")[0].value = a.length;
    $("#fabricatorView")[0].value = a.fabricator;
    $("#specificationsView")[0].value = a.specifications;
    $("#skuView")[0].value = a.sku;
    $('#imgView')[0].innerHTML = `<img src="../../../imagens/${a.productImage}" style="max-width: 200px;" />`
}

function deleteProduto(e){
    
    let value = window.confirm(`Você realmente quer excluir o ${e.name}?`);
    if(value == true){
        document.getElementById("loading").innerHTML = `
        <div class="loader">
            <h1>Carregando...</h1>
        </div>
    `;
        var formData = new FormData();
        formData.append('id', e.id);
        formData.append('action',  "deleteproduct");

        $.ajax({
            url: "../../../../Controller/Product.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',
            success: function(res) {
                document.getElementById("loading").remove()

                if(res.success == "O produto foi removido."){
                    alert("Produto removido com sucesso!!")
                    window.location.reload();
                }
            }
        });
    }
}

        let editImg;

function atualizarProduto(){
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
        let files = $("#editUpload")[0].files[0]
        var formData = new FormData()
        formData.append('action', 'updateproduct');
        formData.append('id', list.id)
        formData.append('sendFormat', $("#sendFormatEdit")[0].value);
        formData.append('productImage', files);
        formData.append('name', $("#nomeEdit")[0].value);
        formData.append('desc', $("#descEdit")[0].value);
        formData.append('volumnPrice', $("#volumnPriceEdit")[0].value);
        formData.append('price', $("#priceEdit")[0].value);
        formData.append('amount', $("#amountEdit")[0].value);
        formData.append('distributionCenter', $("#distribuidoraEdit")[0].value);
        formData.append('lastStock', $("#lastStockEdit")[0].value);
        formData.append('model', $("#modelEdit")[0].value);
        formData.append('productsInStock', $("#productsInStockEdit")[0].value);
        formData.append('sector', $("#sectorEdit")[0].value);
        formData.append('diameter', $("#diameterEdit")[0].value);
        formData.append('heigth', $("#heigthEdit")[0].value);
        formData.append('weight', $("#weightEdit")[0].value);
        formData.append('width', $("#widthEdit")[0].value);
        formData.append('length', $("#lengthEdit")[0].value);
        formData.append('fabricator', $("#fabricatorEdit")[0].value);
        formData.append('specifications', $("#specificationsEdit")[0].value);
        formData.append('sku', $("#skuEdit")[0].value);
        formData.append('imgName', list.productImage);

        $.ajax({
            url: "../../../../Controller/Product.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType : "json",
            data: formData,
            type: 'post',

            success: function(res) {
                document.getElementById("loading").remove()
                if(res.success == "Atualização realizada com sucesso."){
                    alert("Produto atualizado com sucesso!!")
                    window.location.reload();
                    $('#myModal').modal('hide');
                }            
            }
        });
    
}


