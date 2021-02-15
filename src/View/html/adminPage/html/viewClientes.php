<?php

session_start();

require_once( dirname(__DIR__, 5) . "/vendor/autoload.php");

use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;

if(isset($_SESSION["token"])){
 	$token = UserSetHeaders::decodeToken();
    if($token !== false && $token["userPrivilege"] == "1"){
 	} else {
		unset($_SESSION["token"]);

 		session_regenerate_id();
 		header("Location: index.php");
 	}
} else {
 	unset($_SESSION["token"]);

 	session_regenerate_id();
 	header("Location: ../../index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Manutenção CRDV</title>
	<link rel="stylesheet" type="text/css" href="../css/Estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../../imagens/favicon.ico"/>
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		/* Firefox */
		input[type=number] {
			-moz-appearance: textfield;
		}
		a{
			text-decoration: none;
		}
		a:hover{
			color: white;
		}
		.bgNone{
			background: none;
			border: none;
		}
		.bg{
			background: #3F8854!important;
		}
		.bgButton:hover{
			transition: all 0.3s;
			background: green !important;
		}
		.loader{
  position: absolute;
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgb(0, 0, 0, 0.50);
  color: white !important;
  top: 0;
  left: 0;
}
.loader h1{
	color: white;
}
	</style>

</head>
<body>
	
	<header>
		<div id="menu" class="bg">
			<a href="../../index.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16" style="color: white;">
  					<path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
  					<path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
				</svg>
			</a>
			<div class="dropdown">
			  <button class="dropbtn bg bgButton" style="font-weight: bold;"><a class="dropbtn bg bgButton" href="./viewBanner.php"> Banner</a></button>
			</div>
			<div class="dropdown">
			  <a class="dropbtn bg bgButton" href="./viewClientes.php" style="font-weight: bold;">Clientes</a>
			</div>

			<div class="dropdown">
			  <a class="dropbtn bg bgButton"  href="./viewPedidos.php" style="font-weight: bold; text-decoration: none;" >Pedidos</a>
			</div>	

			<div class="dropdown">
			  <a class="dropbtn bg bgButton" href="./index.php" style="font-weight: bold; text-decoration: none;" >Produtos</a>
			</div>		
			
		</div>
	</header>


	<main style="margin-bottom: 5%; margin-top: 5%">
		<div class="container shadow" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
		<header class="row bg-success" style="padding: 10px; border-top-right-radius: 15px; border-top-left-radius: 15px;">
				<div class="col-md-12 mx-auto" style="display: flex; align-items: center; justify-content: center;">
					<h1 style="color: white;">Lista de clientes</h1>
				</div>
			</header>
			<div style="padding-bottom: 20px;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" style="text-align: center; width: 5%">ID</th>
							<th scope="col" style="text-align: center;">Nome</th>
							<th scope="col" style="text-align: center;">Sobrenome</th>
							<th scope="col" style="text-align: center;">Cpf / Cnpj</th>
							<th scope="col" style="text-align: center;">Telefone</th>
							<th scope="col" style="text-align: center;">Ações</th>
						</tr>
					</thead>
					<tbody id="tableUser">
					
					</tbody>
				</table>
			</div>
		</div>
		<div class="container shadow" style="border-radius: 15px; padding: 0.6rem; margin-top: 40px;">
			<header class="row bg-success" style="padding: 10px; border-top-right-radius: 15px; border-top-left-radius: 15px;">
				<div id="camera_fundo" class="col-md-3" style="margin: 10px 10px 10px 50px;">
					<a href="#"><img id="camera" src="../imagens/camera.png"></a> 
				</div>
				<div class="col-md-8 mx-auto" style="display: flex; align-items: center; justify-content: left;">
					<h1 style="color: white;margin-left: 15%;">Registrar cliente</h1>
				</div>
			</header>
			<form method="post" action="">
				<main class="row" >
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome_cad">Nome:</label>
							<input type="text" class="form-control" placeholder="Digite o nome do cliente"  name="nome_cad" id="name"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="sobrenome">Sobrenome:</label>
							<input type="text" class="form-control" placeholder="Digite o sobrenome do cliente"  name="sobrenome" id="surname"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="email_cad">E-mail:</label>
							<input type="text" class="form-control" placeholder="Digite o e-mail do cliente"  name="email_cad" id="email" />
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="telefone">Telefone:</label>
							<input type="text" class="form-control" placeholder="Digite o telefone do cliente"  name="telefone" id="tel"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="residencial">Telefone residencial:</label>
							<input type="text" class="form-control" id="residencial"  placeholder="Digite o residencial do cliente"  name="residencial"/>
						</div>
						<div style="margin-top: 20px; display:flex; align-itens: center; justify-content: center; width: 100%;">
							<div class="form-check">
								<input class="form-check-input" type="radio" id="iPersonTypePF" name="iPersonType" value="pf" checked>
								<label class="form-check-label" for="iPersonTypePF">
									PF
								</label>
							</div>
							<div class="form-check" style="margin-left: 30px;">
								<input class="form-check-input" type="radio" id="iPersonTypePJ" name="iPersonType" value="pj" style="margin-left: 10px;">
								<label class="form-check-label" for="iPersonTypePJ">
									PJ
								</label>
							</div>
						</div>
						<div  class="form-group" style="margin-top: 20px;" id="pType">
			                <label for="senha_cad">CPF</label>
                			<input class="form-control" id="cpf" name="cpf_cad" required="required" type="text" placeholder="ex. 000.000.000-00"/>
				        </div>           
						<div class="form-group" style="margin-top: 20px;">
							<label for="cep_cad">CEP:</label>
							<input type="text" id="cep" class="form-control" placeholder="Digite o CEP do cliente"  name="cep_cad"/>
						</div>           
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="rua">Rua:</label>
							<input type="text" id="rua" class="form-control" placeholder="Digite a rua do cliente"  name="rua_cad"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="numero">Número:</label>
							<input type="number" id="numero" class="form-control" placeholder="Digite o número do cliente"  name="numero"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="bairro">Bairro:</label>
							<input type="text" id="bairro" class="form-control" placeholder="Digite o bairro do cliente"  name="bairro"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="cidade">Cidade:</label>
							<input type="text" id="cidade" class="form-control" placeholder="Digite o cidade do cliente"  name="cidade"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="UF">UF:</label>
							<input type="text" id="UF" class="form-control" placeholder="Digite o UF do cliente"  name="UF"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="password">Senha:</label>
							<input type="password" id="password" class="form-control" placeholder="Digite o senha do cliente"  name="password"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="confirme_password">Confirme a senha:</label>
							<input type="password" id="confirme_password" class="form-control" placeholder="Confirme a senha do cliente"  name="confirme_password"/>
						</div>
					</div>
				</main>
				<div style="display: flex; align-items: center; justify-content: center; margin-top: 20px;">
					<button class="btn btn-primary bg-success" value="Cadastrar" type="button" id="cadastrar">Submit</button>
				</div>
			</form>
		</div>
	</main>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-right: 25vw;">
  <div class="modal-dialog" role="document" style="margin-right: 50%;">
    <div class="modal-content" style="width: 50vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <main class="row" >
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome_cad">Nome:</label>
							<input type="text" class="form-control" placeholder="Digite o nome do cliente"  name="nome_cad" id="nameAtualizar"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="sobrenome">Sobrenome:</label>
							<input type="text" class="form-control" placeholder="Digite o sobrenome do cliente"  name="sobrenome" id="surnameAtualizar"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="email_cad">Email:</label>
							<input type="text" class="form-control" placeholder="Digite o email do cliente"  name="email_cad" id="emailAtualizar" />
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="telefone">Telefone:</label>
							<input type="text" class="form-control" placeholder="Digite o telefone do cliente"  name="telefone" id="telAtualizar"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="residencial">Telefone residencial:</label>
							<input type="text" class="form-control" id="residencialAtualizar"  placeholder="Digite o residencial do cliente"  name="residencial"/>
						</div>
						<div style="margin-top: 20px; display:flex; align-itens: center; justify-content: center; width: 100%;">
							<div class="form-check">
								<input class="form-check-input" type="radio" id="iPersonTypePFAtualizar" name="iPersonType" value="pf" checked>
								<label class="form-check-label" for="iPersonTypePF">
									PF
								</label>
							</div>
							<div class="form-check" style="margin-left: 30px;">
								<input class="form-check-input" type="radio" id="iPersonTypePJAtualizar" name="iPersonType" value="pj" style="margin-left: 10px;">
								<label class="form-check-label" for="iPersonTypePJ">
									PJ
								</label>
							</div>
						</div>
						<div  class="form-group" style="margin-top: 20px;" id="pType">
			                <label for="senha_cad">CPF</label>
                			<input class="form-control" id="cpfAtualizar" name="cpf_cad" required="required" type="text" placeholder="ex. 000.000.000-00"/>
				        </div>           
						<div class="form-group" style="margin-top: 20px;">
							<label for="cep_cad">CEP:</label>
							<input type="number" id="cepAtualizar" class="form-control" placeholder="Digite o cep do cliente"  name="cep_cad"/>
						</div>           
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="rua">Rua:</label>
							<input type="text" id="ruaAtualizar" class="form-control" placeholder="Digite a rua do cliente"  name="rua_cad"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="numero">Número:</label>
							<input type="number" id="numeroAtualizar" class="form-control" placeholder="Digite o numero do cliente"  name="numero"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="bairro">Bairro:</label>
							<input type="text" id="bairroAtualizar" class="form-control" placeholder="Digite o bairro do cliente"  name="bairro"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="cidade">Cidade:</label>
							<input type="text" id="cidadeAtualizar" class="form-control" placeholder="Digite o cidade do cliente"  name="cidade"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="UF">UF:</label>
							<input type="text" id="UFAtualizar" class="form-control" placeholder="Digite o uf do cliente"  name="UF"/>
						</div>
					</div>
				</main>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModal(false)">Fechar</button>
		<button class="btn btn-primary bg-success" onclick="atualizarCliente()" >Atualizar</button>
      </div>
    </div>
  </div>
</div>
<div id='loading'></div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="../../../javascript/jquery.mask.js"></script>
	<script src="../../../javascript/cepFind.js"></script>
	<script src="../../../javascript/btnRegisterClick.js"></script>
	<!--<script type="text/javascript" src="../../../javascript/radiopType.js"></script> -->
	<script src="../javascript/cliente.js"></script>
	<script type="text/javascript">
	var inputs = document.getElementsByName("iPersonType");
	var personType;
	var div = document.getElementById("pType");

	// Initializing variable
	personType = inputs[0].value;

	// PF
	inputs[0].onclick = () => {
		personType = inputs[0].value;
		div.innerHTML = `<p> 
					<label for="senha_cad">Seu CPF</label>
					<br>
					<input class="form-control" id="cpf" name="senha_cad" required="required" type="text" placeholder="ex. 000.000.000-00"/>
				</p>`;
		$("#cpf").mask("000.000.000-00");
	}
	// PJ
	inputs[1].onclick = () => {
		personType = inputs[1].value;
		div.innerHTML = `<p> 
				<label for="email_cad">Sua Inscrição Estadual</label>
				<br>
				<input class="form-control" name="email_cad" required="required" type="email" placeholder="00000000"/> 
			</p>

			<p> 
				<label for="email_cad">Seu CNPJ</label>
				<br>
				<input class="form-control" id="cnpj" name="email_cad" required="required" type="email" placeholder="00.000.00/0000-00"/> 
			</p>

			<p> 
				<label for="email_cad">Razão social</label>
				<br>
				<input class="form-control" name="email_cad" required="required" type="email" placeholder="Exemplo LTD"/> 
			</p>
			`;
		$("#cnpj").mask("00.000.000/0000-00");
	}
		
		
		
	
	</script>
	
	



</html>