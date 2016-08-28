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
 * Contact Inquiry Data admin edit form
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'mycompany_mycontact';
        $this->_controller = 'adminhtml_contactinquiry';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('mycompany_mycontact')->__('Save Contact Inquiry Data')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('mycompany_mycontact')->__('Delete Contact Inquiry Data')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('mycompany_mycontact')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_contactinquiry') && Mage::registry('current_contactinquiry')->getId()) {
            return Mage::helper('mycompany_mycontact')->__(
                "Edit Contact Inquiry Data '%s'",
                $this->escapeHtml(Mage::registry('current_contactinquiry')->getName())
            );
        } else {
            return Mage::helper('mycompany_mycontact')->__('Add Contact Inquiry Data');
        }
    }
}
