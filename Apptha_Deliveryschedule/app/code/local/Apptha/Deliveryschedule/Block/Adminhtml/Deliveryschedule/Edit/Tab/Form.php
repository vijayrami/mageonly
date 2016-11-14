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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryschedule_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * _prepareForm () - used to prepare the edit or add new form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form ();
        $this->setForm ( $form );
        $fieldset = $form->addFieldset ( 'deliveryschedule_form', array (
                'legend' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule information' ) 
        ) );
        $scheduleTypes = Mage::getModel('deliveryschedule/deliveryscheduletypes')->getResourceCollection()->addFieldToFilter('status',1)->toOptionArray(true);
        $fieldset->addField ( 'schedule_type_id', 'select', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Type' ),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'schedule_type_id',
                'values'    => $scheduleTypes,
        ) );
        $fieldset->addField ( 'title', 'text', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Title' ),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'title',
        ) );
        
        $fieldset->addField ( 'description', 'textarea', array (
                'name' => 'description',
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Description' ),
                'title' => Mage::helper ( 'deliveryschedule' )->__ ( 'Description' ),
                'style' => 'width:300px; height:200px;',
                'wysiwyg' => false,
                'required' => true 
        ) );
        $fieldset->addField ( 'time_slot', 'text', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Time Slot' ),
                'class' => 'validate-time-slot',
                'required' => true,
                'name' => 'time_slot',
                'maxlength' => 11,
                'after_element_html' => '<small>Example : 10:00-13:00</small><script>Validation.add("validate-time-slot","Time slot must be 10:00-13:00 format",function(v){
    var values = v.split("-");if(values[0]>values[1]){return false;}else{return true;}});</script>' 
        ) );
        $fieldset->addField ( 'sorting', 'text', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Sorting Order' ),
                'class' => 'required-entry validate-number validate-zero-or-greater',
                'required' => true,
                'name' => 'sorting',
                'after_element_html' => '<small>Example : 1 </small>' 
        ) );
        $fieldset->addField ( 'status', 'select', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Status' ),
                'name' => 'status',
                'values' => array (
                        array (
                                'value' => 1,
                                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' )
                        ),
        
                        array (
                                'value' => 2,
                                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' )
                        )
                )
        ) );
        /**
         * check the DeliverydateData session
         */
        if (Mage::getSingleton ( 'adminhtml/session' )->getDeliverydateData ()) {
            $form->setValues ( Mage::getSingleton ( 'adminhtml/session' )->getDeliverydateData () );
            Mage::getSingleton ( 'adminhtml/session' )->setDeliverydateData ( null );
        } if (Mage::registry ( 'deliveryschedule_data' )) {
            $form->setValues ( Mage::registry ( 'deliveryschedule_data' )->getData () );
        }
        /**
         * return  _prepareForm ()
         */
        return parent::_prepareForm ();
    }
}