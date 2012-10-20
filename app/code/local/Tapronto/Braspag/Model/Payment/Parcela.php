<?php

class Tapronto_Braspag_Model_Payment_Parcela extends Varien_Object
{
    static public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => 'Parcelamento pelo estabelecimento'),
            array('value' => '2', 'label' => 'Parcelamento pelo emissor do cartão'),
        );
    }
}