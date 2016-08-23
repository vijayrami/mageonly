<?php
/**
 * Apptha
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.apptha.com/LICENSE.txt
*
* ==============================================================
*                 MAGENTO EDITION USAGE NOTICE
* ==============================================================
* This package designed for Magento COMMUNITY edition
* Apptha does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* Apptha does not provide extension support in case of
* incorrect edition usage.
* ==============================================================
*
* @category    Apptha
* @package     Apptha_Deliveryschedule
* @version     0.1.0
* @author      Apptha Team <developers@contus.in>
* @copyright   Copyright (c) 2015 Apptha. (http://www.apptha.com)
* @license     http://www.apptha.com/LICENSE.txt
*
* */
$installer = $this;

$installer->startSetup();
$installer->run("DROP TABLE IF EXISTS {$this->getTable('deliveryschedule_types')};
        CREATE TABLE {$this->getTable('deliveryschedule_types')} (
        `id` int(11) unsigned NOT NULL auto_increment,
        `store_view` text  NOT NULL default '',
        `name` varchar(255) NOT NULL default '',
        `description` text NOT NULL default '',
        `status` smallint(6) NOT NULL default '0',
        `sorting` smallint(6) NOT NULL default '0',
        `monday` smallint(6) NOT NULL default '1',
        `tuesday` smallint(6) NOT NULL default '1',
        `wednesday` smallint(6) NOT NULL default '1',
        `thursday` smallint(6) NOT NULL default '1',
        `friday` smallint(6) NOT NULL default '1',
        `saturday` smallint(6) NOT NULL default '1',
        `sunday` smallint(6) NOT NULL default '1',
        `created_time` datetime NULL,
        `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("DROP TABLE IF EXISTS {$this->getTable('deliveryschedule')};
CREATE TABLE {$this->getTable('deliveryschedule')} (
  `deliveryschedule_id` int(11) unsigned NOT NULL auto_increment,
  `schedule_type_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `store_view` text  NOT NULL default '',
  `time_slot` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `sorting` smallint(6) NOT NULL default '0',
  `monday` smallint(6) NOT NULL default '0',
  `tuesday` smallint(6) NOT NULL default '0',
  `wednesday` smallint(6) NOT NULL default '0',
  `thursday` smallint(6) NOT NULL default '0',
  `friday` smallint(6) NOT NULL default '0',
  `saturday` smallint(6) NOT NULL default '0',
  `sunday` smallint(6) NOT NULL default '0',
  `monday_cost` varchar(50) NOT NULL default '',
  `tuesday_cost` varchar(50) NOT NULL default '',
  `wednesday_cost` varchar(50) NOT NULL default '',
  `thursday_cost` varchar(50) NOT NULL default '',
  `friday_cost` varchar(50) NOT NULL default '',
  `saturday_cost` varchar(50) NOT NULL default '',
  `sunday_cost` varchar(50) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`deliveryschedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
    
$this->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'shipping_delivery_schedule', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'shipping_delivery_comments', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'shipping_delivery_date', 'date');
$this->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'shipping_delivery_time', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'shipping_delivery_cost', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_order'), 'shipping_delivery_schedule', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_order'), 'shipping_delivery_comments', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_order'), 'shipping_delivery_date', 'date');
$this->getConnection()->addColumn($this->getTable('sales_flat_order'), 'shipping_delivery_time', 'text');
$this->getConnection()->addColumn($this->getTable('sales_flat_order'), 'shipping_delivery_cost', 'text');

$this->getConnection()->addColumn($this->getTable('sales/quote_address'),'delivery_cost', 'DECIMAL( 10, 2 ) NOT NULL');
$this->getConnection()->addColumn($this->getTable('sales/quote_address'),'base_delivery_cost', 'DECIMAL( 10, 2 ) NOT NULL');
$this->getConnection()->addColumn($this->getTable('sales/order'),'delivery_cost', 'DECIMAL( 10, 2 ) NOT NULL');
$this->getConnection()->addColumn($this->getTable('sales/order'),'base_delivery_cost','DECIMAL( 10, 2 ) NOT NULL');


$installer->endSetup(); 