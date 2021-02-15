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
        .imgTable{
            max-width: 200px;
            max-height: 200px;
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
					<h1 style="color: white;">Lista de Banner</h1>
				</div>
			</header>
			<div style="padding-bottom: 20px;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" style="text-align: center;">Foto</th>
							<th scope="col" style="text-align: center;">Descricao</th>
							<th scope="col" style="text-align: center;">Ações</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th style="text-align: center;"><img class="imgTable" src="../../../imagens/CRDV.jpeg" alt=""></th>
							<td>
                                <div style="display: flex; align-items: center;justify-content: center; ;height: 200px;">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, tenetur!
                                </div> 
                            </td>
                            <td>
								<div style="display: flex; justify-content: center; align-items: center; height: 200px;" >
									<button style="border: none;" onclick="abreModal(id)">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
											<path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
										</svg>
									</button>
									<button style="border: none;" onclick="deleteBanner(id)">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
											<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
										</svg>
									</button>
								</div>
							</td>
						</tr>
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
					<h1 style="color: white;margin-left: 15%;">Adicionar banner</h1>
				</div>
			</header>
			<form method="post" action="">
				<main class="row" >
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top: 20px; height: 90%;">
                                <label for=""></label>
                                <input require type="file" id="uploadArquivos" class="form-control"  name="foto" />
                            </div>     
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top: 20px; height: 90%;">
                                <label for="descricao">Descrição:</label>
                                <textarea class="form-control" require id="newDescricao" placeholder="Digite a descrição do produto"  name="descricao" style="width: 90%; height: 90%; max-width: 90%; max-height: 90%; min-height: 90%; min-width: 90%;"></textarea>
                            </div>
                        </div>
				</main>
				<div style="display: flex; align-items: center; justify-content: center; margin-top: 40px;">
					<button class="btn btn-primary bg-success" value="Cadastrar" type="button" id="cadastrar">Cadastrar</button>
				</div>
			</form>
		</div>
	</main>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Banner</h5>
        <button type="button" class="close bgNone" data-dismiss="modal" aria-label="Close" onclick="fechaModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  		<div class="form-group" style="margin-top: 20px; height: 90%;">
                <label for=""></label>
                <input type="file" id="editUpload" class="form-control"  name="foto" />
			</div>
			<div class="form-group" style="margin-top: 20px; height: 90%;">
                <label for="descricao">Descrição:</label>
                <textarea require id="editDescricao" class="form-control" placeholder="Digite a descrição do produto"  name="descricao" style="width: 90%; height: 90%; max-width: 90%; max-height: 90%; min-height: 90%; min-width: 90%;"></textarea>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fechaModal(false)">Fechar</button>
		<button class="btn btn-primary bg-success" value="Cadastrar" type="button" id="atualizar" >Atualizar</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="../javascript/banner.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</html>