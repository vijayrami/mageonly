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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryscheduletypes_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * _prepareForm () - used to prepare the edit or add new form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form ();
        $this->setForm ( $form );
        $fieldset = $form->addFieldset ( 'deliveryschedule_form', array (
                'legend' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule Types' ) 
        ) );
        $fieldset->addField ( 'name', 'text', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Delivery Schedule Name' ),
                'class' => 'required-entry','required' => true,'name' => 'name'
        ) );
        $fieldset->addField ( 'store_view', 'multiselect', array ('name' => 'stores[]',
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Store View' ),
                'title' => Mage::helper ( 'deliveryschedule' )->__ ( 'Store View' ),
                'required' => true,'values' => Mage::getSingleton ( 'adminhtml/system_store' )->getStoreValuesForForm ( false, true ) ) );
        $fieldset->addField ( 'status', 'select', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Is Active' ),
                'name' => 'status','values' => array (array ( 'value' => 1,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Enabled' ) 
                        ),  array ('value' => 2,'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Disabled' ) ) ) ) );
        $fieldset->addField ( 'description', 'textarea', array (
                'name' => 'description',
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Description' ),
                'title' => Mage::helper ( 'deliveryschedule' )->__ ( 'Description' ),
                'style' => 'width:300px; height:200px;',
                'wysiwyg' => false, 'required' => true) );
        $fieldset->addField ( 'sorting', 'text', array (
                'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Sorting Order' ),
                'class' => 'required-entry validate-number validate-zero-or-greater',
                'required' => true,'name' => 'sorting',  'after_element_html' => '<small>Example : 1 </small>' ) );
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