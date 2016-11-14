<?php
// app/code/local/Vijay/Attribute/Model/Entity/Attribute/Frontend/List.php
class Vijay_Attribute_Model_Entity_Attribute_Frontend_List
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
      } else if ($this->getConfigField('input')=='text') {
          $value = $this->getOption($value);
          if (is_array($value)) {
            $output = '<ul><li>';
            $output .= '</li>'.$value.'<li>';
            $output .= '</li></ul>';
            return $output;
          }
      }
      return $value;
  }
   
}