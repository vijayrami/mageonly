<?php

class Plumtree_Holiday_Model_Holiday_Productids extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('plumtree_holiday/holiday');
    }
    public function getAllAvailProductIds(){
        $collection = Mage::getResourceModel('catalog/product_collection')
                        ->getAllIds();
        return $collection;
    }
}