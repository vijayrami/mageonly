<?php
/**
 * Plumtree_Holiday extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Plumtree
 * @package        Plumtree_Holiday
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Holiday edit form tab
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Block_Adminhtml_Holiday_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('holiday_');
        $form->setFieldNameSuffix('holiday');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'holiday_form',
            array('legend' => Mage::helper('plumtree_holiday')->__('Holiday'))
        );
		// New Code Start
		$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product','style');
	 	$attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
	 	$attributeOptions = $attribute ->getSource()->getAllOptions();
		$object = Mage::getModel('plumtree_holiday/holiday')->load( $this->getRequest()->getParam('id'));
		// New Code Ends
        $fieldset->addField(
            'from_date',
            'date',
            array(
                'label' => Mage::helper('plumtree_holiday')->__('From Date'),
                'name'  => 'from_date',
                'note'	=> $this->__('Select your start date.'),
                'required'  => true,
                'class' => 'required-entry',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'end_date',
            'date',
            array(
                'label' => Mage::helper('plumtree_holiday')->__('End Date'),
                'name'  => 'end_date',
                'note'	=> $this->__('Select your end date.'),
                'required'  => true,
                'class' => 'required-entry',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'holiday_name',
            'text',
            array(
                'label' => Mage::helper('plumtree_holiday')->__('Holiday Name'),
                'name'  => 'holiday_name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('plumtree_holiday')->__('Holiday Status'),
                'name'  => 'status',
                'required'  => true,
                'class' => 'required-entry',

                'values'=> Mage::getModel('plumtree_holiday/holiday_attribute_source_holidaystatus')->getAllOptions(false),
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
            Mage::registry('current_holiday')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_holiday')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getHolidayData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getHolidayData());
            Mage::getSingleton('adminhtml/session')->setHolidayData(null);
        } elseif (Mage::registry('current_holiday')) {
            $formValues = array_merge($formValues, Mage::registry('current_holiday')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
