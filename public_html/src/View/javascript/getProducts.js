function callback(response){
    produtos = response;
}

function getAllProducts(globalVar){
    $.ajax({
        "url" : "../../Controller/Product.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "selectAllForIndex"
        },
        "success" : function(response){
            callback(response);
        }
    });
}

function getProductByID(id){
    $.ajax({
        "url" : "../../Controller/Product.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "findById",
            "id" : id
        },
        "success" : function(response){
            callback(response);
        }
    });
}

function getProductByName(name){
    $.ajax({
        "url" : "../../Controller/Product.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "findByName",
            "name" : name
        },
        "success" : function(response){
            callback(response);
        }
    });
}

function getProductBySector(sector){
    $.ajax({
        "url" : "../../Controller/Product.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "findBySector",
            "sector" : sector
        },
        "success" : function(response){
            callback(response);
        }
    });
}

function getProductBySKU(sku){
    $.ajax({
        "url" : "../../Controller/Product.php",
        "method" :  "POST",
        "dataType" : "json",
        "data" : {
            "action" : "findBySKU",
            "sku" : sku
        },
        "success" : function(response){
            callback(response);
        }
    });
}