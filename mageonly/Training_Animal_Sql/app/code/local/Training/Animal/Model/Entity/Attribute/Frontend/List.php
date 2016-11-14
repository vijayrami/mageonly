<?php

class Training_Animal_Model_Entity_Attribute_Frontend_List
  extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
  
  public function getValue(Varien_Object $object)
  {
  	$value = $object->getData($this->getAttribute()->getAttributeCode());
  	
  	if ($this->getConfigField('input')=='multiselect') {
  		$value = $this->getOption($value);
  		if (is_array($value)) {
  			$output = '<ul><li>';
        	$output .= implode('</li><li>', $value);
        	$output .= '</li></ul>';
        	return $output;
  		}
  	}
  	return $value;
  }
  
}