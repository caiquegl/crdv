let active = 0;
var cart = JSON.parse(window.localStorage.cart);
var valueFrete = JSON.stringify(window.sessionStorage.valueFrete);
function dataPay(){
    let valueTotal = 0;
    let item
    cart.forEach(x => {
        let price = parseFloat(x.price) * x.qtd;
        valueTotal += price;
    });
    datas = {
        valueTotalPedio: valueTotal,
        items: cart
    }
    console.log(valueTotal);
}
dataPay();
console.log(datas);
let formPP = `
<div class="row">
    <div class="col-md-6" style="margin-bottom: 40px;">
        <h3 class="formH3">Endereço da entrega</h3>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Email:</label>
            <input type="email" name="email" placeholder="Digite seu email..." id="emailMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Nome:</label>
            <input type="text" name="nome" placeholder="Digite seu nome..." id="nomeMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CPF:</label>
            <input type="text" name="cpf" placeholder="Digite seu CPF..." id="cpfMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleFormControlInput1">DD:</label>
                    <input type="text" name="dd" placeholder="Digite seu DD..." id="DDMp" class="form-control">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Telefone:</label>
                    <input type="text" name="telefone" placeholder="Digite seu telefone..." id="telefoneMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-bottom: 40px;">
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CEP:</label>
            <input type="text" name="cep" placeholder="Digite o o seu CEP..." id="cepMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Sua Rua:</label>
            <input type="text" name="rua" placeholder="Digite a sua rua..." id="ruaMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu NÚmero:</label>
            <input type="text" name="numero" placeholder="Digite o número da sua casa..." id="numeroDeCasaMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">UF:</label>
                    <input type="text" name="dd" placeholder="Digite seu UF..." id="ufMp" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Cidade:</label>
                    <input type="text" name="telefone" placeholder="Digite sua cidade..." id="cidadeMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="paypal" id="paypal-button-container">
        </div>
    </div>
</div>

`

let totalCFrete = parseFloat(parseFloat(valueFrete.substr(1,4)) + datas.valueTotalPedio).toFixed(2);
let text = "";
let descriName = "";
let dataPP = []
function descri(){
    let obj = {};
    cart.forEach((x, i) => {

            obj = {
                name: x.name,
                description: "Obrigado por comprar na CRDV",
                quantity: x.qtd,
                unit_amount: {
                    currency_code: "BRL",
                    value: parseFloat(x.price)
                }
            }
            dataPP.push(obj);

    });
    console.log(dataPP);
    cart.forEach(x => {
        text += `<li>${x.name}</li>`
    })
    cart.forEach(x => {
        descriName += `${x.name} /`
    })
}
descri();

