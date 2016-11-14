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
 * Contact Inquiry Data admin edit tabs
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('contactinquiry_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_contactinquiry',
            array(
                'label'   => Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data'),
                'title'   => Mage::helper('mycompany_mycontact')->__('Contact Inquiry Data'),
                'content' => $this->getLayout()->createBlock(
                    'mycompany_mycontact/adminhtml_contactinquiry_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve contact inquiry data entity
     *
     * @access public
     * @return Mycompany_Mycontact_Model_Contactinquiry
     * @author Ultimate Module Creator
     */
    public function getContactinquiry()
    {
        return Mage::registry('current_contactinquiry');
    }
}
