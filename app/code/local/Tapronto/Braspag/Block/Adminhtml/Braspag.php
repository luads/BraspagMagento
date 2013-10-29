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