<?php
class Mycompany_Contactsave_Block_Adminhtml_Contactdata_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'mycompany_contactsave';
        $this->_controller = 'adminhtml_contactdata';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('mycompany_contactsave')->__('Save Contact Data')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('mycompany_contactsave')->__('Delete Contact Data')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('mycompany_contactsave')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_contactdata') && Mage::registry('current_contactdata')->getId()) {
            return Mage::helper('mycompany_contactsave')->__(
                "Edit Contact Data '%s'",
                $this->escapeHtml(Mage::registry('current_contactdata')->getCustomerName())
            );
        } else {
            return Mage::helper('mycompany_contactsave')->__('Add Contact Data');
        }
    }
}
