let valueTotal = 0;
let valurFreteFim;
function removeFromCart(id){
    var cart = JSON.parse(window.localStorage.cart);
    var index = cart.indexOf(cart[id]);
    if(index > -1) {
        cart.splice(index, 1);
    }
    window.localStorage.cart = JSON.stringify(cart);
    window.location.reload();
}
function back(){
    window.location.href = "index.php";
}
function nextStep(){
    var cart = JSON.parse(window.localStorage.cart);
    var length = cart.length;
    if(length > 0){
        if(!valurFreteFim){
            window.alert("Por favor digite o cep da entrega para calcular o frete.")
        }else{
            window.location.href = "pagamento.php";
        }
    }else{
        window.alert("Você não tem nenhum item para comprar.")
    }
}
var cart = window.localStorage.cart;
var divItens = document.getElementsByClassName("itens");
if(cart === undefined || cart === "undefined") {
    divItens[0].innerHTML = "Nenhum produto no carrinho.";
} else {
    var cart = JSON.parse(window.localStorage.cart);
    var length = cart.length;
    for(var i = 0; i < length; i++){
        valueTotal += parseInt(cart[i].price)
        divItens[0].innerHTML += `<div class="imagem-carrinho"><img src="../imagens/${cart[i].image}" alt="img-produto" class="img-produto"></div>
        <div class="descricao-carrinho">
            <div class="titulo">${cart[i].name}</div>
            <div class="descricao-produto">Valor: R$${cart[i].price}</div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <label for="disabledSelect" class="form-label">Qtd.</label>
                    <select class="form-select form-select-lg mb-3" id="item-${cart[i].id}" aria-label=".form-select-lg example" style="width: 90px;" value=${cart[i].qtd} onblur="addProduct(${cart[i].id})">
                        <option value=${cart[i].qtd} selected>${cart[i].qtd}</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <div class="col-md-3" style="display: flex; align-items: center; justify-content: center; margin-top:1.5%;">
                    <input type="submit" name="excluir" onclick="removeFromCart(${i})" class="btn-card" value="Excluir">
                </div>
            </div>
        </div>
        <hr>`;
    }
}
let price = 0;
cart.forEach(element => {
    let totalby = parseFloat(element.price) * parseFloat(element.qtd);
    console.log(totalby, parseFloat(element.price), parseFloat(element.qtd))
    price += totalby;
});
var valueCart = document.getElementsByClassName("valueTotal");

valueCart[0].innerHTML = `
<div class="row" style="margin-bottom: 30px;">
    <div class="col-md-8" id="priceTotal">
        <h3>Valor total: R$ ${price.toFixed(2)}</h3>
    </div>
    <div class="col-md-4">
        <label for="exampleInputEmail1" class="form-label" style="font-size:20px">Digite seu CEP para calcular o frete</label>
        <input type="text" class="form-control" id="cepFrete" aria-describedby="emailHelp" onblur="frete()" style="font-size: 17px; padding-left: 10px;">
        <div id="valorFrete">
        </div>
    </div>
</div>
`

function addProduct(e){
    var produtos = window.localStorage.cart;
    var carrinho = JSON.parse(window.localStorage.cart);
    let result = carrinho.find( x => x.id == e );
    if(result){
        for (let i = 0; i < carrinho.length; i++) {
            if (carrinho[i].id == e) {
                carrinho[i].qtd = $(`#item-${e}`)[0].value;                  
            }
        }
    }

    window.localStorage.cart = JSON.stringify(carrinho);
    alert("Item adicionado com sucesso");
    window.location.reload();  
}



let res;

async function frete(){
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    let dataCalCep = {
        action: 'cepbysku',
        cepDest: $("#cepFrete")[0].value,
        sku: cart[0].sku,
    }

    $.ajax({
        url: '../../Controller/Product.php',
        data: dataCalCep,
        type: 'post',
        success:  function(data){
            document.getElementById("loading").remove()
            console.log(data.Servicos)
            var valueFrete = document.getElementById("valorFrete");
            var pricePedido = document.getElementById("priceTotal");
            let frete = parseFloat(data.Servicos.cServico.Valor);
            let prazo = data.Servicos.cServico.PrazoEntrega;
            valueFrete.innerHTML = `
            <p style="font-size: 15px;"><b>Valor do frete:</b> R$ ${frete}</p>
            <p style="font-size: 15px;"><b>Prazo de entrega:</b> ${prazo}</p>
            `
            console.log(price)
            valurFreteFim = frete;
            price += frete;
            pricePedido.innerHTML = `
                    <h3>Valor total: R$ ${price.toFixed(2)}</h3>
                `

            window.sessionStorage.valueFrete = frete;
        },
    });

}

function xmlToJson(xml) {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
		obj["@attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};
