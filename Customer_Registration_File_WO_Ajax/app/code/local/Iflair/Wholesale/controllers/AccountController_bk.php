<?php
include_once("Mage/Customer/controllers/AccountController.php");
class Iflair_Wholesale_AccountController extends Mage_Customer_AccountController
{
	const XML_WHOLESALE_FORM_ENABLED = 'customer/wholesale_group/customformfields_enabled';
	/**
     * Create customer account action
     */
    public function createPostAction()
    {
        $errUrl = $this->_getUrl('*/*/create', array('_secure' => true));

        if (!$this->_validateFormKey()) {
            $this->_redirectError($errUrl);
            return;
        }

        /** @var $session Mage_Customer_Model_Session */
        $session = $this->_getSession();
        if ($session->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }

        if (!$this->getRequest()->isPost()) {
            $this->_redirectError($errUrl);
            return;
        }

        $customer = $this->_getCustomer();

        try {
            $errors = $this->_getCustomerErrors($customer);		
			
            if (empty($errors)) {
                $customer->cleanPasswordsValidationData();				
                $customer->save();
                if (($customer->save()) && (Mage::getStoreConfigFlag(self::XML_WHOLESALE_FORM_ENABLED))){
                	/**************************************************************/			
					$fileName = '';
					if (isset($_FILES['proof_document']['name']) && $_FILES['proof_document']['name'] != '') {
	                 try {
	                  $fileName = $_FILES['proof_document']['name'];
	 
	                  $fileExt = strtolower(substr(strrchr($fileName, ".") ,1));
	 
	                  $fileNamewoe = rtrim($fileName, $fileExt);
	 
	                  $fileName = preg_replace('/\s+', '', $fileNamewoe) . time() . '.' . $fileExt;
	 
	                  $uploader = new Varien_File_Uploader('proof_document');
	 
	                  $uploader->setAllowedExtensions(array('doc', 'docx','pdf', 'jpg', 'png', 'zip')); //add more file types you want to allow
	 
	                  $uploader->setAllowRenameFiles(false);
	 
	                  $uploader->setFilesDispersion(false);
	 
	                  $path = Mage::getBaseDir('media') . DS . 'customer_documents';
	 
	                  if(!is_dir($path)){ 
	                   mkdir($path, 0777, true); 
	                  }				  
	                  	$uploader->save($path . DS, $fileName ); 				  
	                 } catch (Exception $e) { 
	                  Mage::getSingleton('customer/session')->addError($e->getMessage()); 
	                  $error = true; 
	                 }
	 
	                }
					/**************************************************************/
                }
                $this->_dispatchRegisterSuccess($customer);
                $this->_successProcessRegistration($customer);
                return;
            } else {
                $this->_addSessionError($errors);
            }
        } catch (Mage_Core_Exception $e) {
            $session->setCustomerFormData($this->getRequest()->getPost());
            if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                $url = $this->_getUrl('customer/account/forgotpassword');
                $message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
            } else {
                $message = $this->_escapeHtml($e->getMessage());
            }
            $session->addError($message);
        } catch (Exception $e) {
            $session->setCustomerFormData($this->getRequest()->getPost());
            $session->addException($e, $this->__('Cannot save the customer.'));
        }
		
        $this->_redirectError($errUrl);
    }
	
	/**
     * Change customer password action
     */
    public function editPostAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/edit');
        }

        if ($this->getRequest()->isPost()) {
            /** @var $customer Mage_Customer_Model_Customer */
            $customer = $this->_getSession()->getCustomer();

            /** @var $customerForm Mage_Customer_Model_Form */
            $customerForm = $this->_getModel('customer/form');
            $customerForm->setFormCode('customer_account_edit')
                ->setEntity($customer);

            $customerData = $customerForm->extractData($this->getRequest());

            $errors = array();
            $customerErrors = $customerForm->validateData($customerData);
            if ($customerErrors !== true) {
                $errors = array_merge($customerErrors, $errors);
            } else {
                $customerForm->compactData($customerData);
                $errors = array();

                // If password change was requested then add it to common validation scheme
                if ($this->getRequest()->getParam('change_password')) {
                    $currPass   = $this->getRequest()->getPost('current_password');
                    $newPass    = $this->getRequest()->getPost('password');
                    $confPass   = $this->getRequest()->getPost('confirmation');

                    $oldPass = $this->_getSession()->getCustomer()->getPasswordHash();
                    if ( $this->_getHelper('core/string')->strpos($oldPass, ':')) {
                        list($_salt, $salt) = explode(':', $oldPass);
                    } else {
                        $salt = false;
                    }

                    if ($customer->hashPassword($currPass, $salt) == $oldPass) {
                        if (strlen($newPass)) {
                            /**
                             * Set entered password and its confirmation - they
                             * will be validated later to match each other and be of right length
                             */
                            $customer->setPassword($newPass);
                            $customer->setPasswordConfirmation($confPass);
                        } else {
                            $errors[] = $this->__('New password field cannot be empty.');
                        }
                    } else {
                        $errors[] = $this->__('Invalid current password');
                    }
                }

                // Validate account and compose list of errors if any
                $customerErrors = $customer->validate();
                if (is_array($customerErrors)) {
                    $errors = array_merge($errors, $customerErrors);
                }
            }

            if (!empty($errors)) {
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost());
                foreach ($errors as $message) {
                    $this->_getSession()->addError($message);
                }
                $this->_redirect('*/*/edit');
                return $this;
            }

            try {
                $customer->cleanPasswordsValidationData();				
                $customer->save();
				if (($customer->save()) && (Mage::getStoreConfigFlag(self::XML_WHOLESALE_FORM_ENABLED))){
                	/**************************************************************/			
					$fileName = '';
					if (isset($_FILES['proof_document']['name']) && $_FILES['proof_document']['name'] != '') {
	                 try {
	                  $fileName = $_FILES['proof_document']['name'];
	 
	                  $fileExt = strtolower(substr(strrchr($fileName, ".") ,1));
	 
	                  $fileNamewoe = rtrim($fileName, $fileExt);
	 
	                  $fileName = preg_replace('/\s+', '', $fileNamewoe) . time() . '.' . $fileExt;
	 
	                  $uploader = new Varien_File_Uploader('proof_document');
	 
	                  $uploader->setAllowedExtensions(array('doc', 'docx','pdf', 'jpg', 'png', 'zip')); //add more file types you want to allow
	 
	                  $uploader->setAllowRenameFiles(false);
	 
	                  $uploader->setFilesDispersion(false);
	 
	                  $path = Mage::getBaseDir('media') . DS . 'customer_documents';
	 
	                  if(!is_dir($path)){ 
	                   mkdir($path, 0777, true); 
	                  }				  
	                  	$uploader->save($path . DS, $fileName ); 				  
	                 } catch (Exception $e) { 
	                  Mage::getSingleton('customer/session')->addError($e->getMessage()); 
	                  $error = true; 
	                 }
	 
	                }
					/**************************************************************/
                }
                $this->_getSession()->setCustomer($customer)
                    ->addSuccess($this->__('The account information has been saved.'));

                $this->_redirect('customer/account');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost())
                    ->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost())
                    ->addException($e, $this->__('Cannot save the customer.'));
            }
        }

        $this->_redirect('*/*/edit');
    }
}
