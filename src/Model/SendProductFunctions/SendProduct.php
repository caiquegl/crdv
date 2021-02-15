<?php

namespace CRDV\Model\SendProductFunctions;

class SendProduct{

    /**
     * Documentation of Correios API
     * @link <https://correios.com.br/enviar-e-receber/ferramentas/calculador-remoto-de-precos-e-prazos/pdf/manual-de-implementacao-do-calculo-remoto-de-precos-e-prazos/view>
     */
    
    private String $nCdEmpresa;
    private String $sDsSenha;
    private String $nCdServico;
    private String $sCepOrigem;
    private String $sCepDestino;
    private String $nVlPeso;
    private String $nCdFormato;
    private String $nVlComprimento;
    private String $nVlAltura;
    private String $nVlLargura;
    private String $nVlDiametro;
    private String $sCdMaoPropria;
    private String $nVlValorDeclarado;
    private String $sCdAvisoRecebimento;

    public function __set($atrib, $value){
        $this->$atrib = $value;
    }

    public function __get($atrib){
        return $this->$atrib;
    }
}