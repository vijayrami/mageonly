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
class Apptha_Deliveryschedule_Adminhtml_DeliveryscheduleController extends Mage_Adminhtml_Controller_action {
    protected function _initAction() {
        $this->loadLayout ()
        ->_setActiveMenu ( 'deliveryschedule/items' )
        ->_addBreadcrumb ( Mage::helper ( 'adminhtml' )
        ->__ ( 'Schedule Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Schedule Manager' ) );
        /**
         * return layout
         */
        return $this;
    }
    /**
     * Render layout for admin section
     */ 
    public function indexAction() {
        $this->_title($this->__('deliveryschedule'))->_title($this->__('Manage Delivery Schedule'));
        $this->_initAction ()->renderLayout ();
    }
    /**
     * editAction() - Edit delivery schedule record by id
     */
    public function editAction() {
        /**
         *  Get param which  posted name as id
         */ 
        $this->_title($this->__('deliveryschedule'))->_title($this->__('Manage Delivery Schedule'));
        $scheduleId = $this->getRequest ()->getParam ('id');
        /**
         * Load model by schedule id
         */ 
        $modelTypes = Mage::getModel ( 'deliveryschedule/deliveryschedule' )->load ($scheduleId);
        
        if ($modelTypes->getId () || $scheduleId == 0) {
            $data = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
            if (! empty ( $data )) {
                $modelTypes->setData ( $data );
            }
            Mage::register ( 'deliveryschedule_data', $modelTypes );
            $this->loadLayout ();
            $this->_setActiveMenu ( 'deliveryschedule/items' );
            
            $this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )
                    ->__ ( 'Schedule Manager' ),
                     Mage::helper ( 'adminhtml' )->__ ( 'Schedule Manager' ) );
            $this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )
                    ->__ ( 'Schedule Manager' ),
                     Mage::helper ( 'adminhtml' )->__ ( 'Schedule Manager' ) );
            $this->getLayout ()->getBlock ( 'head' )
            ->setCanLoadExtJs ( true );
            $this->_addContent ( $this->getLayout ()
                    ->createBlock ( 'deliveryschedule/adminhtml_deliveryschedule_edit' ) )
            ->_addLeft ( $this->getLayout ()
                    ->createBlock ( 'deliveryschedule/adminhtml_deliveryschedule_edit_tabs' ) );
            $this->renderLayout ();
        } else {
            Mage::getSingleton ( 'adminhtml/session' )
            ->addError ( Mage::helper ( 'deliveryschedule' )->__ ( 'Item is does not exist' ) ); $this->_redirect ( '*/*/' );
        }
    }
    /**
     * newAction() - Used to add new row. 
     */ 
    public function newAction() {
        $this
        ->_forward ('edit');
    }
    /**
     * saveAction() - Used to save the data which is added by admin
     */ 
    public function saveAction() {
        if ($saveData = $this->getRequest ()->getPost ()) {
            if (isset ( $saveData ['stores'] )) {
                $saveData ['store_view'] = '0';
                if (!in_array ( '0', $saveData ['stores'] )) {
                    $saveData ['store_view'] = implode ( ",", $saveData ['stores'] );
                } 
                unset ( $saveData ['stores'] );
            }
            $modelTypes = Mage::getModel ( 'deliveryschedule/deliveryschedule' );
            $modelTypes->setData ( $saveData )->setId ( $this->getRequest ()->getParam ( 'id' ) );
            
            try {
                if ($modelTypes->getCreatedTime == NULL || $modelTypes->getUpdateTime () == NULL) {
                    $modelTypes->setCreatedTime ( now () )->setUpdateTime ( now () );
                } else {
                    $modelTypes->setUpdateTime ( now () );
                }
                
                $modelTypes->save ();
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'deliveryschedule' )->__ ( 'Item successfully saved' ) );
                Mage::getSingleton ( 'adminhtml/session' )->setFormData ( false );
                
                if ($this->getRequest ()->getParam ( 'back' )) {
                    $this->_redirect ( '*/*/edit', array (
                            'id' => $modelTypes->getId () 
                    ) );
                    return;
                }
                $this->_redirect ( '*/*/' );
                return;
            } catch ( Exception $exception ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $exception->getMessage () );
                Mage::getSingleton ( 'adminhtml/session' )->setFormData ( $saveData );
                $this->_redirect ( '*/*/edit', array (
                        'id' => $this->getRequest ()->getParam ( 'id' ) 
                ) );
                return;
            }
        }
        Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'deliveryschedule' )->__ ( 'Unable to find the item to save' ) );
        $this->_redirect ( '*/*/' );
    }
    /**
     * deleteAction() - For delete the record
     */ 
    public function deleteAction() {
        if ($this->getRequest ()->getParam ( 'id' ) > 0) {
            try {
                $modelTypes = Mage::getModel ( 'deliveryschedule/deliveryschedule' );
                
                $modelTypes->setId ( $this->getRequest ()->getParam ( 'id' ) )->delete ();
                
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Item successfully deleted' ) );
                $this->_redirect ( '*/*/' );
            } catch ( Exception $e ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
                $this->_redirect ( '*/*/edit', array (
                        'id' => $this->getRequest ()->getParam ( 'id' ) 
                ) );
            }
        }
        $this->_redirect ( '*/*/' );
    }
    /**
     * massDeleteAction() - for delete multiple record from admin grid
     */ 
    public function massDeleteAction() {
        $deliverydateIds = $this->getRequest ()->getParam ( 'deliveryschedule' );
        if (! is_array ( $deliverydateIds )) {
            Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select item(s)' ) );
        } else {
            try {
                foreach ( $deliverydateIds as $deliverydateId ) {
                   Mage::getModel ( 'deliveryschedule/deliveryschedule' )->load ( $deliverydateId )->delete ();
                }
                Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $deliverydateIds ) ) );
            } catch ( Exception $e ) {
                Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
            }
        }
        $this->_redirect ( '*/*/index' );
    }
    /**
     * massStatusAction() - Change the status for multiple rows 
     */ 
    public function massStatusAction() {
        $deliverydateIds = $this->getRequest ()->getParam ( 'deliveryschedule' );
        if (! is_array ( $deliverydateIds )) {
            Mage::getSingleton ( 'adminhtml/session' )->addError ( $this->__ ( 'Please select item(s)' ) );
        } else {
            try {
                foreach ( $deliverydateIds as $deliverydateId ) {
                   Mage::getSingleton ( 'deliveryschedule/deliveryschedule' )->load ( $deliverydateId )->setStatus ( $this->getRequest ()->getParam ( 'status' ) )->setIsMassupdate ( true )->save ();
                }
                $this->_getSession ()->addSuccess ( $this->__ ( 'Total of %d record(s) were successfully updated', count ( $deliverydateIds ) ) );
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
        $fileName = 'deliveryschedule.csv';
        $content = $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryschedule_grid' )->getCsv ();
        
        $this->_sendUploadResponse ( $fileName, $content );
    }
    /**
     * exportXmlAction() - export xml file from admin grid data
     */
    public function exportXmlAction() {
        $fileName = 'deliveryschedule.xml';
        $content = $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryschedule_grid' )->getXml ();
        
        $this->_sendUploadResponse ( $fileName, $content );
    }
    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse ();
        $response->setHeader ( 'HTTP/1.1 200 OK', '' );
        $response->setHeader ( 'Pragma', 'public', true );
        $response->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true );
        $response->setHeader ( 'Content-Disposition', 'attachment; filename=' . $fileName );
        $response->setHeader ( 'Last-Modified', date ( 'r' ) );
        $response->setHeader ( 'Accept-Ranges', 'bytes' );
        $response->setHeader ( 'Content-Length', strlen ( $content ) );
        $response->setHeader ( 'Content-type', $contentType );
        $response->setBody ( $content );
        $response->sendResponse ();
        die ();
    }
}