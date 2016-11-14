<?php
/**
 * Training_Animal extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Training
 * @package        Training_Animal
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Animal edit form tab
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Block_Adminhtml_Animal_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Training_Animal_Block_Adminhtml_Animal_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('animal_');
        $form->setFieldNameSuffix('animal');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'animal_form',
            array('legend' => Mage::helper('training_animal')->__('Animal'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('training_animal')->__('Name'),
                'name'  => 'name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'type',
            'text',
            array(
                'label' => Mage::helper('training_animal')->__('Animal Type'),
                'name'  => 'type',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'edible',
            'select',
            array(
                'label' => Mage::helper('training_animal')->__('Is Edible'),
                'name'  => 'edible',
                'required'  => true,
                'class' => 'required-entry',
            	'values'=> Mage::getModel('training_animal/animal_attribute_source_edible')->getAllOptions(false),
           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('training_animal')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('training_animal')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('training_animal')->__('Disabled'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_animal')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_animal')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getAnimalData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getAnimalData());
            Mage::getSingleton('adminhtml/session')->setAnimalData(null);
        } elseif (Mage::registry('current_animal')) {
            $formValues = array_merge($formValues, Mage::registry('current_animal')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
