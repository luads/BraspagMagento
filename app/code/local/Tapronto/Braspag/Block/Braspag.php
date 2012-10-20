<?php
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