let formMP = `
<form onsubmit="javascript:prevent(e);" method="post" id="paymentForm">
<div class="row">
    <div class="col-md-6" style="margin-bottom: 40px;">
        <h3 class="formH3">Endereço da entrega</h3>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Email:</label>
            <input type="email" name="email" placeholder="Digite seu email..." id="emailMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Nome:</label>
            <input type="text" name="nome" placeholder="Digite seu nome..." id="nomeMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CPF:</label>
            <input type="text" name="cpf" placeholder="Digite seu CPF..." id="cpfMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleFormControlInput1">DD:</label>
                    <input type="text" name="dd" placeholder="Digite seu DD..." id="DDMp" class="form-control">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Telefone:</label>
                    <input type="text" name="telefone" placeholder="Digite seu telefone..." id="telefoneMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-bottom: 40px;">
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CEP:</label>
            <input type="text" name="cep" placeholder="Digite o seu CEP..." id="cepMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Sua Rua:</label>
            <input type="text" name="rua" placeholder="Digite o nome da sua rua" id="ruaMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Número:</label>
            <input type="text" name="numero" placeholder="Digite o número da sua casa..." id="numeroDeCasaMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">UF:</label>
                    <input type="text" name="dd" placeholder="Digite seu UF..." id="ufMp" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Cidade:</label>
                    <input type="text" name="telefone" placeholder="Digite sua cidade..." id="cidadeMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h3 class="formH3">Detalhe do Produto</h3>
        <div>
            <ol class="listOl">
            ${text}
            </ol>
        </div>
        <h3 class="formH3">Detalhe do comprador</h3>
        <div class="formPay">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="text" value="test@test.com"/>
        </div>
        <div class="formPay">
            <label for="docType">Tipo de documento</label>
            <select id="docType" name="docType" data-checkout="docType" type="text"></select>
        </div>
        <div class="formPay">
            <label for="docNumber">Número do documento</label>
            <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text"/>
        </div>
    </div>
    <div class="col-md-6">
        <h3 class="formH3">Detalhes do cartão</h3>
        <div class="formPay">
            <label for="cardholderName">Titular do cartão</label>
            <input id="cardholderName" data-checkout="cardholderName" type="text">
        </div>
        <div class="formPay">
            <label for="">Data de vencimento</label>
            <div>
                <input type="text" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"
                    onselectstart="return false" onpaste="return false"
                    oncopy="return false" oncut="return false"
                    ondrag="return false" ondrop="return false" autocomplete=off class="formSmall">
                <span class="date-separator">/</span>
                <input type="text" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"
                    onselectstart="return false" onpaste="return false"
                    oncopy="return false" oncut="return false"
                    ondrag="return false" ondrop="return false" autocomplete=off class="formSmall">
            </div>
        </div>
        <div class="formPay">
            <label for="cardNumber">Número do cartão</label>
            <input type="text" id="cardNumber" data-checkout="cardNumber"
                onselectstart="return true" onpaste="return true"
                oncopy="return true" oncut="return true"
                ondrag="return true" ondrop="return true" autocomplete=off class="input-background">
        </div>
        <div class="formPay">
            <label for="securityCode">Código de segurança</label>
            <input id="securityCode" data-checkout="securityCode" type="text"
            onselectstart="return true" onpaste="return true"
            oncopy="return true" oncut="return true"
            ondrag="return true" ondrop="return true" autocomplete=true>
        </div>
        <div id="issuerInput" class="formPay">
            <label for="issuer">Banco emissor</label>
            <select id="issuer" name="issuer" data-checkout="issuer"></select>
        </div>
        <div class="formPay">
            <label for="installments">Parcelas</label>
            <select type="text" id="installments" name="installments"></select>
        </div>
    </div>
    <div class="col-md-12" style="display: flex; align-items: center; justify-content: center;">
        <div class="formPay">
            <input type="hidden" name="transactionAmount" id="transactionAmount" value="${totalCFrete}" />
            <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
            <input type="hidden" name="description" id="description" value="${descriName}"/>
            <br>
            <button type="submit" class="formButton" style="cursor: pointer;">Pagar</button>
            <br>
        </div>
    </div>
</div>
</form>
`
let formBoleto = `
    <div class="row">
    <div class="col-md-6" style="margin-bottom: 40px;">
        <h3 class="formH3">Endereço da entrega</h3>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Email:</label>
            <input type="email" name="email" placeholder="Digite seu email..." id="emailMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Nome:</label>
            <input type="text" name="nome" placeholder="Digite seu nome..." id="nomeMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CPF:</label>
            <input type="text" name="cpf" placeholder="Digite seu cpf..." id="cpfMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleFormControlInput1">DD:</label>
                    <input type="text" name="dd" placeholder="Digite seu DD..." id="DDMp" class="form-control">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Telefone:</label>
                    <input type="text" name="telefone" placeholder="Digite seu telefone..." id="telefoneMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-bottom: 40px;">
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu CEP:</label>
            <input type="text" name="rua" placeholder="Digite o seu CEP..." id="cepMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Sua Rua:</label>
            <input type="text" name="rua" placeholder="Digite a sua rua..." id="ruaMp" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Seu Número:</label>
            <input type="text" name="numero" placeholder="Digite o número da sua casa..." id="numeroDeCasaMp" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">UF:</label>
                    <input type="text" name="dd" placeholder="Digite seu UF..." id="ufMp" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Cidade:</label>
                    <input type="text" name="telefone" placeholder="Digite sua cidade..." id="cidadeMp" class="form-control">
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-6" style="display: flex; align-items: center; justify-content: center; height: 250px; flex-direction: column;">
        <p>Gerar Boleto</p>
            <button class="btn-card" style="height: 40px; width: 200px; font-size: 22px; font-weight: bold;" onclick="gerarBoleto()">
                Gerar Boleto
            </button>
        </div>
    </div>
`

