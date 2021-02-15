<?php


use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;

include '../partial/header.php';

?>

<!-- INICIO TELA DE CADASTRO -->
<div class="">
    <div class="container boxCadastro">
      <form method="post" action=""> 
          <h1>Cadastro</h1> 
           <div class="row">
             <div class="col-md-6">
              <p> 
                <label for="nome_cad">Nome</label>
                <br>
                <input class="valores" id="name" name="nome_cad" required="required" type="text" placeholder="Digite seu Nome..." />
              </p>
              
              <p> 
                <label for="nome_cad">Sobrenome</label>
                <br>
                <input class="valores" id="surname" name="nome_cad" required="required" type="text" placeholder="Digite seu Sobrenome..." />
              </p>

              <p> 
                <label for="email_cad">E-mail</label>
                <br>
                <input class="valores" id="email" name="email_cad" required="required" type="email" placeholder="exemplo@exemplo.com"/> 
              </p>

              <p> 
                <label for="senha_cad">Telefone</label>
                <br>
                <input class="valores" id="tel" name="telefone" required="required" placeholder="(99) 9 9999-9999" />
              </p>

              <p> 
                <label for="senha_cad">Telefone Residencial</label>
                <br>
                <input class="valores" id="residencial" name="residencial" required="required" placeholder="(99) 9999-9999" />
              </p>
              <div style="display: inline-block; margin-left: 20px; margin-bottom: 10px;">
                <input type="radio" id="iPersonTypePF" name="iPersonType" value="pf" checked>
                <label for="male">PF</label>
                <input type="radio" id="iPersonTypePJ" name="iPersonType" value="pj" style="margin-left: 10px;">
                <label for="female">PJ</label><br>
              </div>
              <div id="pType">
                  <p> 
                    <label for="senha_cad">CPF</label>
                    <br>
                    <input class="valores" id="cpf" name="cpf_cad" required="required" type="text" placeholder="ex. 000.000.000-00"/>
                  </p>
              </div>
             </div>
             <div class="col-md-6">
             <p> 
                <label for="senha_cad">CEP</label>
                <br>
                <input class="valores" id="cep" name="cep_cad" required="required" type="text" placeholder="ex. 00.000-00"/>
              </p>

              <p> 
                <label for="senha_cad">Rua</label>
                <br>
                <input class="valores" id="rua" name="rua_cad" required="required" type="text"/>
              </p>
              <p> 
                <label for="senha_cad">Número e Complemento</label>
                <br>
                <input class="valores" id="numero" name="number_cad" required="required" type="text"/>
              </p>

              <p>
                <label for="senha_cad">Bairro</label>
                <br>
                <input class="valores" id="bairro" name="bairro_cad" required="required" type="text"/> 
              </p>
                
              <p>
                <label for="senha_cad">Cidade</label>
                <br>
                <input class="valores" id="cidade" name="cidade_cad" required="required" type="text"/>
                <label for="senha_cad">UF</label>
                <input class="valores_UF" id="UF" name="UF_cad" required="required" type="text"/>
              </p>

              <p> 
                <label for="senha_cad">Senha</label>
                <br>
                <input class="valores" id="password" name="senha_cad" required="required" type="password"/>
              </p>

              <p> 
                <label for="senha_cad">Digite novamente sua senha</label>
                <br>
                <input class="valores" id="passwordConfirm" name="senha_cad" required="required" type="password"/>
              </p>

              
            </form>
             </div>
           </div>
          

          
          
        <p> 
          <input type="submit" value="Cadastrar" id="cadastrar" /> 
        </p>  
    </div>
    <div id='loading'></div>


</div>

    <script src="../javascript/btnRegisterClick.js"></script>
    <script src="../javascript/cepFind.js"></script>
    <script type="text/javascript" src="../javascript/radiopType.js"></script>
<?php

include '../partial/footer.php';

?>