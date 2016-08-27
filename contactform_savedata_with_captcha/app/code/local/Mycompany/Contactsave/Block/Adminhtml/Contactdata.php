<?php
class Mycompany_Contactsave_Block_Adminhtml_Contactdata extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_contactdata';
        $this->_blockGroup         = 'mycompany_contactsave';
        parent::__construct();
        $this->_headerText         = Mage::helper('mycompany_contactsave')->__('Contact Data');
        $this->_updateButton('add', 'label', Mage::helper('mycompany_contactsave')->__('Add Contact Data'));
        $this->_removeButton('add');

    }
}
