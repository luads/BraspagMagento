<?php

class Tapronto_Braspag_Model_Braspag extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('braspag/braspag');
    }
}