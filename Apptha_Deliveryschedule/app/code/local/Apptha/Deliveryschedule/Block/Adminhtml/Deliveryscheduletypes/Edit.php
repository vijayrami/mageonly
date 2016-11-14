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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryscheduletypes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * Call the constructor to add controller and block group
     */
    public function __construct() {
        parent::__construct ();
        $this->_objectId = 'id';
        $this->_blockGroup = 'deliveryschedule';
        $this->_controller = 'adminhtml_deliveryscheduletypes';
        /**
         * Update the button label name which is Save Types and Delete Types
         */
        $this->_updateButton ( 'save', 'label', Mage::helper ( 'deliveryschedule' )->__ ( 'Save Types' ) );
        $this->_updateButton ( 'delete', 'label', Mage::helper ( 'deliveryschedule' )->__ ( 'Delete Types' ) );
        /**
         * Update the button label name which is Save and Continue
         */
        $this->_addButton ( 'saveandcontinue', array ('label' => Mage::helper ( 'adminhtml' )->__ ( 'Save And Continue Edit' ),'onclick' => 'saveAndContinueEdit()','class' => 'save'), - 100 );
        $this->_formScripts [] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('deliveryschedule_description') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'deliveryschedule_description');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'deliveryschedule_description');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * getHeaderText() - for set the header text which is edit or add item
     */
    public function getHeaderText() {
        /**
         * Check the row id is available in registry
         */
        if (Mage::registry ( 'deliveryscheduletypes_data' ) && Mage::registry ( 'deliveryscheduletypes_data' )->getId ()) {
            return Mage::helper ( 'deliveryschedule' )->__ ( "Edit Types '%s'", $this->htmlEscape ( Mage::registry ( 'deliveryscheduletypes_data' )->getName () ) );
        } else {
            return Mage::helper ( 'deliveryschedule' )->__ ( 'Add Types' );
        }
    }
}