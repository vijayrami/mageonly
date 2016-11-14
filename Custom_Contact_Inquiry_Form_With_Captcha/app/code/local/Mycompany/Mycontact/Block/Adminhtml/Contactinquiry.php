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
 * Contact Inquiry Data admin block
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Block_Adminhtml_Contactinquiry extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_contactinquiry';
        $this->_blockGroup         = 'mycompany_mycontact';
        parent::__construct();
        $this->_headerText         = Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data');
        $this->_updateButton('add', 'label', Mage::helper('mycompany_mycontact')->__('Add Contact Inquiry Data'));
        $this->_removeButton('add');
    }
}
