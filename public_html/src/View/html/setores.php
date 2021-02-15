<?php


use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

include '../partial/header.php';
$setor =  isset($_GET["setor"]) ? strip_tags(addslashes(trim($_GET["setor"]))) : "Setor Inexistente";
?>

<div class="txtsetores"><?=$setor?></div>
    <div class='container-fluid container_produto'>
        <?php
            if($setor == "Setor Inexistente"){
            } else {
                $mysql = new MySQLConnection();
                $productDAO = new ProductDAOMySQL($mysql->connect());
                $results = $productDAO->findBySector($setor);

                if($results[0]["name"]){
                    foreach($results as $result){
                        echo "
                            <div class='corpo_produto' style='margin-bottom: 20px;'>
                                <a href='manutencao.html'>
                                    <div class='bloco_produto'>
                                        <img src='../imagens/".$result["productImage"]."'>
                                        <hr>
                                        <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                        <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                        <p class='desc_produto'>".$result["name"]."</p>
                                        <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                    </div>
                                </a>
                            </div>";
                    }
                } else{
                    ?>

                    <div class="container boxCadastro" style="height: 300px; font-weight: bold; margin-top: 5%; margin-bottom: 5%; display: flex; align-items: center;">
                        <h3>No momento não temos produtos nessa categoria, por favor, tente em outra :)</h3>
                    </div>
                   
                    <?php
                }
                

            }
        ?>
    </div>
    <?php

        include '../partial/footer.php';
    
    ?>
    
