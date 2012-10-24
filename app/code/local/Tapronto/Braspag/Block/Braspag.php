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
class Tapronto_Braspag_Block_Braspag extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getBraspag()     
     { 
        if (!$this->hasData('braspag')) {
            $this->setData('braspag', Mage::registry('braspag'));
        }
        return $this->getData('braspag');
        
    }
}