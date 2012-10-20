<?php

class Tapronto_Braspag_Model_Mysql4_Braspag extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the braspag_id refers to the key field in your database table.
        $this->_init('braspag/braspag', 'braspag_id');
    }
}