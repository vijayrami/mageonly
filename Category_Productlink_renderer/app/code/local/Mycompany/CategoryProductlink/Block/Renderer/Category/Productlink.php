<?php

class Mycompany_CategoryProductlink_Block_Renderer_Category_Productlink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	
	public function render(Varien_Object $row)
	{
		$value = $row->getData($this->getColumn()->getIndex());				
	 	$url=Mage::getUrl('*/catalog_product/edit', array('id' =>$value, '_secure'=>true, '_current' => true, '_store'=>Mage::app()->getRequest()->getParam('store')));	 
		$value='<a href="'.$url.'" target="_blank" >Edit</a>';
		return $value;
	}
}