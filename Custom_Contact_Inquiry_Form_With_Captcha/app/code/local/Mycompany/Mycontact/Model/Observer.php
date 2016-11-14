<?php
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Frontend observer
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Model_Observer
{
    /**
     * add items to main menu
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return array()
     * @author Ultimate Module Creator
     */
    public function addItemsToTopmenuItems($observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $action = Mage::app()->getFrontController()->getAction()->getFullActionName();
        $contactinquiryNodeId = 'contactinquiry';
        $data = array(
            'name' => Mage::helper('mycompany_mycontact')->__('Contact Inquiry'),
            'id' => $contactinquiryNodeId,
            'url' => Mage::helper('mycompany_mycontact/contactinquiry')->getContactinquiriesUrl(),
            'is_active' => ($action == 'mycompany_mycontact_contactinquiry_index' || $action == 'mycompany_mycontact_contactinquiry_view')
        );
        $contactinquiryNode = new Varien_Data_Tree_Node($data, 'id', $tree, $menu);
        $menu->addChild($contactinquiryNode);
        return $this;
    }
    public function checkContacts($observer){
    	$formId = 'mycompany_mycontact';
    	$captchaModel = Mage::helper('captcha')->getCaptcha($formId);
    	if ($captchaModel->isRequired()) {
    		$controller = $observer->getControllerAction();
    		$word = $this->_getCaptchaString($controller->getRequest(), $formId);
    		if (!$captchaModel->isCorrect($word)) {
    			Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
    			$controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
    			$url =  Mage::getUrl('mycompany_mycontact');
    			$controller->getResponse()->setRedirect($url);
    		}
    	}
    	return $this;
    }
}
