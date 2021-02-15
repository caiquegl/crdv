<?php

session_start();

require_once( dirname(__DIR__, 5) . "/vendor/autoload.php");

use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

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
	<link rel="shortcut icon" href="../../../imagens/favicon.ico"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
					<h1 style="color: white;">Lista de pedidos</h1>
				</div>
			</header>
			<div style="padding-bottom: 20px;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" style="text-align: center; width: 5%">ID</th>
							<th scope="col" style="text-align: center; width: 25%">Nome</th>
							<th scope="col" style="text-align: center; width: 10%">Qtd.</th>
							<th scope="col" style="text-align: center; width: 15%">Valor</th>
							<th scope="col" style="text-align: center; width: 35%">Comprador</th>
							<th scope="col" style="text-align: center; width: 10%">Ações</th>
						</tr>
					</thead>
					<tbody id="table">

					</tbody>
				</table>
			</div>
		</div>
	</main>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-right: 25vw;">
  <div class="modal-dialog" role="document" style="margin-right: 50%;">
    <div class="modal-content" style="width: 50vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Pedido</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <main class="row" >
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome_cad">Nome:</label>
							<input type="text" class="form-control" placeholder="Digite o nome do produto"  id="nome"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="sobrenome">Quantidade:</label>
							<input type="number" class="form-control" placeholder="Digite a quantidade" id="qtd"/>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="email_cad">Valor:</label>
							<input type="number" class="form-control" placeholder="Digite o valor"  id="valor" />
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="telefone">Observação:</label>
							<input type="text" class="form-control" placeholder="Digite a observação"  id="observacao"/>
						</div>
						
				</main>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModal(false)">Fechar</button>
		<button class="btn btn-primary bg-success" value="Cadastrar" type="button" id="atualizar" >Atualizar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalVisualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin-right: 50%;">
    <div class="modal-content" style="width: 50vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visualizar Pedido</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
	  		<div class="row">
					<div class="col-md-12">
						<h3>
							Comprador
						</h3>
					</div>
			  	<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Nome Comprador:</label>
							<input disabled class="viewInput" id="compradorView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Cpf:</label>
							<input disabled class="viewInput" id="cpfView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Email:</label>
							<input disabled class="viewInput" id="emailView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Telefone residencial:</label>
							<input disabled class="viewInput" id="residencialPhone">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Telefone:</label>
							<input disabled class="viewInput" id="phoneView">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Rua:</label>
							<input disabled class="viewInput" id="ruaView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Bairro:</label>
							<input disabled class="viewInput" id="bairroView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Cep:</label>
							<input disabled class="viewInput" id="cepView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Cidade:</label>
							<input disabled class="viewInput" id="cidadeView">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Numero:</label>
							<input disabled class="viewInput" id="numeroView">
						</div>
					</div>
					<div class="col-md-12">
						<h3>
							Produtos
						</h3>
					</div>
					<div class="col-md-6" id="viewProdutos">
						
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Valor total do pedido:</label>
							<input disabled class="viewInput" id="valorTotalView">
            </div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Valor de envio:</label>
							<input disabled class="viewInput" id="valorEnvioView">
            </div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Forma de pagamento:</label>
							<input disabled class="viewInput" id="formPaymentView">
            </div>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModal()">Fechar</button>
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
	
<script src="../javascript/pedidos.js"></script>




</html>