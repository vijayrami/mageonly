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
 * Contact Inquiry Data front contrller
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_ContactinquiryController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_EMAIL_CONFIRM_TEMPLATE  = 'mycompany_mycontact/contactsubscription/confirm_email_template';
	const XML_PATH_EMAIL_SUCCESS_TEMPLATE  = 'mycompany_mycontact/contactsubscription/success_email_template';
	const XML_PATH_EMAIL_RECIPIENT  = 'mycompany_mycontact/contactsubscription/confirm_email_identity';
	const XML_PATH_EMAIL_SENDER     = 'mycompany_mycontact/contactsubscription/success_email_identity';
    /**
      * default action
      *
      * @access public
      * @return void
      * @author Ultimate Module Creator
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('contactinquiry_list')->setFormAction( Mage::getUrl('*/*/post', array('_secure' => $this->getRequest()->isSecure())) );
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('mycompany_mycontact/contactinquiry')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('mycompany_mycontact')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'contactinquiries',
                    array(
                        'label' => Mage::helper('mycompany_mycontact')->__('Contact Inquiry'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('mycompany_mycontact/contactinquiry')->getContactinquiriesUrl());
        }
        $this->renderLayout();
    }
    
    public function postAction()
    {
    	$post = $this->getRequest()->getPost();
    
    	if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
    		
    		$translate = Mage::getSingleton('core/translate');
    		/* @var $translate Mage_Core_Model_Translate */
    		$translate->setTranslateInline(false);
    		
    		$session            = Mage::getSingleton('core/session');
    		$customerSession    = Mage::getSingleton('customer/session');
    		
    		$firstname          = $this->getRequest()->getPost('name');
    		$email              = (string) $this->getRequest()->getPost('email');
    		$telephone          = $this->getRequest()->getPost('mobile');
    		$pincode            = $this->getRequest()->getPost('pincode');
    		$location           = $this->getRequest()->getPost('city');
    
    		try {
    			
    			$postObject = new Varien_Object();
    			$postObject->setData($post);
    			
    			$error = false;
    			
    			if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
    				$error = true;
    			}
    			if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
    				$error = true;
    			}    
    			if (!Zend_Validate::is(trim($post['mobile']) , 'NotEmpty')) {
    				$error = true;
    			}
    			if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
    				$error = true;
    			}
    			
    			if ($error) {
    				throw new Exception();
    			}
    			//Sending E-Mail to Admin.
    			$emailTemplate  = Mage::getModel('core/email_template')->loadDefault('requestinquiry_email_confirm_email_template');			
    			/* @var $mailTemplateAdmin Mage_Core_Model_Email_Template */
    			$mail = Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT);
    			$email_id = Mage::getStoreConfig('trans_email/ident_'.$mail.'/email');
    			$emailTemplate->setDesignConfig(array('area' => 'frontend'))
    			->setReplyTo($post['email'])
    			->sendTransactional(
    					Mage::getStoreConfig(self::XML_PATH_EMAIL_CONFIRM_TEMPLATE),
    					Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
    					$email_id,
    					null,
    					array('data' => $postObject)
    			);
    
    			//Sending E-Mail to Customers.
				$emailTemplateuser = Mage::getModel('core/email_template')->loadDefault('requestinquiry_email_success_email_template');
				/* @var $mailTemplate Mage_Core_Model_Email_Template */
				$emailTemplateuser->setDesignConfig(array('area' => 'frontend'))
				->setReplyTo($post['email'])
				->sendTransactional(
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SUCCESS_TEMPLATE),
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
						$post['email'],
						null,
						array('data' => $postObject)
				);
				
    			
    			if (!$emailTemplate->getSentSuccess() && !$emailTemplateuser->getSentSuccess()) {
    				throw new Exception();
    			}
    				
    			$translate->setTranslateInline(true);
    			
    			$contact = Mage::getModel('mycompany_mycontact/contactinquiry');
    			$contact->setData('name', $firstname);
    			$contact->setData('email', $email);
    			$contact->setData('mobile', $telephone);
    			$contact->setData('city', $location);
    			$contact->setData('pincode', $pincode);
    			$contact->setData('status', 1);
    			$contact->setData('updated_at', $dt);
    			$contact->setData('created_date', $dt);
    			$contact->save();
    			
    			 
    			Mage::getSingleton('customer/session')->addSuccess(Mage::helper('mycompany_mycontact')->__('Your Request has been received. One of our sales representatives will contact you shortly.'));
    			$this->_redirectReferer();
    
    		} catch (Mage_Core_Exception $e) {
    			$session->addException($e, $this->__('There was a problem with sending enquiry mail: %s', $e->getMessage()));
    			$this->_redirectReferer();
    		}
    		catch (Exception $e) {
    			$session->addException($e, $this->__('There was a problem with sending enquiry mail.'));
    			$this->_redirectReferer();
    		}
    
    	} else {
    		$this->_redirect('*/*/');
    	}
    }
}
