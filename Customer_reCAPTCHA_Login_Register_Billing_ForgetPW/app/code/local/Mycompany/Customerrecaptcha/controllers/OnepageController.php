<?php
//include controller to override it
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Mycompany_Customerrecaptcha_OnepageController extends Mage_Checkout_OnepageController
{
	const XML_PATH_CRC_ENABLED     = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_enabled';
	const XML_PATH_OPCBILLREG_ENABLED     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_billing';
	const XML_PATH_CRC_PRIVATE_KEY = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_private_key';
    /**
     * Save checkout billing address
     */
    public function saveBillingAction()
    {
    	$getSession =Mage::getSingleton('core/session')->getMyValue();
    	if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_OPCBILLREG_ENABLED)) && (!$getSession)) {
    		try {
    			$post = $this->getRequest()->getPost();
    			if ($post) {
    				//validate captcha
    				if (!isset($post['g-recaptcha-response']) || !$this->_isreCaptchaValid($post['g-recaptcha-response'])) {
    					throw new Exception();
    				}
    			}
    			else {
    				throw new Exception('', 1);
    			}
    		}
    		catch (Exception $e) {
    			$result['error'] = -1;
    			$result['message'] = $this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
    			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    			return;
    		}
    	}
    	//everything is OK - call parent action
    	$myValue = 'captchaok';
    	Mage::getSingleton('core/session')->setMyValue($myValue);
    	parent::saveBillingAction();    	
    }
    
    /**
     * Check if captcha is valid
     * @param  string $captchaResponse
     * @return boolean
     */
    protected function _isreCaptchaValid($captchaResponse)
    {
    	if ($this->_expireAjax()) {
    		return;
    	}
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
