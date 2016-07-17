<?php
$installer = $this;
$installer->startSetup();
$attribute  = array(
    'type' => 'text',
    'label'=> 'Category Extra Description',
    'input' => 'textarea',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'wysiwyg_enabled' => true,
    'visible_on_front' => true,
    'is_html_allowed_on_front' => true,
    'default' => "",
    'group' => "General Information"
);
$installer->addAttribute('catalog_category', 'extra_description', $attribute);
$installer->endSetup();
?>
