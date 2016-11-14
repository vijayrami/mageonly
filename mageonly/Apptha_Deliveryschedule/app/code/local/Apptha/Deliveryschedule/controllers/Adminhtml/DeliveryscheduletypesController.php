<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Deliveryschedule
 * @version     0.1.0
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2015 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 * */
class Apptha_Deliveryschedule_Adminhtml_DeliveryscheduletypesController extends Mage_Adminhtml_Controller_action {
    protected function _initAction() {
        $this->loadLayout ()->_setActiveMenu ( 'deliveryschedule/deliveryschedule_types' )->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ), Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ) );
        /**
         * return layout
         */
        return $this;
    }
    /**
     * Render layout for admin schedule types grid
     */ 
    public function indexAction() {
        $this->_title($this->__('deliveryschedule'))->_title($this->__('Delivery Schedule Types'));
        $this->_initAction ()->renderLayout ();
    }
    /**
     * editAction() - Edit delivery schedule types record by id
     */
    public function editAction() {
        /**
         *  Get param which  posted name as id
         */ 
        $this->_title($this->__('deliveryschedule'))->_title($this->__('Delivery Schedule Types'));
        $id = $this->getRequest ()->getParam ( 'id' );
        /**
         * Load model by schedule type id
         */ 
        $model = Mage::getModel ( 'deliveryschedule/deliveryscheduletypes' )->load ( $id );
        
        if ($model->getId () || $id == 0) {
            $datas = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
            if (! empty ( $datas )) {
                $model->setData ( $datas );
            }
            
            Mage::register ( 'deliveryscheduletypes_data', $model );
            
            $this->loadLayout ();
            $this->_setActiveMenu ( 'deliveryschedule/deliveryschedule_types' );
            
            $this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ), Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ) );
            $this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ), Mage::helper ( 'adminhtml' )->__ ( 'Schedule Types' ) );
            
            $this->getLayout ()->getBlock ( 'head' )->setCanLoadExtJs ( true );
            
            $this->_addContent ( $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_edit_tabs' ) );
            
            $this->renderLayout ();
        } else {
            Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'deliveryschedule' )->__ ( 'Item does not exist' ) );
            $this->_redirect ( '*/*/' );
        }
    }
    /**
     * newAction() - Used to add new schedule types. 
     */ 
    public function newAction() {
        $this->_forward ( 'edit' );
    }
    /**
     * saveAction() - Used to save the data added by admin
     */ 
    public function saveAction() {
        if ($datas = $this->getRequest ()->getPost ()) {
            if (isset ( $datas ['stores'] )) {
                $datas ['store_view'] = '0';
                if (!in_array ( '0', $datas ['stores'] )) {
                    $datas ['store_view'] = implode ( ",", $datas ['stores'] );
                } 
                unset ( $datas ['stores'] );
            }
            $model = Mage::getModel ( 'deliveryschedule/deliveryscheduletypes' );
            $model->setData ( $datas )->setId ( $this->getRequest ()->getParam ( 'id' ) );
            
            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime () == NULL) {
                    $model->setCreatedTime ( now () )->setUpdateTime ( now () );
                } else {
                    $model->setUpdateTime ( now () );
                }
                
                $model->save ();
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'deliveryschedule' )->__ ( 'Item was successfully saved' ) );
                Mage::getSingleton ( 'adminhtml/session' )->setFormData ( false );
                
                if ($this->getRequest ()->getParam ( 'back' )) {
                    $this->_redirect ( '*/*/edit', array (
                            'id' => $model->getId () 
                    ) );
                    return;
                }
                $this->_redirect ( '*/*/' );
                return;
            } catch ( Exception $e ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
                Mage::getSingleton ( 'adminhtml/session' )->setFormData ( $datas );
                $this->_redirect ( '*/*/edit', array ('id' => $this->getRequest ()->getParam ( 'id' ) ) );
                return;
            }
        }
        Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'deliveryschedule' )->__ ( 'Unable to find item to save' ) );
        $this->_redirect ( '*/*/' );
    }
    /**
     * deleteAction() - used to delete the record
     */ 
    public function deleteAction() {
        if ($this->getRequest ()->getParam ( 'id' ) > 0) {
            try {
                $model = Mage::getModel ( 'deliveryschedule/deliveryscheduletypes' );
                
                $model->setId ( $this->getRequest ()->getParam ( 'id' ) )->delete ();
                
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Item was successfully deleted' ) );
                $this->_redirect ( '*/*/' );
            } catch ( Exception $e ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
                $this->_redirect ( '*/*/edit', array ('id' => $this->getRequest ()->getParam ( 'id' ) ) );
            }
        }
        $this->_redirect ( '*/*/' );
    }
    /**
     * massDeleteAction() - used to delete multiple record from admin grid
     */ 
    public function massDeleteAction() {
        $deliveryTypeIds = $this->getRequest ()->getParam ( 'deliveryschedule' );
        if (! is_array ( $deliveryTypeIds )) {
            Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select item(s)' ) );
        } else {
            try {
                foreach ( $deliveryTypeIds as $deliveryTypeId ) {
                   Mage::getModel ( 'deliveryschedule/deliveryscheduletypes' )->load ( $deliveryTypeId )->delete ();
                }
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $deliveryTypeIds ) ) );
            } catch ( Exception $e ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
            }
        }
        $this->_redirect ( '*/*/index' );
    }
    /**
     * massStatusAction() - Change the status for multiple records 
     */ 
    public function massStatusAction() {
        $deliveryTypeIds = $this->getRequest ()->getParam ( 'deliveryschedule' );
        if (! is_array ( $deliveryTypeIds )) {
            Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'Please select item(s)' ) );
        } else {
            try {
                foreach ( $deliveryTypeIds as $deliveryTypeId ) {
                   Mage::getSingleton ( 'deliveryschedule/deliveryscheduletypes' )->load ( $deliveryTypeId )->setStatus ( $this->getRequest ()->getParam ( 'status' ) )->setIsMassupdate ( true )->save ();
                }
                $this->_getSession ()->addSuccess ( $this->__ ( 'Total of %d record(s) were successfully updated', count ( $deliveryTypeIds ) ) );
            } catch ( Exception $e ) {
                $this->_getSession ()->addError ( $e->getMessage () );
            }
        }
        $this->_redirect ( '*/*/index' );
    }
    /**
     * exportCsvAction() - export csv file from admin grid data
     */
    public function exportCsvAction() {
        $fileNames = 'deliveryschedule_types.csv';
        $contents = $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_grid' )->getCsv ();
        $this->_sendUploadResponse ( $fileNames, $contents );
    }
    /**
     * exportXmlAction() - export xml file from admin grid data
     */
    public function exportXmlAction() {
        $fileNames = 'deliveryschedule_types.xml';
        $contents = $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_grid' )->getXml ();
        $this->_sendUploadResponse ( $fileNames, $contents );
    }
    protected function _sendUploadResponse($fileNames, $contents, $contentTypes = 'application/octet-stream') {
        $response = $this->getResponse ();
        $response->setHeader ( 'HTTP/1.1 200 OK', '' );
        $response->setHeader ( 'Pragma', 'public', true );
        $response->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true );
        $response->setHeader ( 'Content-Disposition', 'attachment; filename=' . $fileNames );
        $response->setHeader ( 'Last-Modified', date ( 'r' ) );
        $response->setHeader ( 'Accept-Ranges', 'bytes' );
        $response->setHeader ( 'Content-Length', strlen ( $contents ) );
        $response->setHeader ( 'Content-type', $contentTypes);
        $response->setBody ( $contents );
        $response->sendResponse ();
        die ();
    }
    }