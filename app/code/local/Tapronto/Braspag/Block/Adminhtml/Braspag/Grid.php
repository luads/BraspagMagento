<?php

class Tapronto_Braspag_Block_Adminhtml_Braspag_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setId('braspagGrid');
        $this->setDefaultSort('order_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('braspag/braspag')->getCollection();
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('order_id', array(
          'header'    => Mage::helper('braspag')->__('Compra'),
          'align'     =>'left',
          'index'     => 'order_id',
        ));

        $this->addColumn('amount', array(
          'header'    => Mage::helper('braspag')->__('Valor'),
          'align'     =>'left',
          'index'     => 'amount',
        ));

        $this->addColumn('number_payments', array(
          'header'    => Mage::helper('braspag')->__('Parcelas'),
          'align'     =>'left',
          'index'     => 'number_payments',
        ));

        $this->addColumn('transaction_id', array(
          'header'    => Mage::helper('braspag')->__('ID da transação'),
          'align'     =>'left',
          'index'     => 'transaction_id',
        ));
        
        $this->addColumn('message', array(
          'header'    => Mage::helper('braspag')->__('Mensagem'),
          'align'     =>'left',
          'index'     => 'message',
        ));
        
        $this->addColumn('status', array(
          'header'    => Mage::helper('braspag')->__('Status'),
          'align'     =>'left',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Mage::getSingleton('braspag/source_status')->getOptionArray()
        ));        
        
        $this->addExportType('*/*/exportCsv', Mage::helper('braspag')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('braspag')->__('XML'));

        return parent::_prepareColumns();
    }
}