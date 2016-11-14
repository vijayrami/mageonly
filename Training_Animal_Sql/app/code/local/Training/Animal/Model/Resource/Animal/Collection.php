<?php

// app/code/local/Training/Animal/Model/Resource/Animal/Collection.php
class Training_Animal_Model_Resource_Animal_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	protected $_joinedFields = array();
	
	protected function _construct()
	{
		parent::_construct();
		$this->_init('training_animal/animal');
	}
	protected function _toOptionArray($valueField='animal', $labelField='name', $additional=array())
	{
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
	protected function _toOptionHash($valueField='animal', $labelField='name')
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