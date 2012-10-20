<?php

class Tapronto_Braspag_Model_Payment_Service extends Varien_Object
{
    static public function toOptionArray()
    {
        return array(
            array(
            	'value' => 'https://transaction.pagador.com.br/webservices/pagador/Pagador.asmx?WSDL', 
            	'label' => 'Produção'),
            array(
            	'value' => 'https://homologacao.pagador.com.br/webservices/pagador/Pagador.asmx?WSDL', 
            	'label' => 'Homologação'),
        );
    }
}