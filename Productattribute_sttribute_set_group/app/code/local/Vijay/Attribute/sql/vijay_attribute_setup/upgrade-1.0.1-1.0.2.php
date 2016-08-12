<?php
$installer = Mage::getResourceModel ( 'catalog/setup', 'catalog/setup' );

$installer->startSetup();



$installer->addAttribute ( 'catalog_product', 'my_test_des', 'is_wysiwyg_enabled', 1 );
$installer->updateAttribute('catalog_product', 'my_test_des', 'is_html_allowed_on_front', 1);
// Done:
$installer->endSetup ();