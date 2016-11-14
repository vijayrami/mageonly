<?php

class Mycompany_Customerrecaptcha_Block_Account_Forgotpassword extends Mage_Customer_Block_Account_Forgotpassword
{
	const XML_PATH_CRC_ENABLED     = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_enabled';
	const XML_PATH_CRCFRG_FRM     = 'customer/Customerrecaptcha_Forms/customerrecaptcha_forgotpwd';
	const XML_PATH_CRC_PUBLIC_KEY  = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_public_key';
	const XML_PATH_CRC_PRIVATE_KEY = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_private_key';
	const XML_PATH_CRC_THEME       = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_theme';
	const XML_PATH_CRC_LANG        = 'customer/Mycompany_Customerrecaptcha/customerrecaptcha_language';
	
	
	/**
	 * Retrieve reCAPTCHA site key
	 *
	 * @return string
	 */
	public function getSitekey()
	{
		if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCFRG_FRM))) {
			//get site key
			$siteKey = Mage::getStoreConfig(self::XML_PATH_CRC_PUBLIC_KEY);
		}
		return $siteKey;
	}
	
	/**
	 * Retrieve reCAPTCHA theme
	 *
	 * @return string
	 */
	public function getTheme()
	{
		if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCFRG_FRM))) {
			//get reCaptcha theme name
			$theme = Mage::getStoreConfig(self::XML_PATH_CRC_THEME);
			if (strlen($theme) == 0 || !in_array($theme, array('dark', 'light'))) {
				$theme = 'light';
			}
		}
		return $theme;
	}
	
	/**
	 * Retrieve reCAPTCHA lang
	 *
	 * @return string
	 */
	public function getLang()
	{
		if ((Mage::getStoreConfigFlag(self::XML_PATH_CRC_ENABLED)) && (Mage::getStoreConfigFlag(self::XML_PATH_CRCFRG_FRM))) {
			//get reCaptcha lang name
			$lang = Mage::getStoreConfig(self::XML_PATH_CRC_LANG);
			if (strlen($lang) == 0) {
				$lang = 'en';
			}
		}
		return $lang;
	}

}
