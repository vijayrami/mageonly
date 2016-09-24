<?php
class Mycompany_CategoryDescription_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCategoryClass() {
		
		$_category  = Mage::registry('current_category');
		if( $_category->getExtraDescription() ){
			return 'category-with-extradescription';
		} else {
			return 'category-without-extradescription';
		}		
	}
}
	 