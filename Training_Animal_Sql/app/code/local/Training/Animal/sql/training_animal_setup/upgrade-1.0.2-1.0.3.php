<?php
$installer = Mage::getResourceModel ( 'catalog/setup', 'catalog/setup' );
$installer->startSetup ();
// updateAttributes DOES NOT uses _prepareValues();

$installer->updateAttribute ( 'catalog_product', 'attribute_installed', 'group', 'Prices' );
$installer->endSetup ();