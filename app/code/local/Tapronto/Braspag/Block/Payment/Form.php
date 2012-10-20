<?php

class Tapronto_Braspag_Block_Payment_Form extends Mage_Payment_Block_Form_Cc
{
    protected function _construct()
    {
        parent::_construct();
        
        $this->setTemplate('braspag/form/payment.phtml');
    }
}