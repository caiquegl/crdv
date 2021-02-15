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