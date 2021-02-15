<?php


use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

include '../partial/header.php';

?>
        
        <!-- INICIO AREA DE LOGIN-->
        <div id="tela_login">
            <div class="boxLogin">
                <div class="padding5">
                    <h1>Login</h1>
                    <form method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Seu Email:</label>
                            <input type="text" name="email" placeholder="Digite seu email..." id="campo_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Sua senha:</label>
                            <input type="password" name="password" placeholder="Digite sua senha..." id="campo_password" class="form-control">
                        </div>
                    </form>
                    <input type="image" src="../imagens/Botão_ok.png" name="entrar" id="btn_entrar">
                </div>
                
                    <div class="headerLogin">
                        <p>Novo por aqui?   <a href="cadastro.php">Cadastre-se</a></p>
                    </div>
            </div>     
        </div>
        <div id='loading'></div>

        <script src="../javascript/btnLoginClick.js"></script>
<?php

include '../partial/footer.php';

?>