<?php

    include_once("recaptcha.php");

?>
<?php

session_start();

require_once( dirname(__DIR__, 3) . "/vendor/autoload.php");

use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;

function sair(){
    echo "sair";
    session_destroy();
}

if(isset($_SESSION["token"])){
    $token = UserSetHeaders::decodeToken();
    if($token !== false){
        $LoginBoxHref = "user-profile.php";
        $LoginBoxText = $token["name"];
    } else {
        $LoginBoxHref = "login.php";
        $LoginBoxText = "Entrar";    
    }
} else {
    $LoginBoxHref = "login.php";
    $LoginBoxText = "Entrar";
}

    $secret = "6Lc_dCwaAAAAAL-GNSJ4_LI4-Jp5tGS9v_6q8n9r";

    $response = null;
    $reCaptcha = new reCaptcha($secret);

        if(isset($_POST['g-recaptcha'])){
            $response = $reCaptcha -> verifyResponse($_SERVER['REMOTE_ADDR'], $_POST['g-recaptcha']);

        }
        if($response != null && $response -> sucess){
            echo "foi";
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/newStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="../javascript/jquery.mask.js"></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <!-- <script src="../javascript/script.js"></script> Script with bug --> 
    <!-- Load products -->
    <script src="../javascript/getProducts.js"></script>
    <script src="../javascript/loadProducts.js"></script>
    <!-- Search -->
    <script src="../javascript/search.js"></script>
    <!-- Cart -->
    <script src="../javascript/addItemToCart.js"></script>
    <title>CRDV MAGAZINE</title>
    <link href="../css/StyleSheet.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="../imagens/favicon.ico"/>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <div class="container-fluid">
        <img  style="margin-left: -1%; margin-bottom: -5%; position: absolute; width: 100%; "src="../imagens/cabeçalho.png">


        <!-- Para tirar o logo é só apagar essa linha de codigo de baixo -->
        <div class="row">
            <div class="col-md-3">
                <img onclick="home()" style="width: 200px; cursor: pointer;" src="../imagens/Logo_CRDV.png">
            </div>
            <div class="col-md-9">
                <div class="header">
                    <a class="menu_header" href="index.php">
                        Home
                    </a>
                    <a class="menu_header" href="setores.php?setor=Brinquedos">
                        Brinquedos
                    </a>
                    <a class="menu_header" href="setores.php?setor=Cabos">
                        Cabos
                    </a>
                    <a class="menu_header" href="setores.php?setor=Eletrônicos">
                        Eletrônicos
                    </a>
                    <a class="menu_header" href="setores.php?setor=Energia">
                        Energia
                    </a>
                    <a class="menu_header" href="setores.php?setor=Informática">
                    Informática
                    </a>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="busca col-md-4">
                        <input type="text" class="txtBusca" onkeypress="buscar(event)" placeholder="Buscar..."/>
                    </div>
                    <div class="iconHeader col-md-5">
                        <a href="carrinho.php">
                            <div class="contentCart">
                                <div class="boxCart">
                                    <img src="../icones/card.svg">
                                </div>
                                <p class="qtd_compra">.</p>
                            </div>

                        </a>

                        <a href="<?=$LoginBoxHref?>">
                            <div class="contentUser">
                                <div class="boxUser">
                                    <img src="../icones/user.svg">
                                </div>
                                <pconst class="user_nome"><?=$LoginBoxText?></p>
                            </div>
                        </a>

                        <?php if($LoginBoxText != 'Entrar'){?>
                            <svg onclick="logout()" style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                                <path fill="#649615" fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                                <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                            </svg>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div class="fixed-icons">
        <img class="imgFooter" src="../icones/instagram.png" usemap="#instagram">
        <img class="imgFooter"src="../icones/facebook1.png" usemap="#facebook">
        <a target="_blank" href="https://api.whatsapp.com/send?phone=5511947197891&text=Ol%C3%A1%2C%20gostaria%20de%20falar%20contigo.">
            <img src="../icones/whatsapp.png" class="imgFooter" alt="" srcset="" style="cursor: pointer;">
        </a>
        <img src="../icones/email.png" class="imgFooter" alt="" style="cursor: pointer;" onclick="abreModal()" data-toggle="modal" data-target="#modalEmail">
    </div>


    <div id="modalEmail" class="modal fade" role="dialog" >
        <div class="modal-dialog">
              <!-- Modal content-->
            <div class="modal-content sendEmail">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-modal">
                        <h3>Fale Conosco</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 20px;">
                                    <label style="text-align: left; width: 100%;" for="Nome">Nome:</label>
                                    <input type="text" class="form-control" placeholder="Digite o seu nome"  name="nome" id="nomeEmail"/>
                                </div>
                                <div class="form-group" style="margin-top: 20px;">
                                    <label style="text-align: left; width: 100%;" for="email">Email:</label>
                                    <input type="email" class="form-control" placeholder="Digite o seu email"  name="email" id="emailEmail"/>
                                </div>
                                <div class="form-group" style="margin-top: 20px;">
                                    <label style="text-align: left; width: 100%;" for="Telefone">Telefone:</label>
                                    <input type="text" class="form-control" placeholder="Digite o seu elefone"  name="telefone" id="telefoneEmail"/>
                                </div>
                                <div class="form-group" style="margin-top: 20px;">
                                    <label style="text-align: left; width: 100%;" for="Numero">Numero do pedido:</label>
                                    <input type="text" class="form-control" placeholder="Digite o seu numero do pedido" id="numeroPedidoEmail"/>
                                </div>
                                <div class="form-group" style="margin-top: 20px;">
                                    <label style="text-align: left; width: 100%;" for="menssagem">Mensagem:</label>
                                    <textarea class="textA" placeholder="Digite a mensagem" id="menssagemEmail"> </textarea>
                                </div>
                                <!-- <div class="verification" style="margin-top: 20px;">
                                    <div class="g-recaptcha" data-sitekey="6Lc_dCwaAAAAADeElyERdTs-nBoN99oh1zS3UoVc">
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>Razao Social:</h5>
                                    <p>
                                        Rosana Dias Vieira Informática
                                    </p>
                                </div>
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>CNPJ:</h5>
                                    <p>
                                        11.339.372/0001-63
                                    </p>
                                </div>
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>Telefone:</h5>
                                    <p>
                                        (11) 4636-8884
                                    </p>
                                </div>
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>WhatasApp:</h5>
                                    <p>
                                        (11) 94719-7891
                                    </p>
                                </div>
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>Endereço:</h5>
                                    <p>
                                        Rua Travessa Miguel Saad, 47 - Sala 02, Centro, Poá
                                    </p>
                                </div>
                                <div class="form-group modalEmail" style="margin-top: 20px;">
                                    <h5>Email:</h5>
                                    <p>
                                        crdvmagazine@gmail.com
                                    </p>
                                </div>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1293.371162211684!2d-46.34476068444898!3d-23.525089327614126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce7adfbf4a48ad%3A0xa6c729c36473acbb!2sTavares%20%26%20Silva%20-%20Imobili%C3%A1ria%20e%20Corretora%20de%20Seguros!5e0!3m2!1spt-BR!2sbr!4v1610664996940!5m2!1spt-BR!2sbr" width="100%" height="300" frameborder="0" style="border:2px;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="flexCenter">
                                    <button class="btn-card" type="button" onclick="sendEmail()"> Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

</div>

        
       
<script>
    function home(){
        window.location.href = "index.php";
    }
    function sendEmail() {
        if($("#menssagemEmail")[0].value && $("#nomeEmail")[0].value && $("#emailEmail")[0].value){
            let data = {
            nome: $("#nomeEmail")[0].value,
            email: $("#emailEmail")[0].value,
            tel: $("#telefoneEmail")[0].value,
            numeroPedido: $("#numeroPedidoEmail")[0].value,
            msg: $("#menssagemEmail")[0].value,
            }
            console.log(data)
            window.alert("Mensagem enviada!!")
        }else{
            window.alert("Por favor preencha todos os campos.")
        }

    }

        function abreModal(){
        console.log("chamou")
        $('#modalemail').modal('show');
            
    }
    function fechaModal(){
    $('#modalemail').modal('hide');
    }

    function logout(){
        window.location.href = "logout.php";
    }
</script>
    
    <!-- FIM DO HEADER-->