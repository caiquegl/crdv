<?php

namespace CRDV\Model\SendProductFunctions;

require_once dirname(__DIR__,3).'/vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class SendProductAPITest extends TestCase{

    public function assertPreConditions() : void {
        parent::assertTrue(class_exists('CRDV\Model\SendProductFunctions\SendProductAPI'));
    }

    /**
     * Front End -> Controller -> Product.php -> Model -> SendProductFunctions -> SendProductAPI.php
     */
    public function testSendProductAPIPost(){
        $product = new SendProduct();
        $api = new SendProductAPI();
        $params = array(
            'nCdEmpresa' => "",
            'sDsSenha' =>  "",
            'nCdServico' => "04014",
            'sCepOrigem' => "49160000",
            'sCepDestino' => "49170000",
            'nVlPeso' => "1",
            'nCdFormato' => "1",
            'nVlComprimento' => "20",
            'nVlAltura' => "20",
            'nVlLargura' => "20",
            'nVlDiametro' => "20",
            'sCdMaoPropria' => "N",
            'nVlValorDeclarado' => 0,
            'sCdAvisoRecebimento' => "N" 
        );
        foreach($params as $key => $value){
            $product->$key = $value;
        }
        $json = $api->calcPriceDeadlineByPost($product);
        var_dump($json);
        parent::assertIsString($json);
    }
}