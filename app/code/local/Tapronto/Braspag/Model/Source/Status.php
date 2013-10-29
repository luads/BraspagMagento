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