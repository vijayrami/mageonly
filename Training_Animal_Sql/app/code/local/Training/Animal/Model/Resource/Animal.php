<?php 
// app/code/local/Training/Animal/Model/Mysql4/Animal.php
class Training_Animal_Model_Resource_Animal extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('training_animal/animal', 'entity_id');
	}
}
