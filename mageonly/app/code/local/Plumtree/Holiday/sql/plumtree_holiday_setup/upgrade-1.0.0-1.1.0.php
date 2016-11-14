<?php
 
$installer = $this;
$connection = $installer->getConnection();
 
$installer->startSetup();
 
$installer->getConnection()
    ->addColumn($installer->getTable('plumtree_holiday/holiday'),
    'product_ids',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'default' => null,
        'comment' => 'Associated Products'
    )
);
 
$installer->endSetup();