let formPS = `

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleFormControlInput1">Seu Email:</label>
                <input type="email" name="email" placeholder="Digite seu email..." id="emailPagSeguro" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Seu Nome:</label>
                <input type="text" name="nome" placeholder="Digite seu nome..." id="nomePagSeguro" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Seu CPF:</label>
                <input type="text" name="cpf" placeholder="Digite seu cpf..." id="cpfPagSeguro" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">DD:</label>
                        <input type="text" name="dd" placeholder="Digite seu dd..." id="DDPagSeguro" class="form-control">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Telefone:</label>
                        <input type="text" name="telefone" placeholder="Digite seu telefone..." id="telefonePagSeguro" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleFormControlInput1">Seu CEP:</label>
                <input type="text" name="cep" placeholder="Digite o seu CEP..." id="cepPagSeguro" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Sua Rua:</label>
                <input type="text" name="rua" placeholder="Digite a sua rua..." id="ruaPagSeguro" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Seu Número:</label>
                <input type="text" name="numero" placeholder="Digite o número da sua casa..." id="numeroDeCasaPagSeguro" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">UF:</label>
                        <input type="text" name="uf" placeholder="Digite seu UF..." id="ufPagSeguro" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Cidade:</label>
                        <input type="text" name="cidade" placeholder="Digite sua Cidade..." id="cidadePagSeguro" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="display: flex; align-items: center; justify-content: center; height: 250px; flex-direction: column;">
            <p>Gerar Link</p>
            <button class="btn-card" style="height: 40px; width: 200px; font-size: 22px; font-weight: bold;" onclick="gerarPS()">
                Gerar Link
            </button>
        </div>
    </div>
`

function form(){
  if(active == 0){
    document.getElementById("form").innerHTML = `<h3 class="selection">Selecione por onde deseja pagar.</h3>`;
  }
  if(active == 1){
    document.getElementById("form").innerHTML = formMP;
    mp();
  }
  if(active == 2){
    document.getElementById("form").innerHTML = formPS;
    mp();
  }
  if(active == 3){
    document.getElementById("form").innerHTML = formPP;
    payPP();
  }
  if(active == 4){
      console.log("chamou qui")
    document.getElementById("form").innerHTML = formBoleto;
    // boleto();
  }
}

