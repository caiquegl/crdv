<?php
$ur = "http://www.codestation/public_html/src/html/index.php";
$info = parse_url($ur);
$info["path"]=dirname($info["path"]);

$new_url = $info["scheme"]."://".$info["host"].$info["path"];
if(!empty($info["query"])) $new_url .= "?".$info["query"];
if(!empty($info["fragment"])) $new_url .= "#".$info["fragment"];

use CRDV\Model\UserFunctions\UserSetHeaders;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

include '../partial/header.php';

?>


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img class="d-block w-100" src="../imagens/teste1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
        <img class="d-block w-100" src="../imagens/teste2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
        <img class="d-block w-100" src="../imagens/teste3.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    <div class="container" style="margin-top: 20px;">
        <div class="flex">
            <div class="boxIconMenu shadowP">
                <img src="../imagens/perfume.svg" usemap="#beleza">
                <map name="beleza">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Beleza" coords="511,6,10,509" shape="rect">
                </map>
                <p>Beleza</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/robot.svg" usemap="#brinquedos">
                <map name="brinquedos">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Brinquedos" coords="511,6,10,509" shape="rect">
                </map>
                <p>Brinquedos</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/oven.svg" usemap="#cozinha">
                <map name="cozinha">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Cozinha" coords="511,6,10,509" shape="rect">
                </map>
                <p>Cozinha</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/cpu.svg" usemap="#eletronicos">
                <map name="eletronicos">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Eletrônicos" coords="511,6,10,509" shape="rect">
                </map>
                <p>Eletrônicos</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/lamp.svg" usemap="#energia">
                <map name="energia">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Energia" coords="511,6,10,509" shape="rect">
                </map>
                <p>Energia</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/desktop.svg" usemap="#informa">
                <map name="informa">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Informática" coords="511,6,10,509" shape="rect">
                </map>
                <p>Informática</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/redes.svg" usemap="#net">
                <map name="net">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Redes" coords="511,6,10,509" shape="rect">
                </map>
                <p>Redes</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/mouse.svg" usemap="#perifericos">
                <map name="perifericos">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Periféricos" coords="511,6,10,509" shape="rect">
                </map>
                <p>Periféricos</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/lock.svg" usemap="#seguranca">
                <map name="seguranca">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Segurança" coords="511,6,10,509" shape="rect">
                </map>
                <p>Segurança</p>
            </div>
            <div class="boxIconMenu shadowP">
                <img src="../imagens/phone.svg" usemap="#telefonia">
                <map name="telefonia">
                    <area target="_blank" alt="" title="" href="setores.php?setor=Telefonia" coords="511,6,10,509" shape="rect">
                </map>
                <p>Telefonia</p>
            </div>
        </div>
       
    </div>

