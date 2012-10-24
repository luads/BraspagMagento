<?php

/*
 * This file is part of the Tapronto Braspag module.
 *
 * (c) 2012 Tapronto
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author Luã de Souza <lsouza@tapronto.com.br>
 */
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