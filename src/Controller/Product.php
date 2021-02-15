<?php
echo "CHAMDO!!";
require_once(dirname(__DIR__,2).'/vendor/autoload.php');

use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\ProductFunctions\ProductDAOMySQL;
use CRDV\Model\ProductFunctions\Product;
use CRDV\Controller\Validations\RequestValidationProduct;
use CRDV\Model\AdminFunctions\Admin;
use CRDV\Model\SendProductFunctions\SendProduct;
use CRDV\Model\SendProductFunctions\SendProductAPI;

header("Content-Type: application/json; charset=utf-8");

$conn = new MySQLConnection();
$productDAO = new ProductDAOMySQL($conn->connect());
$reqValidation = new RequestValidationProduct();

if($reqValidation->validateParam($_POST['action'])){
    $action = strtolower(addslashes(trim($_POST['action'])));
    switch($action)
    {
        case "selectall":
            $reqValidation->validateSelectAll($productDAO);
        break;
        case "selectallforindex":
            $reqValidation->validateSelectAllForIndex($productDAO);
        break;
        case "findbyid":
            $id = addslashes(trim($_POST['id']));
            $reqValidation->validateFindById($productDAO, $id);
        break;
        case "findbyname":
            $name = addslashes(trim($_POST['name']));
            $reqValidation->validateFindByName($productDAO, $name);
        break;
        case "findbysku":
            $sku = addslashes(trim($_POST['sku']));
            $reqValidation->validateFindBySKU($productDAO, $sku);
        break;
        case "findbysector":
            $sector = addslashes(trim($_POST['sector']));
            $reqValidation->validateFindBySector($productDAO, $sector);
        break;
        case "findbymsc":
            $sector = addslashes(trim($_POST['sector']));
            $reqValidation->validateFindByMSC($productDAO, $sector);
        break;
        case "registerproduct":
            $reqParams = array("sku","name", "model", "desc", "price","amount","lastStock","productsInStock","length","heigth","width","diameter");
            
            foreach($reqParams as $param){
                if(!isset($_POST[$param]) OR empty($_POST[$param])) {
                    die(json_encode(array(
                        "error" => "Parâmetro $param inválido."
                    )));
                }
            }
            $image = new Admin();
            $name = $image->addBanner($_FILES);
            $product = new Product();
            $product->sku = addslashes(trim($_POST["sku"]));
            $product->name = addslashes(trim($_POST["name"]));
            $product->model = addslashes(trim($_POST["model"]));
            $product->description = addslashes(trim($_POST["desc"]));
            $product->price =  addslashes(trim($_POST["price"]));
            $product->amount = addslashes(trim($_POST["amount"]));
            $product->lastStock = addslashes(trim($_POST["lastStock"]));
            $product->productImage = addslashes(trim($name));
            $product->productsInStock = addslashes(trim($_POST["productsInStock"]));
            $product->sector = addslashes(trim($_POST["sector"]));
            $product->distributionCenter = addslashes(trim($_POST["distributionCenter"]));
            $product->volumnPrice = addslashes(trim($_POST["volumnPrice"]));
            $product->specifications = addslashes(trim($_POST["specifications"]));
            $product->fabricator = addslashes(trim($_POST["fabricator"]));
            $product->weight = addslashes(trim($_POST["weight"]));
            $product->sendFormat = addslashes(trim($_POST["sendFormat"]));
            $product->length = addslashes(trim($_POST["length"]));
            $product->length = addslashes(trim($_POST["length"]));
            $product->heigth = addslashes(trim($_POST["heigth"]));
            $product->width = addslashes(trim($_POST["width"]));
            $product->diameter = addslashes(trim($_POST["diameter"]));
            $reqValidation->validateRegisterProduct($product, $productDAO);
        break;
        case "updateproduct":
            $reqParams = array("sku","name", "model", "desc", "price","amount","lastStock","productsInStock", "imgName",
           "sector","distributionCenter","volumnPrice","specifications", "fabricator", "weight",
            "sendFormat","length","heigth","width","diameter", "id");
            
            foreach($reqParams as $param){
                if(!isset($_POST[$param]) OR empty($_POST[$param])) {
                    die(json_encode(array(
                        "error" => "Parâmetro $param inválido."
                    )));
                }
            }
            $productId = addslashes(trim($_POST["id"]));
            if(empty($_FILES)) {
                $name = $_POST["imgName"];
            } else {
                $image = new Admin();
                $name = $image->updateBanner(addslashes(trim($_POST["imgName"])),$_FILES);
                if($name == false) {
                    die(json_encode(array("error" => "Não foi possível atualizar a imagem")));
                }
            }
            $product = new Product();
            $product->sku = addslashes(trim($_POST["sku"]));
            $product->name = addslashes(trim($_POST["name"]));
            $product->model = addslashes(trim($_POST["model"]));
            $product->description = addslashes(trim($_POST["desc"]));
            $product->price = addslashes(trim($_POST["price"]));
            $product->amount = addslashes(trim($_POST["amount"]));
            $product->lastStock = addslashes(trim($_POST["lastStock"]));
            $product->productsInStock = addslashes(trim($_POST["productsInStock"]));
            $product->productImage = addslashes(trim($name));
            $product->sector = addslashes(trim($_POST["sector"]));
            $product->distributionCenter = addslashes(trim($_POST["distributionCenter"]));
            $product->volumnPrice = addslashes(trim($_POST["volumnPrice"]));
            $product->specifications = addslashes(trim($_POST["specifications"]));
            $product->fabricator = addslashes(trim($_POST["fabricator"]));
            $product->weight = addslashes(trim($_POST["weight"]));
            $product->sendFormat = addslashes(trim($_POST["sendFormat"]));
            $product->length = addslashes(trim($_POST["length"]));
            $product->length = addslashes(trim($_POST["length"]));
            $product->heigth = addslashes(trim($_POST["heigth"]));
            $product->width = addslashes(trim($_POST["width"]));
            $product->diameter = addslashes(trim($_POST["diameter"]));
            $reqValidation->validateAlterProduct($product, $productDAO, $productId);
            break;
        case "deleteproduct":
            $reqParams = array("id");
            foreach($reqParams as $param){
                if(!isset($_POST[$param]) OR empty($_POST[$param])) {
                    die(json_encode(array(
                        "error" => "Parâmetro $param inválido."
                    )));
                }
            }
            $productId = addslashes(trim($_POST["id"]));
            $reqValidation->validateDelProduct($productDAO, $productId);
        break;
        case "cepbysku":
            $reqParams = array("cepDest", "sku");
            
            foreach($reqParams as $param){
                if(!isset($_POST[$param]) OR empty($_POST[$param])) {
                    die(json_encode(array(
                        "error" => "Parâmetro $param inválido."
                    )));
                }
            }

            $productQuery = $reqValidation->validateReturnFindBySKU($productDAO, $_POST["sku"]);
            if($productQuery === false) {die(json_encode(array("error" => "Nenhum produto encontrado")));}
            //var_dump($productQuery[0]);

            $productCEP = new SendProduct();
            $api = new SendProductAPI();

            $params = array(
                'nCdEmpresa' => "",
                'sDsSenha' =>  "",
                'nCdServico' => "04014",
                'sCepOrigem' => "08550110",
                'sCepDestino' => $_POST["cepDest"],
                'nVlPeso' => $productQuery[0]["weight"],
                'nCdFormato' => $productQuery[0]["sendFormat"],
                'nVlComprimento' => $productQuery[0]["length"],
                'nVlAltura' => $productQuery[0]["heigth"],
                'nVlLargura' => $productQuery[0]["width"],
                'nVlDiametro' => $productQuery[0]["diameter"],
                'sCdMaoPropria' => "N",
                'nVlValorDeclarado' => 0,
                'sCdAvisoRecebimento' => "N" 
            );

            foreach($params as $key => $value){
                $productCEP->$key = $value;
            }
            // var_dump($productCEP);

            $json = $api->calcPriceDeadlineByPost($productCEP);
            echo $json;

        break;
        default:
            echo json_encode($reqValidation->getDefaultErrorMessage());
        break;
    }
}