<!-- INICIO DOS PRODUTOS -->
    <div class="container-fluid">
        <div class="txtdestaque">Destaque do dia</div>
            <div class="destaques">            
                <div class="container_destaque container-fluidgit">
                <?php
                    $mysql = new MySQLConnection();
                    $productDAO = new ProductDAOMySQL($mysql->connect());
                    $results = $productDAO->findBySector("Lazer");
                    if($results){
                        foreach($results as $result){
                            echo "
                            <div class='corpo_produto' href='compra.php?id=".$result["id"]."'>
                                <a href='compra.php?id=".$result["id"]."'>
                                    <div class='bloco_produto borderHover'>
                                        <img src='../imagens/".$result["productImage"]."'>
                                        <hr>
                                        <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                        <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                        <p class='desc_produto'>".$result["name"]."</p>
                                        <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href=''>Adicionar ao carrinho</a>
                                    </div>
                                </a>
                            </div>
                            ";
                        }
                    }


                ?>
                </div>
            </div>

        <div class="txtdestaque">Outras Recomendações</div>
            
            <div class="container_produto container">
            <?php

                $results = $productDAO->findBySector("Lazer");
                if($results){
                    foreach($results as $result){
                        echo "
                        <div class='corpo_produto'>
                            <a href='compra.php?id=".$result["id"]."'>
                                <div class='bloco_produto borderHover'>
                                    <img src='../imagens/".$result["productImage"]."'>
                                    <hr>
                                    <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                    <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                    <p class='desc_produto'>".$result["name"]."</p>
                                    <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                </div>
                            </a>
                        </div>
                        ";
                    }
                }
                

            ?>
            </div>

        <div class="txtdestaque">Brinquedos</div>
            <div class="container_produto container_brinquedos">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 100%;">
                    <div class="carousel-inner">
                        <div class="carousel-item active"  style="width: 100%; display: flex; justify-content: space-around;">
                            <?php
                                $results = $productDAO->findBySector("Brinquedos");
                                $total = ceil(count($results) / 4);

                                foreach($results as $result){
                                    echo "
                                    <div class='corpo_produto'>
                                        <a href='compra.php?id=".$result["id"]."'>
                                            <div class='bloco_produto borderHover'>
                                                <img src='../imagens/".$result["productImage"]."'>
                                                <hr>
                                                <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                                <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                                <p class='desc_produto'>".$result["name"]."</p>
                                                <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                            </div>
                                        </a>
                                    </div>
                                    ";
                                }                
                            ?>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
            <div class="txtdestaque">Eletrônicos</div>
            <div class="container_produto">
            <?php

                $results = $productDAO->findBySector("Eletrônicos");
                if($results == false) {
                    echo "
                    <div class='corpo_produto'>
                        <a href='compra.php?id=".$result["id"]."'>
                            <p>Nenhum produto encontrado nesse setor</p>
                        </a>
                    </div>
                    ";
                } else {
                    foreach($results as $result){
                        echo "
                        <div class='corpo_produto'>
                            <a href='compra.php?id=".$result["id"]."'>
                                <div class='bloco_produto borderHover'>
                                    <img src='../imagens/".$result["productImage"]."'>
                                    <hr>
                                    <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                    <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                    <p class='desc_produto'>".$result["name"]."</p>
                                    <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                </div>
                            </a>
                        </div>
                        ";
                    }
                }
            ?>
            </div>
            <div class="txtdestaque">Cozinha</div>
            <div class="container_produto">
            <?php
                $results = $productDAO->findBySector("Cozinha");
                if($results == false) {
                    echo "
                    <div class='corpo_produto'>
                        <a href='compra.php?id=".$result["id"]."'>
                            <p>Nenhum produto encontrado nesse setor</p>
                        </a>
                    </div>
                    ";
                } else {
                    foreach($results as $result){
                        echo "
                        <div class='corpo_produto'>
                            <a href='compra.php?id=".$result["id"]."'>
                                <div class='bloco_produto borderHover'>
                                    <img src='../imagens/".$result["productImage"]."'>
                                    <hr>
                                    <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                    <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                    <p class='desc_produto'>".$result["name"]."</p>
                                    <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                </div>
                            </a>
                        </div>
                        ";
                    }
                }
            ?>
            </div>
            <div class="txtdestaque">Informática</div>
            <div class="container_produto">
            <?php
                $results = $productDAO->findBySector("Informática");
                if($results == false) {
                    echo "
                    <div class='corpo_produto'>
                        <a href='compra.php?id=".$result["id"]."'>
                            <p>Nenhum produto encontrado nesse setor</p>
                        </a>
                    </div>
                    ";
                } else {
                    foreach($results as $result){
                        echo "
                        <div class='corpo_produto'>
                            <a href='compra.php?id=".$result["id"]."'>
                                <div class='bloco_produto borderHover'>
                                    <img src='../imagens/".$result["productImage"]."'>
                                    <hr>
                                    <p class='valor_produto'><b>R$ ".$result["price"]."</b></p>
                                    <a class='saiba_mais' href='compra.php?id=".$result["id"]."'>Saiba mais</a>
                                    <p class='desc_produto'>".$result["name"]."</p>
                                    <a class='carrinho-produto' onclick='addItemToCartId(\"".$result["id"]. "\",\"".$result["sku"]. "\",\"".$result["name"]."\",\"".$result["productImage"]."\",\"".$result["price"]."\")' href='#'>Adicionar ao carrinho</a>
                                </div>
                            </a>
                        </div>
                        ";
                    }
                }
            ?>
            </div>
        </div>
    </div>
    
    

    <!-- Scripts -->


    
    <!-- Rodapé -->

<?php

include '../partial/footer.php';

?>