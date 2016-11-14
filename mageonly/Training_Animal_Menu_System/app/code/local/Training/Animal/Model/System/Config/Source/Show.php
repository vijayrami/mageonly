<?php

class Training_Animal_Model_System_Config_Source_Show {

	public function toOptionArray() {
		return array(
			array('value' => 0, 'label'=>Mage::helper('training_animal')->__('Hide')),
			array('value' => 1, 'label'=>Mage::helper('training_animal')->__('Show')),
		);
	}
}