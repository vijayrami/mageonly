<?php
// app/code/local/Vijay/Attribute/Model/Resource/Mytest.php
class Vijay_Attribute_Model_Resource_Mytest extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('vijay_attribute/mytest', 'entity_id');
    }
}