<?php 
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('training_animal/animal'), 'trainable', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    	'length' => 1,
    	'unsigned'  => true,
    	'default' => 0,
        'nullable' => false,
    	'after'     => 'edible',
        'comment' => 'trainable'
    ));
$installer->endSetup();