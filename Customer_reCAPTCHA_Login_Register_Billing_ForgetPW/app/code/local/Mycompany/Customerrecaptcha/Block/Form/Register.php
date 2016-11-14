<?php

class Mycompany_Customerrecaptcha_Block_Form_Register extends Mage_Customer_Block_Form_Register
{
	const XML_PATH_CRC_ENABLED     = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_enabled';
	const XML_PATH_CRCREG_FRM     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_register';
	const XML_PATH_CRC_PUBLIC_KEY  = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_public_key';
	const XML_PATH_CRC_PRIVATE_KEY = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_private_key';
	const XML_PATH_CRC_THEME       = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_theme';
	const XML_PATH_CRC_LANG        = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_language';
	
    /**
     * Retrieve form data
     *
     * @return Varien_Object
     */
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)) {
            $formData = Mage::getSingleton('customer/session')->getCustomerFormData(true);
            $data = new Varien_Object();
            if ($formData) {
                $data->addData($formData);
                $data->setCustomerData(1);
            }
            if (isset($data['region_id'])) {
                $data['region_id'] = (int)$data['region_id'];
            }
            //if "Customer reCAPTCHA" module is enabled - then we add additional data in array
            if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCREG_FRM))) {
            	//get site key     
            	$siteKey = Mage::getStoreConfig(self::XML_PATH_CRC_PUBLIC_KEY);
            	$data['public_key'] = $siteKey;
            	//get reCaptcha theme name
            	$theme = Mage::getStoreConfig(self::XML_PATH_CRC_THEME);
            	if (strlen($theme) == 0 || !in_array($theme, array('dark', 'light'))) {
            		$theme = 'light';
            	}
            	$data['theme'] = $theme;
            	//get reCaptcha lang name
            	$lang = Mage::getStoreConfig(self::XML_PATH_CRC_LANG);
            	if (strlen($lang) == 0) {
            		$lang = 'en';
            	}
            	$data['lang'] = $lang;
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }
}
