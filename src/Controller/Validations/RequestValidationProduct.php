<?php

namespace CRDV\Controller\Validations;

use CRDV\Model\ProductFunctions\ProductDAO;
use CRDV\Model\ProductFunctions\Product;
use Exception;

class RequestValidationProduct {

    private array $actionUndefinedErrorMessage = array("error" => "Nenhuma requisição foi informada.");
    private array $defaultErrorMessage = array("error" => "Não foi possível realizar a requisição.");
    private array $findByIdErrorMessage = array("error" => "Nenhum produto com o ID informado foi encontrado.");
    private array $findByMSCErrorMessage = array("error" => "Nenhum produto pertencente à esse setor foi encontrado.");
    private array $findByNameErrorMessage = array("error" => "Nenhum produto com esse nome foi encontrado");
    private array $findBySectorErrorMessage = array("error" => "Nenhum produto encontrado no setor");
    private array $findBySkuErrorMessage = array("error" => "Nenhum produto com esse SKU foi encontrado.");
    private array $selectAllErrorMessage = array("error" => "Nenhum produto foi encontrado.");
    private array $cannotRegisterProductErrorMessage = array("error" => "Não foi possível cadastrar o produto.");

    public function validateParam($input){
        if(isset($input) && !empty($input)): return true;
        else: http_response_code(200); echo json_encode($this->actionUndefinedErrorMessage);
        endif;
    }

    public function validateSelectAll(ProductDAO $products){
        $result = $products->selectAll();
        if(gettype($result) === "array"): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->selectAllErrorMessage);
        endif;
    }

    public function validateSelectAllForIndex(ProductDAO $products){
        $result = $products->selectAllForIndex();
        if(gettype($result) === "array"): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->selectAllErrorMessage);
        endif;
    }

    public function validateFindById(ProductDAO $products, Int $id){
        $result = $products->findById($id);
        if(gettype($result) === 'array'): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->findByIdErrorMessage);
        endif;
    }

    public function validateFindByName(ProductDAO $products, String $name){
        $result = $products->findByName($name);
        if(gettype($result) === 'array'): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->findByNameErrorMessage);
        endif;
    }

    public function validateFindBySKU(ProductDAO $products, String $sku){
        $result = $products->findBySKU($sku);
        if(gettype($result) === 'array'): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->findBySkuErrorMessage);
        endif;
    }

    public function validateReturnFindBySKU(ProductDAO $products, String $sku){
        $result = $products->findBySKU($sku);
        if(gettype($result) === 'array'): return $result;
        else: http_response_code(200); return false;
        endif;
    }

    public function validateFindByMSC(ProductDAO $products, String $sector){
        $result = $products->findByMSC($sector);
        if(gettype($result) === 'array'): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->findByMSCErrorMessage);
        endif;
    }

    public function validateFindBySector(ProductDAO $products, String $sector){
        $result = $products->findBySector($sector);
        if(gettype($result) === 'array'): echo json_encode($result);
        else: http_response_code(200); echo json_encode($this->findBySectorErrorMessage);
        endif;
    }

    public function validateRegisterProduct(Product $product, ProductDAO $con){
        try {
            $result = $con->registerProduct($product);
            echo json_encode($result);
        } catch (Exception $e) {
            echo \json_encode(array("error" => $e->getMessage()));
        }
    }

    public function validateAlterProduct(Product $product, ProductDAO $con, Int $id){
        try {
            $result = $con->alterProduct($product, $id);
            echo json_encode($result);
        } catch (Exception $e) {
            echo \json_encode(array("error" => $e->getMessage()));
        }
    }

    public function validateDelProduct(ProductDAO $con, Int $id) {
        try {
            $result = $con->removeProduct($id);
            echo json_encode($result);
        } catch (Exception $e) {
            echo \json_encode(array("error" => $e->getMessage()));
        }
    }
    public function getDefaultErrorMessage(){
        http_response_code(200);
        return json_encode($this->defaultErrorMessage);
    }
}
