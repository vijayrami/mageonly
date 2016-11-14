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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryscheduletypes_Edit_Tab_Days extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * _prepareForm () - used to prepare the edit or add new form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form ();
        $this->setForm ( $form );
        $fieldset = $form->addFieldset ( 'deliveryschedule_form', array ('legend' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Types' )) );
        
        $fieldset->addField ( 'monday', 'select', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Monday' ),'name' => 'monday','values' => array ( array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))) );
        $fieldset->addField ( 'tuesday', 'select', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Tuesday' ),'name' => 'tuesday','values' => array (array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))) );
        $fieldset->addField ( 'wednesday', 'select', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Wednesday' ),'name' => 'wednesday','values' => array (array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))) );
        $fieldset->addField ( 'thursday', 'select', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Thursday' ),'name' => 'thursday','values' => array ( array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ( 'value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' ) )) ) );
        $fieldset->addField ( 'friday', 'select', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Friday' ), 'name' => 'friday','values' => array (array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))) );
        $fieldset->addField ( 'saturday', 'select', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Saturday' ),'name' => 'saturday','values' => array (array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))) );
        $fieldset->addField ( 'sunday', 'select', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Sunday' ),'name' => 'sunday','values' => array (array ('value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )),array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )))
        ) );
        /**
         * check the deliveryscheduletypes_data session
         */
        if (Mage::getSingleton ( 'adminhtml/session' )->getDeliverydateData ()) {
            $form->setValues ( Mage::getSingleton ( 'adminhtml/session' )->getDeliverydateData () );
            Mage::getSingleton ( 'adminhtml/session' )->setDeliverydateData ( null );
        } if (Mage::registry ( 'deliveryscheduletypes_data' )) {
            $form->setValues ( Mage::registry ( 'deliveryscheduletypes_data' )->getData () );
        }
        /**
         * return  _prepareForm ()
         */
        return parent::_prepareForm ();
    }
}