function formActive(e){
  if(e == 1){
    active = 1
    $('#mp').addClass('active');
    document.getElementById("pp").classList.remove("active")
    document.getElementById("ps").classList.remove("active")
    document.getElementById("boleto").classList.remove("active")
    form()
  }
  if(e == 2){
    active = 2
    $('#ps').addClass('active');
    document.getElementById("mp").classList.remove("active")
    document.getElementById("pp").classList.remove("active")
    document.getElementById("boleto").classList.remove("active")
    form()
  }
  if(e == 3){
    active = 3
    $('#pp').addClass('active');
    document.getElementById("ps").classList.remove("active")
    document.getElementById("mp").classList.remove("active")
    document.getElementById("boleto").classList.remove("active")

    form()
  }
  if(e == 4){
      active = 4
      $('#boleto').addClass('active');
      document.getElementById("ps").classList.remove("active")
      document.getElementById("mp").classList.remove("active")
      document.getElementById("pp").classList.remove("active")
      form()
  }
}
form();
function gerarBoleto(){
    if (!$("#emailMp")[0].value || !$("#nomeMp")[0].value || !$("#cpfMp")[0].value || !$("#telefoneMp")[0].value || !$("#cepMp")[0].value || !$("#ruaMp")[0].value || !$("#numeroDeCasaMp")[0].value || !$("#ufMp")[0].value || !$("#cidadeMp")[0].value) {
        alert("Preencha todos os campos para poder gerar o boleto.")
    }else{
        let item = [];

        cart.forEach(x => {
            let obj = {
                description: x.name,
                quantity: x.qtd,
                item_id: x.id,
                price_cents: x.price.replace(/[^\d]+/g,'')
            }
            item.push(obj);
        });
        let frete = {
            description: "frete",
            quantity: 1,
            item_id: 999999999999,
            price_cents:  valueFrete.replace(/[^\d]+/g,'')+"0"
        };
        item.push(frete);

        let data = {
            paymentSDK: "boleto",
            order_id: 1,
            payer_name: $("#nomeMp")[0].value,
            payer_cpf_cnpj: $("#cpfMp")[0].value,
            payer_email: $("#emailMp")[0].value,
            payer_street: $("#ruaMp")[0].value,
            payer_number: $("#numeroDeCasaMp")[0].value,
            payer_zip_code: $("#cepMp")[0].value,
            items:item
        }
        $.ajax({
            url:"../../Controller/CheckoutPayment.php",
            method:"POST",
            dataType : "json",
            data : data,
            success:  function(response){
                window.open(response.create_request.bank_slip.url_slip_pdf, "_blank");
                console.log(response.create_request.bank_slip.url_slip_pdf);
                let data = {
                    success: true,
                    products: cart,
                    receiver: {
                        email: $("#emailMp")[0].value,
                        name: $("#nomeMp")[0].value,
                        cpf: $("#cpfMp")[0].value,
                        telephone: `(${$("#DDMp")[0].value}) ${$("#telefoneMp")[0].value}`,
                        },
                    address: {
                        cep: $("#cepMp")[0].value,
                        rua: $("#ruaMp")[0].value,
                        numero: $("#numeroDeCasaMp")[0].value,
                        bairro: null,
                        uf: $("#ufMp")[0].value,
                        cidade: $("#cidadeMp")[0].value,
                    },
                    payment:{
                        paymentForm: 'credit',
                        paymentSdk: 'mercadopago',
                        sendPrice: valueFrete,
                        total: totalCFrete,
                    }
                }
                $.ajax({
                    "url":"../../Controller/ExecutePayment.php",
                    "method":"POST",
                    "dataType" : "json",
                    "data" : {
                        success: 'true',
                        products: JSON.stringify(cart).replaceAll('"',"'"),
                        receiver: JSON.stringify(data.receiver).replaceAll('"',"'"),
                        address: JSON.stringify(data.address).replaceAll('"',"'"),
                        payment: JSON.stringify(data.payment).replaceAll('"',"'")
                    },
                    "success": (res) => {
                        alert(res.success);
                    }
                })
            }
        });
    }
}
function gerarPS(){
    
    let item;
    cart.forEach(x => {
        let obj = {
            id: x.id,
            description: x.nome,
            amount: x.price,
            qtd: x.qtd,
            weight: 1,
            shippingCost: 0,
        }
        item = obj;
    });
//     let data = `
//     <checkout>
//     <sender>
//       <name>${$("#nomePagSeguro")[0].value}</name>
//       <email>${$("#emailPagSeguro")[0].value}</email>
//       <phone>
//         <areaCode>${$("#DDPagSeguro")[0].value}</areaCode>
//         <number>${$("#telefonePagSeguro")[0].value}</number>
//       </phone>
//       <documents>
//         <document>
//           <type>CPF</type>
//           <value>${$("#cpfPagSeguro")[0].value}</value>
//         </document>
//       </documents>
//     </sender>
//     <currency>BRL</currency>
//     <items>
//         ${item}
//     </items>
//     <redirectURL>http://www.crdv.com.br</redirectURL>
//     <extraAmount>0.00</extraAmount>
//     <reference>REF1234</reference>
//     <shipping>
//       <address>
//         <street>${$("#ruaPagSeguro")[0].value}</street>
//         <number>${$("#numeroDeCasaPagSeguro")[0].value}</number>
//         <complement>""</complement>
//         <district>""</district>
//         <city>${$("#cidadePagSeguro")[0].value}</city>
//         <state>${$("#ufPagSeguro")[0].value}</state>
//         <country>BRA</country>
//         <postalCode>${$("#cepPagSeguro")[0].value}</postalCode>
//       </address>
//       <type>1</type>
//       <cost>12.00</cost>
//       <addressRequired>true</addressRequired>
//     </shipping>
//     <timeout>25</timeout>
//     <maxAge>999999999</maxAge>
//     <maxUses>${valueFrete}</maxUses>
//     <receiver>
//       <email>caiquegl@hotmail.com</email>
//     </receiver>
//     <enableRecover>false</enableRecover>
//   </checkout>
//     `

    let data = {
        paymentSDK: "pagseguro",
        paymentMode: "teste",
        paymentMethod: "teste",
        receiverEmail: "teste",
        currency: "BRL",
        extraAmount:valueFrete,
        items: item,
        notificationURL: "caiquegl@hotmail.com",
        reference: "REF1234",
        senderName: "teste",
        senderCPF: "teste",
        senderAreaCode: "teste",
        senderPhone: "teste",
        senderEmail: "teste",
        senderHash:"teste",
        shippingAddressRequired: "teste",
        shippingAddressNumber: "teste",
        shippingAddressComplement: "teste",
        shippingAddressDistrict: "teste",
        shippingAddressPostalCode: "teste",
        shippingAddressCity: "teste",
        shippingAddressState: "teste",
        shippingAddressCountry: "teste",
        shippingType: "teste",
        shippingCost:"teste",

    }

    $.ajax({
        url:"../../Controller/CheckoutPayment.php",
        method:"POST",
        dataType : "xml",
        header: {
            "Content-Type": "application/xml; charset=ISO-8859-1",
        },
        data : data,
        success:  function(response){
            console.log(response);
        }
    });
}
function payPP(){

        let valorTotal = parseFloat(valueFrete.substr(1,4)) + datas.valueTotalPedio;
        console.log(dataPP, valorTotal)
    paypal.Buttons({
        createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    currency_code: "BRL",
                    value: valorTotal.toFixed(2),
                    breakdown: {
                            item_total: {
                                currency_code: "BRL",
                                value: datas.valueTotalPedio.toFixed(2)
                            },
                            shipping: {
                                currency_code: "BRL",
                                value: parseFloat(valueFrete.substr(1,4))
                            },
                        }
                },
                description: 'Obrigado por comprar na CRDV',
                custom_id: '64735',
                items: dataPP
            }]
        });
        },
        onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
            console.log(details)
            let data = {
                success: true,
                products: cart,
                receiver: {
                    email: $("#emailMp")[0].value,
                    name: $("#nomeMp")[0].value,
                    cpf: $("#cpfMp")[0].value,
                    telephone: `(${$("#DDMp")[0].value}) ${$("#telefoneMp")[0].value}`,
                    },
                address: {
                    cep: $("#cepMp")[0].value,
                    rua: $("#ruaMp")[0].value,
                    numero: $("#numeroDeCasaMp")[0].value,
                    bairro: null,
                    uf: $("#ufMp")[0].value,
                    cidade: $("#cidadeMp")[0].value,
                },
                payment:{
                    paymentForm: 'credit',
                    paymentSdk: 'PayPal',
                    sendPrice: valueFrete,
                    total: totalCFrete,
                }
            }
            $.ajax({
                "url":"../../Controller/ExecutePayment.php",
                "method":"POST",
                "dataType" : "json",
                "data" : {
                    success: 'true',
                    products: JSON.stringify(cart).replaceAll('"',"'"),
                    receiver: JSON.stringify(data.receiver).replaceAll('"',"'"),
                    address: JSON.stringify(data.address).replaceAll('"',"'"),
                    payment: JSON.stringify(data.payment).replaceAll('"',"'")
                },
                "success": (res) => {
                    alert(res.success);
                }
            })
            alert('Pedido realizado com sucesso ' + details.payer.name.given_name);
        });
        }
    }).render('#paypal-button-container');

  //This function displays Smart Payment Buttons on your web page.
}

