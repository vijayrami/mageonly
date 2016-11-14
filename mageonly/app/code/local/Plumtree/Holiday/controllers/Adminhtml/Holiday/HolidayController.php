<?php
/**
 * Plumtree_Holiday extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Plumtree
 * @package        Plumtree_Holiday
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Holiday admin controller
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Adminhtml_Holiday_HolidayController extends Plumtree_Holiday_Controller_Adminhtml_Holiday
{
    /**
     * init the holiday
     *
     * @access protected
     * @return Plumtree_Holiday_Model_Holiday
     */
    protected function _initHoliday()
    {
        $holidayId  = (int) $this->getRequest()->getParam('id');
        $holiday    = Mage::getModel('plumtree_holiday/holiday');
        if ($holidayId) {
            $holiday->load($holidayId);
        }
        Mage::register('current_holiday', $holiday);
        return $holiday;
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
        $this->_title(Mage::helper('plumtree_holiday')->__('Holiday'))
             ->_title(Mage::helper('plumtree_holiday')->__('Holidays'));
        $this->renderLayout();
    }
	
	public function productgridAction() {
       // $this->_initAction();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('plumtree_holiday/adminhtml_holiday_edit_tab_products')->toHtml()
        );
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
     * edit holiday - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $holidayId    = $this->getRequest()->getParam('id');
        $holiday      = $this->_initHoliday();
        
        if ($holidayId && !$holiday->getId()) {
            $this->_getSession()->addError(
                Mage::helper('plumtree_holiday')->__('This holiday no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getHolidayData(true);
		
        if (!empty($data)) {
            $holiday->setData($data);
        }
        
        Mage::register('holiday_data', $holiday);
		
        $this->loadLayout();
        $this->_title(Mage::helper('plumtree_holiday')->__('Holiday'))
             ->_title(Mage::helper('plumtree_holiday')->__('Holidays'));
        if ($holiday->getId()) {
            $this->_title($holiday->getHolidayName());
        } else {
            $this->_title(Mage::helper('plumtree_holiday')->__('Add holiday'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
		
        $this->renderLayout();
    }

    /**
     * new holiday action
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
     * save holiday - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('holiday')) {
            try {
                $data = $this->_filterDates($data, array('from_date' ,'end_date'));
                $holiday = $this->_initHoliday();
				$data['status'] =  $data['status'];
				// Add new code start
				$availProductIds = Mage::getModel('plumtree_holiday/holiday_productids')->getAllAvailProductIds();
				$selected_products = $this->getRequest()->getParams('');
				//Zend_Debug::dump($selected_products['holiday_products']);
				//exit;
				parse_str($selected_products['holiday_products'], $products);
				
	            foreach ($products as $k => $v) {
	                if (preg_match('/[^0-9]+/', $k) || preg_match('/[^0-9]+/', $v)) {
	                    unset($products[$k]);
	                }
	            }
	            			
            	$productIds = array_intersect($availProductIds, $products);
				//print_r($productIds);exit;
            	$data['product_ids'] = implode(',', $productIds);
				// Add new code Ends
                $holiday->addData($data);
				
                $holiday->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('plumtree_holiday')->__('Holiday was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $holiday->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setHolidayData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('plumtree_holiday')->__('There was a problem saving the holiday.')
                );
                Mage::getSingleton('adminhtml/session')->setHolidayData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('plumtree_holiday')->__('Unable to find holiday to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete holiday - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $holiday = Mage::getModel('plumtree_holiday/holiday');
                $holiday->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('plumtree_holiday')->__('Holiday was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('plumtree_holiday')->__('There was an error deleting holiday.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('plumtree_holiday')->__('Could not find holiday to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete holiday - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $holidayIds = $this->getRequest()->getParam('holiday');
        if (!is_array($holidayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('plumtree_holiday')->__('Please select holidays to delete.')
            );
        } else {
            try {
                foreach ($holidayIds as $holidayId) {
                    $holiday = Mage::getModel('plumtree_holiday/holiday');
                    $holiday->setId($holidayId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('plumtree_holiday')->__('Total of %d holidays were successfully deleted.', count($holidayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('plumtree_holiday')->__('There was an error deleting holidays.')
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
        $holidayIds = $this->getRequest()->getParam('holiday');
        if (!is_array($holidayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('plumtree_holiday')->__('Please select holidays.')
            );
        } else {
            try {
                foreach ($holidayIds as $holidayId) {
                $holiday = Mage::getSingleton('plumtree_holiday/holiday')->load($holidayId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d holidays were successfully updated.', count($holidayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('plumtree_holiday')->__('There was an error updating holidays.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Holiday Status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massHolidayStatusAction()
    {
        $holidayIds = $this->getRequest()->getParam('holiday');
        if (!is_array($holidayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('plumtree_holiday')->__('Please select holidays.')
            );
        } else {
            try {
                foreach ($holidayIds as $holidayId) {
                $holiday = Mage::getSingleton('plumtree_holiday/holiday')->load($holidayId)
                    ->setHolidayStatus($this->getRequest()->getParam('flag_holiday_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d holidays were successfully updated.', count($holidayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('plumtree_holiday')->__('There was an error updating holidays.')
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
        $fileName   = 'holiday.csv';
        $content    = $this->getLayout()->createBlock('plumtree_holiday/adminhtml_holiday_grid')
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
        $fileName   = 'holiday.xls';
        $content    = $this->getLayout()->createBlock('plumtree_holiday/adminhtml_holiday_grid')
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
        $fileName   = 'holiday.xml';
        $content    = $this->getLayout()->createBlock('plumtree_holiday/adminhtml_holiday_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('plumtree_holiday/holiday');
    }
}
