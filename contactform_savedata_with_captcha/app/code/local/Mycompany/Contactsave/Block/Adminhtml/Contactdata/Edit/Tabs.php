<?php
class Mycompany_Contactsave_Block_Adminhtml_Contactdata_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('contactdata_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mycompany_contactsave')->__('Contact Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Mycompany_Contactsave_Block_Adminhtml_Contactdata_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_contactdata',
            array(
                'label'   => Mage::helper('mycompany_contactsave')->__('Contact Data'),
                'title'   => Mage::helper('mycompany_contactsave')->__('Contact Data'),
                'content' => $this->getLayout()->createBlock(
                    'mycompany_contactsave/adminhtml_contactdata_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve contact data entity
     *
     * @access public
     * @return Mycompany_Contactsave_Model_Contactdata
     * @author Ultimate Module Creator
     */
    public function getContactdata()
    {
        return Mage::registry('current_contactdata');
    }
}
