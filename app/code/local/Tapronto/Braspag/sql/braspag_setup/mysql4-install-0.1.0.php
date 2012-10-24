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

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('braspag')};
CREATE TABLE {$this->getTable('braspag')} (
  `braspag_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(11) unsigned NOT NULL,
  `authorisation` varchar(255) NULL,
  `amount` varchar(20) NOT NULL default '',
  `number_payments` varchar(5) NOT NULL default '',
  `type_payment` varchar(5) NOT NULL default '',
  `transaction_id` varchar(80) NOT NULL default '',
  `message` text NOT NULL default '',
  `return_code` varchar(10) NOT NULL default '',
  `status` varchar(10) NOT NULL default '0',
  `created_at` datetime NULL,
  `update_at` datetime NULL,
  PRIMARY KEY (`braspag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

// campo de parcelas    
$conn = $installer->getConnection();

//verifica se a tabela sales_flat_order_payment existe
$sql = 'SHOW TABLES LIKE "'.$this->getTable('sales_flat_order_payment') . '"';
$row = $conn->fetchRow($sql);

if ($row) 
{
	$conn->addColumn(
		$this->getTable('sales_flat_quote_payment'),
		'cc_parcelamento',
		'varchar(255) NULL DEFAULT NULL'
	);
}

$installer->endSetup();