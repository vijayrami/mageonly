<?php
class Mycompany_Contactsave_Adminhtml_Contactsave_ContactdataController extends Mycompany_Contactsave_Controller_Adminhtml_Contactsave
{
    /**
     * init the contact data
     *
     * @access protected
     * @return Mycompany_Contactsave_Model_Contactdata
     */
    protected function _initContactdata()
    {
        $contactdataId  = (int) $this->getRequest()->getParam('id');
        $contactdata    = Mage::getModel('mycompany_contactsave/contactdata');
        if ($contactdataId) {
            $contactdata->load($contactdataId);
        }
        Mage::register('current_contactdata', $contactdata);
        return $contactdata;
    }

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
        $this->_title(Mage::helper('mycompany_contactsave')->__('Manage Contact Forms'))
             ->_title(Mage::helper('mycompany_contactsave')->__('Contact Datas'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit contact data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $contactdataId    = $this->getRequest()->getParam('id');
        $contactdata      = $this->_initContactdata();
        if ($contactdataId && !$contactdata->getId()) {
            $this->_getSession()->addError(
                Mage::helper('mycompany_contactsave')->__('This contact data no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getContactdataData(true);
        if (!empty($data)) {
            $contactdata->setData($data);
        }
        Mage::register('contactdata_data', $contactdata);
        $this->loadLayout();
        $this->_title(Mage::helper('mycompany_contactsave')->__('Manage Contact Forms'))
             ->_title(Mage::helper('mycompany_contactsave')->__('Contact Datas'));
        if ($contactdata->getId()) {
            $this->_title($contactdata->getCustomerName());
        } else {
            $this->_title(Mage::helper('mycompany_contactsave')->__('Add contact data'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new contact data action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save contact data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('contactdata')) {
            try {
                $contactdata = $this->_initContactdata();
                $contactdata->addData($data);
                $contactdata->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_contactsave')->__('Contact Data was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $contactdata->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setContactdataData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_contactsave')->__('There was a problem saving the contact data.')
                );
                Mage::getSingleton('adminhtml/session')->setContactdataData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mycompany_contactsave')->__('Unable to find contact data to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete contact data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $contactdata = Mage::getModel('mycompany_contactsave/contactdata');
                $contactdata->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_contactsave')->__('Contact Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_contactsave')->__('There was an error deleting contact data.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mycompany_contactsave')->__('Could not find contact data to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete contact data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $contactdataIds = $this->getRequest()->getParam('contactdata');
        if (!is_array($contactdataIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mycompany_contactsave')->__('Please select contact datas to delete.')
            );
        } else {
            try {
                foreach ($contactdataIds as $contactdataId) {
                    $contactdata = Mage::getModel('mycompany_contactsave/contactdata');
                    $contactdata->setId($contactdataId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_contactsave')->__('Total of %d contact datas were successfully deleted.', count($contactdataIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_contactsave')->__('There was an error deleting contact datas.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $contactdataIds = $this->getRequest()->getParam('contactdata');
        if (!is_array($contactdataIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mycompany_contactsave')->__('Please select contact datas.')
            );
        } else {
            try {
                foreach ($contactdataIds as $contactdataId) {
                $contactdata = Mage::getSingleton('mycompany_contactsave/contactdata')->load($contactdataId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d contact datas were successfully updated.', count($contactdataIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_contactsave')->__('There was an error updating contact datas.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'contactdata.csv';
        $content    = $this->getLayout()->createBlock('mycompany_contactsave/adminhtml_contactdata_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'contactdata.xls';
        $content    = $this->getLayout()->createBlock('mycompany_contactsave/adminhtml_contactdata_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'contactdata.xml';
        $content    = $this->getLayout()->createBlock('mycompany_contactsave/adminhtml_contactdata_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('mycompany_contactsave/contactdata');
    }
}
