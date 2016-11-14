<?php
class Training_Animal_Adminhtml_AnimalController extends Mage_Adminhtml_Controller_Action
{
  public function indexAction() {
  	$this->loadLayout();
  	$this->_title(Mage::helper('training_animal')->__('Manage Animals'))
  	->_title(Mage::helper('training_animal')->__('Stalls'));
  	$this->renderLayout();
  }
  
  protected function _isAllowed()
  {
  	return Mage::getSingleton('admin/session')->isAllowed('training_animal/stall');
  }
}