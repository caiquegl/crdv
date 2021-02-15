<?php
require_once( dirname(__DIR__, 3) . "/vendor/autoload.php");

use CRDV\Model\UserFunctions\UserSetHeaders;

if(isset($_SESSION["token"])){
    $token = UserSetHeaders::decodeToken();
    if($token !== false){
        $LoginBoxHref = "user-profile.php";
        $LoginBoxText = explode("@",$token["email"])[0];
    } else {
        $LoginBoxHref = "login.php";
        $LoginBoxText = "Entrar";    
    }
} else {
    $LoginBoxHref = "login.php";
    $LoginBoxText = "Entrar";
}

include( '../partial/header.php' );
?>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <div class="container">
            <h1>Meu carrinho</h1>
            <div class="conteudo">
                <div class="itens">
                
                </div>
                <div class="valueTotal">
                
                </div>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="next" onclick="back()">Continuar comprando</button>
                    <button class="next" onclick="nextStep()">Avançar</button>
                </div>
            </div>
        </div>
    </div>

    <div id='loading'></div>


    <!-- JS --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../javascript/getCart.js"></script>
    <script type="text/javascript" src="../javascript/loadCart.js"></script>

<?php

include '../partial/footer.php';

?>