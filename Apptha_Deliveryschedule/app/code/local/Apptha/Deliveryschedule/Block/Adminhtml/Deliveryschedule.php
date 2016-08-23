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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryschedule extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * Call the construct for set controller and block
     */
    public function __construct() {
        $this->_controller = 'adminhtml_deliveryschedule';
        $this->_blockGroup = 'deliveryschedule';
        /**
         * Add the header text which is displayed admin grid
         */
        $this->_headerText = Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Manager' );
        /**
         * Add button label which is shown in admin grid
         */
        $this->_addButtonLabel = Mage::helper ( 'deliveryschedule' )->__ ( 'Add Item' );
        parent::__construct ();
    }
}