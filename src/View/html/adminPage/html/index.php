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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
	<script src="../../../javascript/jquery.mask.js"></script>
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
		.viewInput{
			font-weight: bold;
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
					<h1 style="color: white;">Lista de produtos</h1>
				</div>
			</header>
			<div style="padding-bottom: 20px; max-height: 450px !important; overflow-y: auto; height: 450px !important;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" style="text-align: center; width: 5%">ID</th>
							<th scope="col" style="text-align: center; width: 25%">Nome</th>
							<th scope="col" style="text-align: center; width: 10%">Estoque</th>
							<th scope="col" style="text-align: center; width: 15%">Valor</th>
							<th scope="col" style="text-align: center; width: 15%">Modelo</th>
							<th scope="col" style="text-align: center; width: 35%">Descrição</th>
							<th scope="col" style="text-align: center; width: 35%">Setor</th>
							<th scope="col" style="text-align: center; width: 10%">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php
                			$mysql = new MySQLConnection();
                			$productDAO = new ProductDAOMySQL($mysql->connect());
							$results = $productDAO->selectAll();
                			foreach($results as $result){
                    			echo "
								<tr>
								<th style='text-align: center; width: 5%'>".$result["id"]."</th>
								<td style='text-align: center; width: 25%'>".$result["name"]."</td>
								<td style='text-align: center; width: 10%'>".$result["productsInStock"]."</td>
								<td style='text-align: center; width: 15%'>R$ ".$result["price"]."</td>
								<td style='text-align: center; width: 15%'>".$result["model"]."</td>
								<td style='text-align: center; width: 35%'>".$result["desc"]."</td>
								<td style='text-align: center; width: 15%'>".$result["sector"]."</td>
								<td>
									<div style='display: flex; justify-content: center;' >
										<button style='border: none;' onclick='abreModal(".htmlspecialchars(json_encode($result)).")'>
											<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
												<path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
											</svg>
										</button>
										<button style='border: none;' onclick='deleteProduto(".htmlspecialchars(json_encode($result)).")'>
											<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
												<path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
											</svg>
										</button>
										<button style='border: none;' onclick='visualizar(".htmlspecialchars(json_encode($result)).")'>
											<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
												<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
												<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  		</svg>
										</button>
									</div>
								</td>
							</tr>
                    			";
                			}
    					?>
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
					<h1 style="color: white;margin-left: 15%;">Registrar produto</h1>
				</div>
			</header>
			<form method="POST" id="form_login" >
				<main class="row" >
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Nome:</label>
							<input require require type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do produto" id="nome">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Quantidade:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite a quantidade do produto" id="amount">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Distribuidora:</label>
							<input require type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome da distribuidora" id="distribuidora">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Ultima data de estocagem:</label>
							<input type="text" class="form-control date"  aria-describedby="Nome" placeholder="Digite a ultima data de estocagem"id="lastStock">
						</div>

						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Modelo:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do modelo" id="model">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Preço:</label>
							<input require type="number" class="form-control"  aria-describedby="Nome" placeholder="EX.: 0000.00" id="price">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Produto em estoque:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a quantidade de produto em estoque" id="productsInStock">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Setor:</label>
							<select class="form-select"  aria-describedby="Nome" placeholder="Digite o setor do produto" id="sector">
								<option selected>Selecione um setor</option>
								<option value="Beleza">Beleza</option>
								<option value="Brinquedos">Brinquedos</option>
								<option value="Cozinha">Cozinha</option>
								<option value="Eletrônicos">Eletronicos</option>
								<option value="Energia">Energia</option>
								<option value="Informática">Informatica</option>
								<option value="Redes">Redes</option>
								<option value="Periféricos">Perifericos</option>
								<option value="Segurança">Segurança</option>
								<option value="Telefonia">Beleza</option>
							</select>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Volume:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o volume do produto" id="volumnPrice">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Formato de envio:</label>
							<select id="sendFormat" class="form-select">
								<option value="1">Formato caixa/pacote</option>
								<option value="2">Formato rolo/prisma</option>
								<option value="3">Envelope</option>
							</select>
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Diametro:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o diametro do produto" id="diameter">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Altura:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a altura do produto" id="heigth">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Peso:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o peso do produto" id="weight">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Largura:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a largura do produto" id="width">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Comprimento:</label>
							<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o comprimento do produto" id="length">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Fabricante:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do fabricante" id="fabricator">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Especificação:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite as especificações" id="specifications">
						</div>
						<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Sku:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o sku" id="sku">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px; height: 90%;">
							<label for=""></label>
							<input require type="file" id="fileUpload" class="form-control"  name="foto" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" style="margin-top: 20px; height: 90%;">
							<label for="descricao">Descrição:</label>
							<textarea require class="form-control"  id="desc" placeholder="Digite a descrição do produto"  name="descricao" style="width: 90%; height: 90%; max-width: 90%; max-height: 90%; min-height: 90%; min-width: 90%;"></textarea>
						</div>
					</div>
				</main>
			</form>
			<div style="display: flex; align-items: center; justify-content: center; margin-top: 50px;">
				<button class="btn btn-primary bg-success" value="Cadastrar" type="button" id="cadastrar">Cadastrar</button>
			</div>
		</div>
	</main>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin-right: 50%;">
    <div class="modal-content" style="width: 50vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  		<div class="row">
			  <div class="col-md-6">
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Nome:</label>
						<input require type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do produto" id="nomeEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Quantidade:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o amount do produto" id="amountEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Distribuidora:</label>
						<input require type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome da distribuidora" id="distribuidoraEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Ultima data de estocagem?:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o laststock" id="lastStockEdit">
					</div>

					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Modelo:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do modelo" id="modelEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Preço:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o valor do produto" id="priceEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Produto em estoque:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a quantidade de produto em estoque" id="productsInStockEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Setor:</label>
						<select class="form-select"  aria-describedby="Nome" placeholder="Digite o setor do produto" id="sectorEdit">
							<option selected>Selecione um setor</option>
							<option value="Beleza">Beleza</option>
							<option value="Brinquedos">Brinquedos</option>
							<option value="Cozinha">Cozinha</option>
							<option value="Eletrônicos">Eletronicos</option>
							<option value="Energia">Energia</option>
							<option value="Informática">Informatica</option>
							<option value="Redes">Redes</option>
							<option value="Periféricos">Perifericos</option>
							<option value="Segurança">Segurança</option>
							<option value="Telefonia">Beleza</option>
						</select>
					</div>
					<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Volume:</label>
							<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o volume do produto" id="volumnPriceEdit">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" style="margin-top: 20px;">
							<label for="nome" class="form-label">Formato de envio:</label>
							<select id="sendFormatEdit" class="form-select">
								<option value="1">Formato caixa/pacote</option>
								<option value="2">Formato rolo/prisma</option>
								<option value="3">Envelope</option>
							</select>
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Diametro:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o diametro do produto" id="diameterEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Altura:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a altura do produto" id="heigthEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Peso:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o peso do produto" id="weightEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Largura:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite a largura do produto" id="widthEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Comprimento:</label>
						<input type="number" class="form-control"  aria-describedby="Nome" placeholder="Digite o comprimento do produto" id="lengthEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Fabricador:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o nome do fabricador" id="fabricatorEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Especificação:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite as especificações" id="specificationsEdit">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Sku:</label>
						<input type="text" class="form-control"  aria-describedby="Nome" placeholder="Digite o sku" id="skuEdit">
					</div>
					<div class="form-group" style="margin-top: 20px; height: 90%;">
                		<label for=""></label>
                		<input type="file" id="editUpload" class="form-control"  name="fotoEdit" />
					</div>
				</div>
				<div class="col-md-12" style="margin-bottom: 50px;">
					<div class="form-group" style="margin-top: 20px; height: 90%;">
						<label for="descricao">Descrição:</label>
						<textarea class="form-control"  id="descEdit" placeholder="Digite a descrição do produto"  name="descricao" style="width: 90%; height: 90%; max-width: 90%; max-height: 90%; min-height: 90%; min-width: 90%;"></textarea>
					</div>
				</div>
			</div>
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModal()">Fechar</button>
				<button type="button" class="btn btn-primary bg-success" onclick="atualizarProduto()" >Atualizar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalVisualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin-right: 50%;">
    <div class="modal-content" style="width: 50vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visualizar Produto</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  		<div class="row">
			  	<div class="col-md-12">
					<div id="imgView" style="width: 100%; height: 200px; display: flex; align-itens: center; justify-content: center;">
					</div>			
			  	</div>
			  	<div class="col-md-6">
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Nome:</label>
						<input disabled class="viewInput" id="nomeView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Amount?:</label>
						<input disabled class="viewInput" id="amountView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Distribuidora:</label>
						<input disabled class="viewInput" id="distribuidoraView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Descrição:</label>
						<input disabled class="viewInput" id="descView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Ultima data de estocagem:</label>
						<input disabled class="viewInput" id="lastStockView">
					</div>

					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Modelo:</label>
						<input disabled class="viewInput" id="modelView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Preço:</label>
						<input disabled class="viewInput" id="priceView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Produto em estoque:</label>
						<input disabled class="viewInput" id="productsInStockView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Setor:</label>
						<input disabled class="viewInput" id="sectorView">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Diametro:</label>
						<input disabled class="viewInput" id="diameterView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Altura:</label>
						<input disabled class="viewInput" id="heigthView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Peso:</label>
						<input disabled class="viewInput" id="weightView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Largura:</label>
						<input disabled class="viewInput" id="widthView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Comprimento:</label>
						<input disabled class="viewInput" id="lengthView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Fabricador:</label>
						<input disabled class="viewInput" id="fabricatorView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Especificação:</label>
						<input disabled class="viewInput" id="specificationsView">
					</div>
					<div class="form-group" style="margin-top: 20px;">
						<label for="nome" class="form-label">Sku:</label>
						<input disabled class="viewInput" id="skuView">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="../javascript/produto.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</html>