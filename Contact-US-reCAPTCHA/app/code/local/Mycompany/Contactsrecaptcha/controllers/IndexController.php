<?php
//include controller to override it
require_once Mage::getBaseDir('app') . DS . 'code' . DS . 'core' . DS . 'Mage' . DS . 'Contacts' . DS . 'controllers' . DS . 'IndexController.php';

class Mycompany_Contactsrecaptcha_IndexController extends Mage_Contacts_IndexController
{
    /**
     * XML system configuration paths
     * @var string
     */
    const XML_PATH_CFC_ENABLED     = 'contacts/mycompany_contactsrecaptcha/enabled';
    const XML_PATH_CFC_PUBLIC_KEY  = 'contacts/mycompany_contactsrecaptcha/public_key';
    const XML_PATH_CFC_PRIVATE_KEY = 'contacts/mycompany_contactsrecaptcha/private_key';
    const XML_PATH_CFC_THEME       = 'contacts/mycompany_contactsrecaptcha/theme';
    const XML_PATH_CFC_LANG        = 'contacts/mycompany_contactsrecaptcha/lang';

    /**
     * Method which handle action of displaying contact form
     */
    public function indexAction()
    {
        $this->loadLayout();

        $this->getLayout()->getBlock('contactForm')->setFormAction( Mage::getUrl('*/*/post', array('_secure' => $this->getRequest()->isSecure())) );

        if (Mage::getStoreConfigFlag(self::XML_PATH_CFC_ENABLED)) {
            //create captcha html-code
            $siteKey = Mage::getStoreConfig(self::XML_PATH_CFC_PUBLIC_KEY);

            //get reCaptcha theme name
            $theme = Mage::getStoreConfig(self::XML_PATH_CFC_THEME);
            if (strlen($theme) == 0 || !in_array($theme, array('dark', 'light'))) {
                $theme = 'light';
            }

            //get reCaptcha lang name
            $lang = Mage::getStoreConfig(self::XML_PATH_CFC_LANG);
            if (strlen($lang) == 0) {
                $lang = 'en';
            }

            $this->getLayout()->getBlock('contactForm')
                ->setSiteKey($siteKey)
                ->setCaptchaTheme($theme)
                ->setCaptchaLang($lang);
        }

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    /**
     * Handle post request of Contact form
     */
    public function postAction()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_CFC_ENABLED)) {
            try {
                $post = $this->getRequest()->getPost();
                $formData = new Varien_Object();
                $formData->setData($post);
                Mage::getSingleton('core/session')->setData('contactForm', $formData);

                if ($post) {
                    if ((!isset($post['g-recaptcha-response']))
                        || (!$this->_isCaptchaValid($post['g-recaptcha-response']))
                    ) {
                        throw new Exception(
                            $this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again."),
                            1
                        );
                    }

                    Mage::getSingleton('core/session')->unsetData('contactForm');
                } else {
                    throw new Exception('', 1);
                }
            } catch (Exception $e) {
                if (strlen($e->getMessage()) > 0) {
                    Mage::getSingleton('customer/session')->addError($this->__($e->getMessage()));
                }
                $this->_redirect('*/*/');
                return;
            }
        }

        //everything is OK - call parent action
        parent::postAction();
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
            'secret' => Mage::getStoreConfig(self::XML_PATH_CFC_PRIVATE_KEY),
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
