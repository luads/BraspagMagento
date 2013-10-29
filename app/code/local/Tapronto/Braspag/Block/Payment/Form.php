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
class Tapronto_Braspag_Block_Payment_Form extends Mage_Payment_Block_Form_Cc
{
    protected function _construct()
    {
        parent::_construct();
        
        $this->setTemplate('braspag/form/payment.phtml');
    }
}