<?php
class Tapronto_Braspag_Block_Adminhtml_Braspag extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_braspag';
    $this->_blockGroup = 'braspag';
    $this->_headerText = Mage::helper('braspag')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('braspag')->__('Add Item');
    parent::__construct();
  }
}