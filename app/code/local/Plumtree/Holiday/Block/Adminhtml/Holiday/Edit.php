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
 * Holiday admin edit form
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Block_Adminhtml_Holiday_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'plumtree_holiday';
        $this->_controller = 'adminhtml_holiday';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('plumtree_holiday')->__('Save Holiday')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('plumtree_holiday')->__('Delete Holiday')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('plumtree_holiday')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_holiday') && Mage::registry('current_holiday')->getId()) {
            return Mage::helper('plumtree_holiday')->__(
                "Edit Holiday '%s'",
                $this->escapeHtml(Mage::registry('current_holiday')->getHolidayName())
            );
        } else {
            return Mage::helper('plumtree_holiday')->__('Add Holiday');
        }
    }
}
