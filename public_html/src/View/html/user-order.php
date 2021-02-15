<?php
session_start();

require_once( dirname(__DIR__, 3) . "/vendor/autoload.php");

use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

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

?>
    <?php include '../partial/header.php';
 ?>
    <h1></h1>

    <div class="row">
        <div class="col-md-3">
        <div class="perfil-usuario">
            <img src="../imagens/perfil.png" style="margin-top: 20px;">
            <div id="nome-perfil">
                GEAN ROCHA GOMES
            </div>
            <div id="selector_perfil">
                <ul>
                    <li style="margin-left: 4%;"><a href="user-profile.php">Minha conta</a></li>
                    <li style="margin-left: 4%;"><a href="user-password.php">Alterar Senha</a></li>
                    <li style="margin-left: 4%;"><a href="user-order.php">Meus Pedidos</a></li>
                    <li style="margin-left: 4%;"><a href="logout.php">Sair</a></li>
                </ul>
            </div>
            <div class="opc"></div>
        </div>
        </div>
        <div class="col-md-6">
            <div style="margin-left: 15%; display: flex;">
                <div name="aba_perfil" class="abas_perfil" style="background-color: #ececec;"  >
                    <img style="width: 12%;" src="../imagens/perfil2.png">
                    <a style="color: black; font-weight: bold; margin-left: 2%;" href="user-profile.php">Meu perfil</a>
                </div>
                <div name="aba_pedidos" class="abas_perfil">
                    <img style="width: 15%;" src="../imagens/order.png">
                    <a style="color: black; font-weight: bold; margin-left: 2%;" href="user-order.php">Meus Pedidos</a>
                </div>
            </div>
            <div id="container_perfil">
                <h2 style="color: black; font-weight: bold;">Meus Pedidos</h2>
                <br>
                <label style="color: black;" for="pedido">Numero do Pedido:</label>
                <input type="text" name="nome" >
                <br>
                </select>
                <br>
                <button style="margin-left: 50%; margin-top: -4%; padding: 3px;">Rastreio</button>
            </div>
        </div>
    </div>




    <!-- RODAPE -->
    <?php include '../partial/footer.php';
 ?>
    <script src="../javascript/getCart.js"></script>
</body>

</html>