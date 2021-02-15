
<?php

use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;

include '../partial/header.php';

$mysql = new MySQLConnection();
$productDAO = new ProductDAOMySQL($mysql->connect());
$results = $productDAO->findById(addslashes(trim($_GET["id"])));
if($results == false) {
    die(json_encode(array("error"=>"Nenhum produto encontrado")));
}
?>
<script src="../javascript/addItemToCart.js"></script>
    <div id="fundo_corpo">

        <div id="produto">
            <img id="img_produto" src="../imagens/<?=$results[0]["productImage"]?>">
            <div id="desc_produto">
                <h1 style="font-size: 30px; margin-top: 15%; color: black;"><?=$results[0]["name"]?></h1>
                <br>

                <h2 style="font-size: 40px; font-weight: bold; color: #353535; margin-top: -4%;
                margin-bottom: 7%;">R$ <?=$results[0]["price"]?></h2>

                <!-- <h3 style="margin-top: -6%;">Em até <b style="color: #8b7500;">12x de R$ 2.167,00 sem juros!</b></h3> -->

                <p style="margin-top: -2%;"><a style="text-decoration: none; color: darkviolet;" href="#my-footer">Clique aqui para ver os meios de pagamento</a></p>

                <div id="frete">
                    <img id="frete_icon" src="../imagens/frete1.png">
                    <input type="text" class="form-control" id="cepFrete" aria-describedby="emailHelp" style="font-size: 17px; padding-left: 10px; width: 200px; height: 40px; margin-left: 20px; margin-right: 20px;">
                    <p><button id="consultar_frete" onclick='calcFrete("<?=$results[0]["sku"]?>")' style="cursor: pointer;">Clique aqui para consultar o frete</button></p>
                </div>
                <div id="valorFrete">
                </div>
                <button id="comprar" onclick='addItemToCartId("<?=$results[0]["id"]?>","<?=$results[0]["sku"]?>","<?=$results[0]["name"]?>","<?=$results[0]["productImage"]?>","<?=$results[0]["price"]?>")' style="cursor:pointer;">Adicionar ao Carrinho</button> 
            </div>

        </div>


        <div id="info_produto">
            <h4 id="desc" style=>Descrição</h4>
            <p id="caract_produto">
                <?=$results[0]["desc"]?>
                <!-- <b>Marca:</b> Apple<br>
                <b>Linha:</b> iMac<br>
                <b>Modelo:</b> 2020<br>
                <b>Cor:</b> Cinza<br>
                <b>Processador:</b> Intel Core i9<br>
                <b>Memória RAM:</b> 128 GB<br>
                <b>Capacidade do SSD:</b> 1 TB<br>
                <b>Resolução da tela:</b> 5120 px x 2880 px<br>
                <b>GPU:</b> AMD Radeon Pro 5500 XT 8 GB<br>
                <b>Tamanho da tela:</b> 27"<br>
                <b>Tipo de tela:</b> LED<br>
                <b>Nome do sistema operacional:</b> macOS<br>
                <b>Versão do sistema operacional:</b> Big Sur<br>
                <b>Edição do sistema operacional:</b> MacOS Big Sur<br>
                <b>Com Bluetooth:</b> Sim<br>
                <b>Velocidade do processador:</b> 3.6 GHz<br></p> -->
                </p>
            <h4 id="desc">Modelo</h4>
            <p id="caract_produto"><?=$results[0]["model"]?></p>
            <h4 id="desc">Setor</h4>
            <p id="caract_produto"><?=$results[0]["sector"]?></p>
            <h4 id="desc">CD</h4>
            <p id="caract_produto"><?=$results[0]["cd"]?></p>
            <h4 id="desc">Preço por Volume</h4>
            <p id="caract_produto"><?=$results[0]["volumnPrice"]?></p>
            <h4 id="desc">Especificações</h4>
            <p id="caract_produto"><?=$results[0]["specifications"]?></p>
            <h4 id="desc">Fabricante</h4>
            <p id="caract_produto"><?=$results[0]["fabricator"]?></p>
        </div>
    </div>





    <div id='loading'></div>

        

    <!-- Rodapé -->

    <?php

include '../partial/footer.php';


?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/getCart.js"></script>
    <script>
        async function calcFrete(a) {
            console.log("chamou")
    document.getElementById("loading").innerHTML = `
    <div class="loader">
        <h1>Carregando...</h1>
    </div>
`;
    let dataCalCep = {
        action: 'cepbysku',
        nCdEmpresa: "",
        sDsSenha:  "",
        nCdServico: "04014",
        sCepOrigem: "08550110",
        cepDest: $("#cepFrete")[0].value,
        sku: a,
        nVlPeso: 1,
        nCdFormato: 1,
        nVlComprimento: 20,
        nVlAltura: 20,
        nVlLargura: 20,
        nVlDiametro: 20,
        sCdMaoPropria: "N",
        nVlValorDeclarado: 0,
        sCdAvisoRecebimento: "N" 
    }

    $.ajax({
        url: '../../Controller/Product.php',
        data: dataCalCep,
        type: 'post',
        success:  function(data){
            document.getElementById("loading").remove()
            console.log(data.Servicos)
            var valueFrete = document.getElementById("valorFrete");
            let frete = parseFloat(data.Servicos.cServico.Valor);
            let prazo = data.Servicos.cServico.PrazoEntrega;
            valueFrete.innerHTML = `
            <p style="font-size: 15px;"><b>Valor do frete:</b> R$ ${frete}</p>
            <p style="font-size: 15px;"><b>Prazo de entrega:</b> ${prazo}</p>
            `

        },
    });
    
}
    </script>
</body>

</html>