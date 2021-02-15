<?php

namespace CRDV\Model\SendProductFunctions;

use Exception;

class SendProductAPI implements SendProductDAO {

    public String $params;
    public array $headers = array();

    public function jsonify($response) : String{
        try{
            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            return $json;
        } catch (Exception $e){
            return false;
        }
    }

    public function setHeaders(){
        $this->headers = array(
            "Content-Type: application/x-www-form-urlencoded",
        );
    }

    public function setParams($product){
        $params = array(
            'nCdEmpresa' => $product->__get("nCdEmpresa"),
            'sDsSenha' => $product->__get("sDsSenha"),
            'nCdServico' => $product->__get("nCdServico"),
            'sCepOrigem' => $product->__get("sCepOrigem"),
            'sCepDestino' => $product->__get("sCepDestino"),
            'nVlPeso' => $product->__get("nVlPeso"),
            'nCdFormato' => $product->__get("nCdFormato"),
            'nVlComprimento' => $product->__get("nVlComprimento"),
            'nVlAltura' => $product->__get("nVlAltura"),
            'nVlLargura' => $product->__get("nVlLargura"),
            'nVlDiametro' => $product->__get("nVlDiametro"),
            'sCdMaoPropria' => $product->__get("sCdMaoPropria"),
            'nVlValorDeclarado' => $product->__get("nVlValorDeclarado"),
            'sCdAvisoRecebimento' => $product->__get("sCdAvisoRecebimento")
        );
        $this->params = http_build_query($params);
    }

    public function calcPriceDeadlineByPost(SendProduct $product){
        $this->setParams($product);
        $this->setHeaders();
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo";
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers
        );
        $curl = curl_init($url);
        curl_setopt_array($curl, $defaults);
        $result = curl_exec($curl);
        curl_close($curl);
        return $this->jsonify($result);
    }
}