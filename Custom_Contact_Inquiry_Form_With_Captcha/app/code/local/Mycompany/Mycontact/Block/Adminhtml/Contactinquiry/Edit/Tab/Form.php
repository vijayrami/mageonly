<?php
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Contact Inquiry Data edit form tab
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('contactinquiry_');
        $form->setFieldNameSuffix('contactinquiry');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'contactinquiry_form',
            array('legend' => Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('mycompany_mycontact')->__('Name'),
                'name'  => 'name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('mycompany_mycontact')->__('Email'),
                'name'  => 'email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'mobile',
            'text',
            array(
                'label' => Mage::helper('mycompany_mycontact')->__('Mobile'),
                'name'  => 'mobile',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'city',
            'text',
            array(
                'label' => Mage::helper('mycompany_mycontact')->__('City'),
                'name'  => 'city',

           )
        );

        $fieldset->addField(
            'pincode',
            'text',
            array(
                'label' => Mage::helper('mycompany_mycontact')->__('Pincode'),
                'name'  => 'pincode',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('mycompany_mycontact')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('mycompany_mycontact')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('mycompany_mycontact')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_contactinquiry')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getContactinquiryData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getContactinquiryData());
            Mage::getSingleton('adminhtml/session')->setContactinquiryData(null);
        } elseif (Mage::registry('current_contactinquiry')) {
            $formValues = array_merge($formValues, Mage::registry('current_contactinquiry')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
