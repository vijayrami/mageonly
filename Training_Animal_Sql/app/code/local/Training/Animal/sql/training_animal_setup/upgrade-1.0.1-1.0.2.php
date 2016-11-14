<?php
$installer = Mage::getResourceModel ( 'catalog/setup', 'catalog/setup' );

$installer->startSetup ();

// addAttribute uses _prepareValues()
$data = array (
		'label' => 'Script_Generated_MS_Option',
		'type' => 'varchar', // multiselect uses comma sep storage
		'input' => 'multiselect',
		'backend' => 'eav/entity_attribute_backend_array',
		'frontend' => 'training_animal/entity_attribute_frontend_list',
		'required' => 0,
		'user_defined' => 1,
		'group' => 'Prices',
		'unique' => 0, // eav_attribute.is_unique unique value required
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, // catalog_eav_attribute.is_global (products only) scope
		'visible' => 1, // catalog_eav_attribute.is_visible (products only) visible on admin, setting to false stops import of this attribute
		'visible_on_front' => 1, // catalog_eav_attribute.is_visible_on_front (products only) visible on frontend (store) attribute table
		'used_in_product_listing' => 0, // catalog_eav_attribute.used_in_product_listing (products only) made available in product listing
		'searchable' => 0, // catalog_eav_attribute.is_searchable (products only) searchable via basic search
		'visible_in_advanced_search' => 0, // catalog_eav_attribute.is_visible_in_advanced_search (products only) searchable via advanced search
		'filterable' => 0, // catalog_eav_attribute.is_filterable (products only) use in layered nav
		'filterable_in_search' => 0, // catalog_eav_attribute.is_filterable_in_search (products only) use in search results layered nav
		'comparable' => 0, // catalog_eav_attribute.is_comparable (products only) comparable on frontend
		'is_html_allowed_on_front' => 1, // catalog_eav_attribute.is_visible_on_front (products only) seems obvious, but also see visible
		'apply_to' => 'simple,configurable', // catalog_eav_attribute.apply_to (products only) which product types to apply to
		'is_configurable' => 0, // catalog_eav_attribute.is_configurable (products only) used for configurable products or not
		'used_for_sort_by' => 0, // catalog_eav_attribute.used_for_sort_by (products only) available in the 'sort by' menu
		'position' => 0, // catalog_eav_attribute.position (products only) position in layered naviagtion
		'used_for_promo_rules' => 0,
		'option' => array (
				'order' => array (
						'one' => 1,
						'two' => 2,
						'three' => 3 
				),
				'value' => array (
						'one' => array (
								0 => 'Some Label One',
								2 => 'Alt One' 
						),
						'two' => array (
								0 => 'Some Label Two',
								2 => 'Alt Two' 
						),
						'three' => array (
								0 => 'Some Label Three',
								2 => 'Alt Three' 
						) 
						// 2 => ... the store id (eg English, german, etc ..)
								) 
		) 
);

$installer->addAttribute ( 'catalog_product', 'attribute_insalled', $data );
// Done:
$installer->endSetup ();