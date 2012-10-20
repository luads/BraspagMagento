<?php

class Tapronto_Braspag_Model_Source_Status extends Varien_Object
{
    static public function getOptionArray()
    {
        return array(
            0 => 'Pedido capturado', 
            1 => 'Pedido autorizado e aguarda captura', 
            2 => 'Pedido negado', 
            8 => 'Dados do AVS não conferem', 
            12 => 'Pedido com o mesmo número já existe', 
            13 => 'Pedido com o mesmo número já foi autorizado', 
            '' => 'Erro interno',
        );
    }
}