<?php
$msg = "Nenhum produto foi encontrado";
include '../partial/header.php';


if(isset($_GET["query"]) && !empty($_GET["query"])){
    $busca =  strip_tags(addslashes(trim($_GET["query"])));
    $action = "findbyname";
    $url = $_SERVER["HTTP_HOST"] . explode("/src",$_SERVER["SCRIPT_NAME"])[0]."/src/Controller/Product.php";
    $params = array(
        "action" => $action,
        "name" => $busca
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
    ));
    $response = json_decode(curl_exec($ch));
    if(isset($response[0]->error)) {
        $msg = $response[0]->error;
    } else {
        $msg = "";
        $lenght = count($response);
        for($i = 0; $i < $lenght; $i++){
            $product = $response[$i];
            $msg .= "
            <div class='corpo_produto'>
                <a href='manutencao.html'>
                    <div class='bloco_produto borderHover'>
                        <img src='../imagens/".$product->productImage."'>
                        <hr>
                        <p class='valor_produto'><b>R$ ".$product->price."</b></p>
                        <a class='saiba_mais' href='compra.php?id=".$product->id."'>Saiba mais</a>
                        <p class='desc_produto'>".$product->name."</p>
                        <a class='carrinho-produto' onclick='addItemToCartId(\"".$product->id."\",\"".$product->sku."\",\"".$product->name."\",\"".$product->productImage."\",\"".$product->price."\")' href='#'>Adicionar ao carrinho</a>
                    </div>
                </a>
            </div>
            ";
        }
        
    }
}

?>
    <div class="container boxCadastro">
        <?=$msg?>
    </div>
<!-- Scripts -->
<script>
function addItemToCartId(id,sku,pName,pImage,pPrice){
    console.log("chamou")
    function promptSuccess(){
        window.confirm("Produto Adicionado ao Carrinho");
        window.location.href = "index.php";
    }
    var produtos = window.localStorage.cart;
    var item = {
        id:id,
        sku:sku,
        name:pName,
        image:pImage,
        price:pPrice,
        qtd: 1
    };
    if(produtos === undefined || produtos === "undefined"){
        window.localStorage.cart = `[${JSON.stringify(item)}]`;
        promptSuccess();
        window.location.reload();
    } else {
        var carrinho = JSON.parse(window.localStorage.cart);
        let result = carrinho.find( x => x.id === item.id );
        if(result){
            for (let i = 0; i < carrinho.length; i++) {
                if (carrinho[i].id == item.id) {
                    carrinho[i].qtd ++;                    
                }
            }
        }else{
            carrinho.push(item);
        }
        window.localStorage.cart = JSON.stringify(carrinho);
        promptSuccess();
        window.location.reload();
    }
}

</script>

<?php

include '../partial/footer.php';

?>