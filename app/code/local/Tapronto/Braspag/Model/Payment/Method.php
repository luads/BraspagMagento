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
class Tapronto_Braspag_Model_Payment_Method extends Varien_Object
{
    static public function toOptionArray()
    {
        // TODO: completar lista de metodos de pagamento
        return array(
            array('value' => '18', 'label' => 'American Express (WebPOS – 2 party)'),
            array('value' => '20', 'label' => 'Redecard - Mastercard/Diners/Visa'),
            array('value' => '71', 'label' => 'Cielo Webservice - Visa - Captura Automática'),
            array('value' => '73', 'label' => 'Cielo Webservice - Visa - Preauth'),
            array('value' => '120', 'label' => 'Cielo Webservice - Mastercard - Captura Automática'),
            array('value' => '122', 'label' => 'Cielo Webservice - Mastercard - Preauth'),
        );
    }
}