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
class Tapronto_Braspag_Model_Mysql4_Braspag extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the braspag_id refers to the key field in your database table.
        $this->_init('braspag/braspag', 'braspag_id');
    }
}