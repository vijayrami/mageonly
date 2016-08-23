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
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryschedule_Edit_Tab_Cost extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * _prepareForm () - used to prepare the edit or add new form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form ();
        $this->setForm ( $form );
        $fieldset = $form->addFieldset ( 'deliveryschedule_form', array (
                'legend' => Mage::helper ( 'deliveryschedule' )->__ ( 'Schedule information' ) 
        ) );
        $fieldset->addField ( 'monday_cost', 'text', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Monday' ),'class' => 'required-entry validate-number validate-zero-or-greater','required' => true, 'name' => 'monday_cost','maxlength' => 7,) );
        $fieldset->addField ( 'tuesday_cost', 'text', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Tuesday' ),'class' => 'required-entry validate-number validate-zero-or-greater','required' => true, 'name' => 'tuesday_cost', 'maxlength' => 7,) );
        $fieldset->addField ( 'wednesday_cost', 'text', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Wednesday' ),'class' => 'required-entry validate-number validate-zero-or-greater','required' => true,'name' => 'wednesday_cost', 'maxlength' => 7, ) );
        $fieldset->addField ( 'thursday_cost', 'text', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Thursday' ),'class' => 'required-entry validate-number validate-zero-or-greater','required' => true,'name' => 'thursday_cost',  'maxlength' => 7,  ) );
        $fieldset->addField ( 'friday_cost', 'text', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Friday' ), 'class' => 'required-entry validate-number validate-zero-or-greater', 'required' => true, 'name' => 'friday_cost', 'maxlength' => 7, ) );
        $fieldset->addField ( 'saturday_cost', 'text', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Saturday' ),'class' => 'required-entry validate-number validate-zero-or-greater', 'required' => true,'name' => 'saturday_cost', 'maxlength' => 7,  ) );
        $fieldset->addField ( 'sunday_cost', 'text', array ( 'label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Sunday' ), 'class' => 'required-entry validate-number validate-zero-or-greater','required' => true, 'name' => 'sunday_cost', 'maxlength' => 7,) );
        
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