<?php
// app/code/local/Vijay/Attribute/Model/Mytest.php
class Vijay_Attribute_Model_Mytest extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vijay_attribute/mytest');
    }   
}