<?php

include '../partial/header.php';

require_once( dirname(__DIR__, 3) . "/vendor/autoload.php");

use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\UserFunctions\UserDAOMySQL;
use CRDV\Model\UserFunctions\UserSetHeaders;

if(isset($_SESSION["token"])){
    $token = UserSetHeaders::decodeToken();
    if($token !== false){
        $id = $token["uId"];
        $mysql = new MySQLConnection();
        $userDb = new UserDAOMySQL($mysql->connect());
        $user = $userDb->findById($id);
        $address = json_decode(str_replace("\\","",str_replace("'","\"",$user->address)));
    } else { 
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

?>
    
    <h1></h1>

    <div class="row">
        <div class="col-md-3">
        <div class="perfil-usuario">
            <img src="../imagens/perfil.png" style="margin-top: 20px;">
            <div id="nome-perfil">
            <?=strtoupper($user->name . " " . $user->surname)?>
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
            <div style="margin-left: 15%; display:flex">
                <div name="aba_perfil" class="abas_perfil">
                    <img style="width: 12%;" src="../imagens/perfil2.png">
                    <a style="color: black; font-weight: bold; margin-left: 2%;" href="user-profile.php">Meu perfil</a>
                </div>
                <div name="aba_pedidos" class="abas_perfil" style="background-color: #ececec;">
                    <img style="width: 15%;" src="../imagens/order.png">
                    <a style="color: black; font-weight: bold; margin-left: 2%;" href="user-order.php">Meus Pedidos</a>
                </div>
            </div>

    <div id="container_perfil">
        <div class="inf-user">
                <h2 style="color: black; font-weight: bold;">Atualizar conta</h2>
                <br>
                <table class="table-user">
            <tr>
            <br>
                <td><label style="color: black; margin-left: 8.5%;" for="nome">Nome:</label></td>
                <td><input type="text" name="nome" value="<?=$user->name?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 3%;" for="nome">Sobrenome:</label></td> 
                <td><input type="text" name="sobrenome" value="<?=$user->surname?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 8.5%;" for="email">E-mail:</label></td>
                <td><input type="text" name="email" value="<?=$user->email?>" style="width: 250px"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 5%;" for="cpf">CPF/CNPJ:</label></td>
                <td><input type="text" id="cpf" name="cpf" value="<?=empty($user->cnpj)?$user->cpf:$user->cpf?>"></td>
            </tr>    
            <tr>
                <td><label style="color: black; margin-left: 8%;" for="celular">Celular:</label></td>
                <td><input type="text" name="celular" value="<?=$user->telephone?>"></td>
            </tr>     
            </table>
            </div>
        <div class="inf-user">
            <table class="table-user" style="margin-top: 80px;">
            <tr>
            <br>
                <td><label style="color: black; margin-left: 8.5%;" for="rua">Rua:</label></td>
                <td><input type="text" name="rua" value="<?=$address->rua?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 4%;" for="numero">Numero:</label></td> 
                <td><input type="text" name="numero" value="<?=$address->numero?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 8.5%;" for="cep">CEP:</label></td>
                <td><input type="text" name="cep" value="<?=$address->cep?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 5%;" for="cpf">Cidade:</label></td>
                <td><input type="text" name="cidade" value="<?=$address->cidade?>"></td>
            </tr>
            <tr>
                <td><label style="color: black; margin-left: 5%;" for="bairro">Bairro:</label></td>
                <td><input type="text" name="bairro" value="<?=$address->bairro?>"></td>
            </tr>      
            <tr>
                <td><label style="color: black; margin-left: 8%;" for="celular">Estado:</label></td>
                <td><input type="text" name="estado" value="<?=$address->uf?>"></td>
            </tr>     
            </table>
            <button class="btnId" id="<?=$id?>"style="margin-left: 70%; margin-top: -4%; padding: 3px;">Salvar</button>
        </div>
            
            </div>
        </div>
    </div>

    <script>
        document.getElementsByClassName("btnId")[0].onclick = (e) => {
            var id = document.getElementsByClassName("btnId")[0].id;
            var email = document.getElementsByName("email")[1].value;
            var nome = document.getElementsByName("nome")[1].value;
            var sobrenome = document.getElementsByName("sobrenome")[0].value;
            var cpf = document.getElementsByName("cpf")[0].value;
            var celular = document.getElementsByName("celular")[0].value;
            var rua = document.getElementsByName("rua")[0].value;
            var numero = document.getElementsByName("numero")[0].value;
            var cep = document.getElementsByName("cep")[0].value;
            var cidade = document.getElementsByName("cidade")[0].value;
            var bairro = document.getElementsByName("bairro")[0].value;
            var uf = document.getElementsByName("estado")[0].value;
            if(uf.length > 2){window.alert("O Estado informado deve conter apenas as iniciais. Ex.: AM")}else{
            $.ajax({
                "url" : "../../Controller/User.php",
                "method" :  "POST",
                "dataType" : "json",
                "data" : {
                    "action" : "updateuser",
                    "email" : email,
                    "password": "",
                    "name": nome,
                    "surname": sobrenome,
                    "cnpj": "",
                    "cpf": cpf,
                    "socialReason": "",
                    "stateRegistration": "",
                    "address": `{'cep':'${cep}','rua':'${rua}','bairro':'${bairro}','cidade':'${cidade}','uf':'${uf}','numero':'${numero}}'`,
                    "telephone": celular,
                    "residentialPhone": "",
                    "uId" : id
                },
                "success": (res) => {
                
                }
            });
        };
    }
    </script>


    <!-- RODAPE -->
    <?php include '../partial/footer.php';
 ?>
    <script src="../javascript/getCart.js"></script>
</body>

</html>