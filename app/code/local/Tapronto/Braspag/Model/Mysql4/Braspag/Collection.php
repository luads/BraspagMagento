<?php

class Tapronto_Braspag_Model_Mysql4_Braspag_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('braspag/braspag');
    }
}