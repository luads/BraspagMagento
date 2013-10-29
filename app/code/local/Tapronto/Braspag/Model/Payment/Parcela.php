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
 * @author Luã de Souza <contato@lsouza.pro.br>
 */
class Tapronto_Braspag_Model_Payment_Parcela extends Varien_Object
{
    static public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => 'Parcelamento pelo estabelecimento'),
            array('value' => '2', 'label' => 'Parcelamento pelo emissor do cartão'),
        );
    }
}