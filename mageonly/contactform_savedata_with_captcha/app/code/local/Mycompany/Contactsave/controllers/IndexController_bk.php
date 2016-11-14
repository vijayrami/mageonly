<?php
include_once("Mage/Contacts/controllers/IndexController.php");
class Mycompany_Contactsave_IndexController extends Mage_Contacts_IndexController
{
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
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
                if ($error == false){
                	$resource   = Mage::getSingleton('core/resource');
                	$write      = Mage::getSingleton('core/resource')->getConnection('core_write');
                	$table      = $resource->getTableName('mycompany_contactsave_contactdata');
                	
                	
                	$name       	= $post['name'];
                	$email      	= $post['email'];
                	$telephone  	= $post['telephone'];
                	$fax    		= $post['fax'];
                	$company_name   = $post['company_name'];
                	$comments   	= $post['comment'];
                	
                	$query      =  "Insert Into {$table} (customer_name,customer_email,customer_phone,customer_fax,customer_company,customer_comment,status,updated_at,created_at) values (:name,:email,:telephone,:fax,:company_name,:comments,1,NOW(),NOW())";
                	$binds      =  array(
                			'name'   		=> $name,
                			'email'      	=> $email,
                			'telephone'     => $telephone,
                			'fax' 			=> $fax,
                			'company_name' 	=> $company_name,
                			'comments'  	=> $comments,
                	);
                	$write->query($query,$binds);            	
                }
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }

}
