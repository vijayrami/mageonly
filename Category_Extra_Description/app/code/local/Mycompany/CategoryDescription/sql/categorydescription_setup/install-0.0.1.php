<?php
$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$installer->startSetup();

//Categories typically only have one attribute set, this will retrieve its ID
$setId = Mage::getSingleton('eav/config')->getEntityType('catalog_category')->getDefaultAttributeSetId();

//Add group to entity & set
$installer->addAttributeGroup('catalog_category',$setId, 'My Extra Tab');

$installer->endSetup();
?>
