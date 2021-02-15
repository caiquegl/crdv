function getCart() {
    var cart = window.localStorage.cart;
    if(cart === undefined || cart === "undefined"){
        return cart;
    } else {
        cart = JSON.parse(cart);
        return cart;
    }    
}
function cartDOM(){
    let totalQtdUser = 0;

    var cart = getCart();
    var cartLength;
    if(cart === undefined || cart === "undefined"){
        cartLength = 0;
    } else {
        for (let i = 0; i < cart.length; i++) {
            totalQtdUser += parseInt(cart[i].qtd);             
        }
    }
    document.getElementsByClassName("qtd_compra")[0].innerHTML = `(${totalQtdUser}) item(s)`;
    
}

cartDOM();