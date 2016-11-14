<?php

class Mycompany_Productreviewrecaptcha_Block_Form extends Mage_Review_Block_Form {
    const XML_PATH_PRC_ENABLED     = 'catalog/review/mycompany_productreviewrecaptcha_enabled';
    const XML_PATH_PRC_PUBLIC_KEY  = 'catalog/review/mycompany_productreviewrecaptcha_public_key';
    const XML_PATH_PRC_PRIVATE_KEY = 'catalog/review/mycompany_productreviewrecaptcha_private_key';
    const XML_PATH_PRC_THEME       = 'catalog/review/mycompany_productreviewrecaptcha_theme';
    const XML_PATH_PRC_LANG        = 'catalog/review/mycompany_productreviewrecaptcha_lang';

    /**
     * Constructor of this class which set template of review form
     */
    public function __construct() {
        $customerSession = Mage::getSingleton('customer/session');

        Mage_Core_Block_Template::__construct();

        $data =  Mage::getSingleton('review/session')->getFormData(true);

        //maybe we do not have form data - so we try another session
        if ($data == null) {
            $data = Mage::getSingleton('core/session')->getFormData(true);
        }

        $data = new Varien_Object($data);

        // add logged in customer name as nickname
        if (!$data->getNickname()) {
            $customer = $customerSession->getCustomer();
            if ($customer && $customer->getId()) {
                $data->setNickname($customer->getFirstname());
            }
        }

        $this->setAllowWriteReviewFlag(
        		$customerSession->isLoggedIn() || 
        		Mage::helper('review')->getIsGuestAllowToWrite()
		);
        
        if (!$this->getAllowWriteReviewFlag) {
            $this->setLoginLink(
                Mage::getUrl('customer/account/login/', array(
                    Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME => Mage::helper('core')->urlEncode(
                        Mage::getUrl('*/*/*', array('_current' => true)) .
                        '#review-form')
                    )
                )
            );
        }

        //if "Product Review Captcha" module is enabled - then we display template with reCAPTCHA
        if (Mage::getStoreConfigFlag(self::XML_PATH_PRC_ENABLED)) {
            //get site key
            $siteKey = Mage::getStoreConfig(self::XML_PATH_PRC_PUBLIC_KEY);

            //get reCaptcha theme name
            $theme = Mage::getStoreConfig(self::XML_PATH_PRC_THEME);
            if (strlen($theme) == 0 || !in_array($theme, array('dark', 'light'))) {
                $theme = 'light';
            }

            //get reCaptcha lang name
            $lang = Mage::getStoreConfig(self::XML_PATH_PRC_LANG);
            if (strlen($lang) == 0) {
                $lang = 'en';
            }

            $this->setTemplate('productreviewrecaptcha/form.phtml')
                ->assign('data', $data)
                ->assign('messages', Mage::getSingleton('review/session')->getMessages(true))
                ->setSiteKey($siteKey)
                ->setCaptchaTheme($theme)
                ->setCaptchaLang($lang);
        }
        //otherwise use standard form
        else {
            $this->setTemplate('review/form.phtml')
                ->assign('data', $data)
                ->assign('messages', Mage::getSingleton('review/session')->getMessages(true));
        }
    }
}
