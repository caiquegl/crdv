<?php


use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

include '../partial/header.php';

?>
<link rel="stylesheet" href="../css/formPagamento.css">
<style>
    .active{
        background-color: #E5E9DF;
    }
    .paypal{
        margin: 100px;
    }
    .selection{
        font-weight: bold;
        letter-spacing: 2px;
        text-align: center;
    }
    
</style>

<h1>Pagamento</h1>
<div class="containerPayment">
    <div class="boxPayment" id="mp">
        <img style="height: 35px;" onclick="formActive(1)" src="../imagens/mercadopago.png"> 
    </div>
    <div class="boxPayment" id="ps">
        <img style="height: 35px;" onclick="formActive(2)" src="../imagens/pagseguro.png">
    </div>
    <div class="boxPayment" id="pp">
        <img style="height: 35px;" onclick="formActive(3)" src="../imagens/paypal.png"> 
    </div>
    <div class="boxPayment" id="boleto" style="width: 100px;">
        <img style="height: 35px; width: 75px;" onclick="formActive(4)" src="../imagens/boleto.png"> 
    </div>
</div>
<div class="container containerForm" id="form">

</div>
<script>
        var user = window.localStorage.user;
        if (!user) {
            window.location.href = "login.php";
        }
</script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="../javascript/payment.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AYgnPI4ESmquNmQeJlVT7LtbSUQmFgqZ9UYlGQJddy6kKJ-x5_9JJw5LqJdbALFvCfriZXAwyGUFAl_X&currency=BRL"></script>

<script>

    const PublicKey = 'TEST-f630a334-a485-4232-a7e6-4e0f2f111472';
    const AcessToken = 'TEST-3456282241922594-060320-15c35aa32e719ec26d4448ae1895d5fc-578970141';


    function prevent(e){
        e.preventDefault();
        console.log(e);
    }
</script>



<?php

include '../partial/footer.php';

?>