function mp(){
  window.Mercadopago.setPublishableKey("TEST-f630a334-a485-4232-a7e6-4e0f2f111472");
  window.Mercadopago.getIdentificationTypes();

  document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

  function guessPaymentMethod(event) {

        let cardnumber = document.getElementById("cardNumber").value;
        if (cardnumber.length >= 6) {
            let bin = cardnumber.substring(0,6);
            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethod);
        }
    

  };

  function setPaymentMethod(status, response) {
      if (status == 200) {
          let paymentMethod = response[0];
          document.getElementById('paymentMethodId').value = paymentMethod.id;
          document.getElementById('cardNumber').style.backgroundImage = 'url(' + paymentMethod.thumbnail + ')';

          getIssuers(paymentMethod.id);
      } else {
          alert(`payment method info error: ${response}`);
      }
  }

  function getIssuers(paymentMethodId) {
      window.Mercadopago.getIssuers(
          paymentMethodId,
          setIssuers
      );
  }

  function setIssuers(status, response) {
      if (status == 200) {
          let issuerSelect = document.getElementById('issuer');
          response.forEach( issuer => {
              let opt = document.createElement('option');
              opt.text = issuer.name;
              opt.value = issuer.id;
              issuerSelect.appendChild(opt);
          });

          getInstallments(
              document.getElementById('paymentMethodId').value,
              document.getElementById('transactionAmount').value,
              issuerSelect.value
          );
      } else {
          alert(`issuers method info error: ${response}`);
      }
  }

  function getInstallments(paymentMethodId, transactionAmount, issuerId){
      window.Mercadopago.getInstallments({
          "payment_method_id": paymentMethodId,
          "amount": parseFloat(transactionAmount),
          "issuer_id": parseInt(issuerId)
      }, setInstallments);
  }

  function setInstallments(status, response){
      if (status == 200) {
          document.getElementById('installments').options.length = 0;
          response[0].payer_costs.forEach( payerCost => {
              let opt = document.createElement('option');
              opt.text = payerCost.recommended_message;
              opt.value = payerCost.installments;
              document.getElementById('installments').appendChild(opt);
          });
      } else {
          alert(`installments method info error: ${response}`);
      }
  }

  doSubmit = false;
  document.getElementById('paymentForm').addEventListener('submit', getCardToken);
  function getCardToken(event){
      event.preventDefault();
      if(!doSubmit){
          let $form = document.getElementById('paymentForm');
          window.Mercadopago.createToken($form, setCardTokenAndPay);
          return false;
      }
  };

  function setCardTokenAndPay(status, response) {
      // "transactionAmount", "token", "description", "installments", "paymentMethodId",
      // "issuer", "email", "docType", "docNumber"
    if(!$("#emailMp")[0].value || !$("#nomeMp")[0].value || !$("#cpfMp")[0].value || !$("#telefoneMp")[0].value || !$("#cepMp")[0].value || !$("#ruaMp")[0].value || !$("#numeroDeCasaMp")[0].value || !$("#ufMp")[0].value || !$("#cidadeMp")[0].value){
        alert('Por favor, preencha todos os dados...')
    }else{
      if (status == 200 || status == 201) {
          let form = document.getElementById('paymentForm');
          let card = document.createElement('input');
          card.setAttribute('name', 'token');
          card.setAttribute('type', 'hidden');
          card.setAttribute('value', response.id);
          form.appendChild(card);
          
          console.log(response, status);
          doSubmit=true;

          let data = {
              paymentSDK: "mercadopago",
              token: response.id,
              description: $("#description")[0].value,
              installments: $("#installments")[0].value,
              transactionAmount: $("#transactionAmount")[0].value,
              paymentMethodId: $("#paymentMethodId")[0].value,
              issuer: $("#issuer")[0].value,
              email: $("#email")[0].value,
              docType: $("#docType")[0].value,
              docNumber: $("#docNumber")[0].value
          }
          $.ajax({
          "url":"../../Controller/CheckoutPayment.php",
          "method":"POST",
          "dataType" : "json",
          "data" : data,
          "success": (res) => {
                  if(res.status_detail == "accredited"){
                      alert(`Pronto, seu pedido foi realizado, gerando ordem! `);
                      let data = {
                        success: true,
                        products: cart,
                        receiver: {
                            email: $("#emailMp")[0].value,
                            name: $("#nomeMp")[0].value,
                            cpf: $("#cpfMp")[0].value,
                            telephone: `(${$("#DDMp")[0].value}) ${$("#telefoneMp")[0].value}`,
                            },
                        address: {
                            cep: $("#cepMp")[0].value,
                            rua: $("#ruaMp")[0].value,
                            numero: $("#numeroDeCasaMp")[0].value,
                            bairro: null,
                            uf: $("#ufMp")[0].value,
                            cidade: $("#cidadeMp")[0].value,
                        },
                        payment:{
                            paymentForm: 'credit',
                            paymentSdk: 'mercadopago',
                            sendPrice: valueFrete,
                            total: totalCFrete,
                        }
                    }
                    $.ajax({
                        "url":"../../Controller/ExecutePayment.php",
                        "method":"POST",
                        "dataType" : "json",
                        "data" : {
                            success: 'true',
                            products: JSON.stringify(cart).replaceAll('"',"'"),
                            receiver: JSON.stringify(data.receiver).replaceAll('"',"'"),
                            address: JSON.stringify(data.address).replaceAll('"',"'"),
                            payment: JSON.stringify(data.payment).replaceAll('"',"'")
                        },
                        "success": (res) => {
                            alert(res.success);
                        }
                    })
                  }
                  if(res.status_detail == "pending_contingency"){
                      alert(`Estamos processando o pagamento.`);
                  }
                  if(res.status_detail == "pending_review_manual"){
                      alert(`Estamos processando o pagamento.`);
                  }
                  if(res.status_detail == "cc_rejected_bad_filled_card_number"){
                      alert(`Revise o número do cartão.`);
                  }
                  if(res.status_detail == "cc_rejected_bad_filled_date"){
                      alert(`Revise a data de vencimento.`);
                  }
                  if(res.status_detail == "cc_rejected_bad_filled_other"){
                      alert(`Revise os dados.`);
                  }
                  if(res.status_detail == "cc_rejected_bad_filled_security_code"){
                      alert(`Revise o código de segurança do cartão.`);
                  }
              }
          });
          
      } else {
          alert("Errrooo!\n"+JSON.stringify(response, null, 4));
      }
    }
  };
}