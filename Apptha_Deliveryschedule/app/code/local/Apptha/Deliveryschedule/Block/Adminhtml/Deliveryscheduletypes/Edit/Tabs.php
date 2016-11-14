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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryscheduletypes_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * construct() - for set collection id
     */
    public function __construct() {
        parent::__construct ();
        $this->setId ( 'deliveryscheduletypes_tabs' );  $this->setDestElementId ( 'edit_form' );
        $this->setTitle ( Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Types' ) );
    }
    /**
     * beforeToHtml() - add tab to this edit form page
     */
    protected function _beforeToHtml() {
        /**
         * Create Tabs
         */
        $this->addTab ( 'form_section_types', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Types' ),'title' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Types' ),'content' => $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_edit_tab_form' )->toHtml () 
        ) );
        $this->addTab ( 'form_section_days_types', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Days' ),'title' => Mage::helper ( 'deliveryschedule' )->__ ( 'Days' ),'content' => $this->getLayout ()->createBlock ( 'deliveryschedule/adminhtml_deliveryscheduletypes_edit_tab_days' )->toHtml ()  ) );
        /**
         * return Tabs
         */
        return parent::_beforeToHtml ();
    }
}