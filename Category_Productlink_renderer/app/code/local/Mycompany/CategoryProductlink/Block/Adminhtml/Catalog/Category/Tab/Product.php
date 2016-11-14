<?php

class Mycompany_CategoryProductlink_Block_Adminhtml_Catalog_Category_Tab_Product extends Mage_Adminhtml_Block_Catalog_Category_Tab_Product {

	protected function _prepareColumns()
	{
		parent::_prepareColumns();
		$this->addColumn('edit', array(
				'header'    => Mage::helper('catalog')->__('Action'),
				'width'     => '80',
				'filter' 	=>false,
				'sortable'  => false,
				'index' =>'entity_id',
				'renderer'  => 'categoryproductlink/renderer_category_productlink'
		));

	}
}