<?php
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Contact Inquiry Data admin controller
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Adminhtml_Mycontact_ContactinquiryController extends Mycompany_Mycontact_Controller_Adminhtml_Mycontact
{
    /**
     * init the contact inquiry data
     *
     * @access protected
     * @return Mycompany_Mycontact_Model_Contactinquiry
     */
    protected function _initContactinquiry()
    {
        $contactinquiryId  = (int) $this->getRequest()->getParam('id');
        $contactinquiry    = Mage::getModel('mycompany_mycontact/contactinquiry');
        if ($contactinquiryId) {
            $contactinquiry->load($contactinquiryId);
        }
        Mage::register('current_contactinquiry', $contactinquiry);
        return $contactinquiry;
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
        $this->_title(Mage::helper('mycompany_mycontact')->__('Customer Inquiry Details'))
             ->_title(Mage::helper('mycompany_mycontact')->__('Contact Inquiry Datas'));
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
     * edit contact inquiry data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $contactinquiryId    = $this->getRequest()->getParam('id');
        $contactinquiry      = $this->_initContactinquiry();
        if ($contactinquiryId && !$contactinquiry->getId()) {
            $this->_getSession()->addError(
                Mage::helper('mycompany_mycontact')->__('This contact inquiry data no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getContactinquiryData(true);
        if (!empty($data)) {
            $contactinquiry->setData($data);
        }
        Mage::register('contactinquiry_data', $contactinquiry);
        $this->loadLayout();
        $this->_title(Mage::helper('mycompany_mycontact')->__('Customer Inquiry Details'))
             ->_title(Mage::helper('mycompany_mycontact')->__('Contact Inquiry Datas'));
        if ($contactinquiry->getId()) {
            $this->_title($contactinquiry->getName());
        } else {
            $this->_title(Mage::helper('mycompany_mycontact')->__('Add contact inquiry data'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new contact inquiry data action
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
     * save contact inquiry data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('contactinquiry')) {
            try {
                $contactinquiry = $this->_initContactinquiry();
                $contactinquiry->addData($data);
                $contactinquiry->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $contactinquiry->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setContactinquiryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_mycontact')->__('There was a problem saving the contact inquiry data.')
                );
                Mage::getSingleton('adminhtml/session')->setContactinquiryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mycompany_mycontact')->__('Unable to find contact inquiry data to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete contact inquiry data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $contactinquiry = Mage::getModel('mycompany_mycontact/contactinquiry');
                $contactinquiry->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_mycontact')->__('There was an error deleting contact inquiry data.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mycompany_mycontact')->__('Could not find contact inquiry data to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete contact inquiry data - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $contactinquiryIds = $this->getRequest()->getParam('contactinquiry');
        if (!is_array($contactinquiryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mycompany_mycontact')->__('Please select contact inquiry datas to delete.')
            );
        } else {
            try {
                foreach ($contactinquiryIds as $contactinquiryId) {
                    $contactinquiry = Mage::getModel('mycompany_mycontact/contactinquiry');
                    $contactinquiry->setId($contactinquiryId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mycompany_mycontact')->__('Total of %d contact inquiry datas were successfully deleted.', count($contactinquiryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_mycontact')->__('There was an error deleting contact inquiry datas.')
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
        $contactinquiryIds = $this->getRequest()->getParam('contactinquiry');
        if (!is_array($contactinquiryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mycompany_mycontact')->__('Please select contact inquiry datas.')
            );
        } else {
            try {
                foreach ($contactinquiryIds as $contactinquiryId) {
                $contactinquiry = Mage::getSingleton('mycompany_mycontact/contactinquiry')->load($contactinquiryId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d contact inquiry datas were successfully updated.', count($contactinquiryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mycompany_mycontact')->__('There was an error updating contact inquiry datas.')
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
        $fileName   = 'contactinquiry.csv';
        $content    = $this->getLayout()->createBlock('mycompany_mycontact/adminhtml_contactinquiry_grid')
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
        $fileName   = 'contactinquiry.xls';
        $content    = $this->getLayout()->createBlock('mycompany_mycontact/adminhtml_contactinquiry_grid')
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
        $fileName   = 'contactinquiry.xml';
        $content    = $this->getLayout()->createBlock('mycompany_mycontact/adminhtml_contactinquiry_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('mycompany_mycontact/contactinquiry');
    }
}
