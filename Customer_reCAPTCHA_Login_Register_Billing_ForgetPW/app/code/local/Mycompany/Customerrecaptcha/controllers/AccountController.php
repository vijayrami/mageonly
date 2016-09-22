<?php
//include controller to override it
require_once 'Mage/Customer/controllers/AccountController.php';
class Mycompany_Customerrecaptcha_AccountController extends Mage_Customer_AccountController
{
    /**
     * Create customer account action
     */
	const XML_PATH_CRC_ENABLED     = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_enabled';
	const XML_PATH_CRCLOGIN_FRM     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_login';
	const XML_PATH_CRCFRG_FRM     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_forgotpwd';
	const XML_PATH_CRCREG_FRM     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_register';
	const XML_PATH_CRC_PRIVATE_KEY = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_private_key';
	
    public function createPostAction()
    {    	
    	if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCREG_FRM))) {
    		try {
    			$post = $this->getRequest()->getPost();    			
    			if ($post) {
    				if ((!isset($post['g-recaptcha-response']))
    				|| (!$this->_isCaptchaValid($post['g-recaptcha-response']))
    				) {
    					throw new Exception(
    							$this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again."),
    							1
    					);
    				}    				
    			} else {
    				throw new Exception('', 1);
    			}
    		} catch (Exception $e) {
    			if (strlen($e->getMessage()) > 0) {
    				Mage::getSingleton('customer/session')->addError($this->__($e->getMessage()));    				
    			}    			
    			$this->_getSession()->setCustomerFormData($this->getRequest()->getPost());
    			$this->_redirect('*/*/create');
    			return;
    		}
    	}
    	
    	//everything is OK - call parent action
    	parent::createPostAction();
    }
    
    /**
     * Login post action
     */
    public function loginPostAction()
    {
    	$checkloginpage = $this->getRequest()->getPost();
    	if ($checkloginpage['context']){
    		$checkpage = ($checkloginpage['context'] == 'checkout') ? 'checkoutlogin' : '';
    	} else {
    		$checkpage = 'customerlogin';
    	}
    	
    	if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCLOGIN_FRM))) {
    		try {
    			$login = $this->getRequest()->getPost();    			
    			$loginformData = new Varien_Object();
    			$loginformData->setData($login);
    			Mage::getSingleton('core/session')->setData('loginForm', $loginformData);
    			if ($login) {
    				if ((!isset($login['g-recaptcha-response']))
    				|| (!$this->_isCaptchaValid($login['g-recaptcha-response']))
    				) {
    					throw new Exception(
    							$this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again."),
    							1
    					);
    				}
    				Mage::getSingleton('core/session')->unsetData('loginForm');
    			} else {
    				throw new Exception('', 1);
    			}
    		} catch (Exception $e) {
    			if (strlen($e->getMessage()) > 0) {
    				Mage::getSingleton('customer/session')->addError($this->__($e->getMessage()));
    			}    		
    			if ($checkpage == 'customerlogin'){
    				$this->_redirect('*/*/');
    			} else {
    				$this->_redirect('checkout/onepage/index');
    			}    			
    			return;
    		}
    	}
    	 
    	//everything is OK - call parent action
    	parent::loginPostAction();
    }
    
    /**
     * Forgot customer password action
     */
    public function forgotPasswordPostAction()
    {
    	if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCFRG_FRM))) {
    		try {
    			$frgtpwd = $this->getRequest()->getPost();
    			$frgtpwdData = new Varien_Object();
    			$frgtpwdData->setData($frgtpwd);
    			Mage::getSingleton('core/session')->setData('frgtpwdForm', $frgtpwdData);
    			if ($frgtpwd) {
    				if ((!isset($frgtpwd['g-recaptcha-response']))
    				|| (!$this->_isCaptchaValid($frgtpwd['g-recaptcha-response']))
    				) {
    					throw new Exception(
    							$this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again."),
    							1
    					);
    				}
    				Mage::getSingleton('core/session')->unsetData('frgtpwdForm');
    			} else {
    				throw new Exception('', 1);
    			}
    		} catch (Exception $e) {
    			if (strlen($e->getMessage()) > 0) {
    				Mage::getSingleton('customer/session')->addError($this->__($e->getMessage()));
    			}
    			$this->_redirect('*/*/forgotPassword');
    			return;
    		}
    	}
    	//everything is OK - call parent action
    	parent::forgotPasswordPostAction();
    }
    /**
     * Check if captcha is valid
     * @param  string $captchaResponse
     * @return boolean
     */
    protected function _isCaptchaValid($captchaResponse)
    {
    	$result = false;
    
    	$params = array(
    			'secret' => Mage::getStoreConfig(self::XML_PATH_CRC_PRIVATE_KEY),
    			'response' => $captchaResponse
    	);
    
    	$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    	curl_setopt($ch, CURLOPT_VERBOSE, 1);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    	$requestResult = trim(curl_exec($ch));
    	curl_close($ch);
    
    	if (is_array(json_decode($requestResult, true))) {
    		$response = json_decode($requestResult, true);
    
    		if (isset($response['success']) && $response['success'] === true) {
    			$result = true;
    		}
    	}
    
    	return $result;
    }
}
