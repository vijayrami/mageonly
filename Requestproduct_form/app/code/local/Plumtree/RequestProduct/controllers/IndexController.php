<?php 
class Plumtree_RequestProduct_IndexController extends Mage_Core_Controller_Front_Action {
	
	const XML_PATH_EMAIL_CONFIRM_TEMPLATE  = 'requestproduct/subscription/confirm_email_template';
	const XML_PATH_EMAIL_SUCCESS_TEMPLATE  = 'requestproduct/subscription/success_email_template';
	const XML_PATH_EMAIL_RECIPIENT  = 'requestproduct/subscription/confirm_email_identity';
	const XML_PATH_EMAIL_SENDER     = 'requestproduct/subscription/success_email_identity';
	
	public function indexAction(){		
		$this->loadLayout();
		$this->getLayout()->getBlock('requestProductForm')->setFormAction(Mage::getUrl('*/*/sendemail', array('_secure' => $this->getRequest()->isSecure())));
		$this->_initLayoutMessages('customer/session');
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();		
	}
	
	public function sendemailAction(){
		//Fetch submited params
		$post = $this->getRequest()->getPost();
						
		if ( $post ) {
			$translate = Mage::getSingleton('core/translate');
			/* @var $translate Mage_Core_Model_Translate */
			$translate->setTranslateInline(false);
			try {
				$postObject = new Varien_Object();
				$postObject->setData($post);
			
				$error = false;
			
				if (!Zend_Validate::is(trim($post['firstname']) , 'NotEmpty')) {
					$error = true;
				}
				if (!Zend_Validate::is(trim($post['lastname']) , 'NotEmpty')) {
					$error = true;
				}
			
				if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
					$error = true;
				}
			
				if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
					$error = true;
				}
			
				if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
					$error = true;
				}
				
				if ($error) {
					throw new Exception();
				}
				
				//Sending E-Mail to Customers.
				$mailTemplate = Mage::getModel('core/email_template')->loadDefault('requestproduct_subscription_success_email_template');
				/* @var $mailTemplate Mage_Core_Model_Email_Template */
				$mailTemplate->setDesignConfig(array('area' => 'frontend'))
				->setReplyTo($post['email'])
				->sendTransactional(
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SUCCESS_TEMPLATE),
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
						$post['email'],
						null,
						array('data' => $postObject)
				);
				
				//Sending E-Mail to Admin.
				$mailTemplateAdmin = Mage::getModel('core/email_template')->loadDefault('requestproduct_subscription_confirm_email_template');
				/* @var $mailTemplateAdmin Mage_Core_Model_Email_Template */
				$mail = Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT);
				$email_id = Mage::getStoreConfig('trans_email/ident_'.$mail.'/email');
				$mailTemplateAdmin->setDesignConfig(array('area' => 'frontend'))
				->setReplyTo($post['email'])
				->sendTransactional(
						Mage::getStoreConfig(self::XML_PATH_EMAIL_CONFIRM_TEMPLATE),
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
						$email_id,
						null,
						array('data' => $postObject)
				);
				if (!$mailTemplate->getSentSuccess() && !$mailTemplateAdmin->getSentSuccess()) {
					throw new Exception();
				}
			
				$translate->setTranslateInline(true);
			
				Mage::getSingleton('customer/session')->addSuccess(Mage::helper('requestproduct')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
				$this->_redirect('request-a-product');
			
				return;
			} catch (Exception $e) {
				$translate->setTranslateInline(true);
			
				Mage::getSingleton('customer/session')->addError(Mage::helper('requestproduct')->__('Unable to submit your request. Please, try again later'));
				$this->_redirect('request-a-product');
				return;
			}
		}else {
            $this->_redirect('request-a-product');
        }
	}
}
