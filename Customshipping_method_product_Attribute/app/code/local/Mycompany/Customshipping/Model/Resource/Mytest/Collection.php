<?php
 
// app/code/local/Mycompany/Customshipping/Model/Resource/Mytest/Collection.php
class Mycompany_Customshipping_Model_Resource_Mytest_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_joinedFields = array();
     
    protected function _construct()
    {
        parent::_construct();
        $this->_init('mycompany_customshipping/mytest');
    }
    protected function _toOptionArray($valueField='mytest', $labelField='name', $additional=array())
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
    protected function _toOptionHash($valueField='mytest', $labelField='name')
    {
        return parent::_toOptionHash($valueField, $labelField);
    }
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}