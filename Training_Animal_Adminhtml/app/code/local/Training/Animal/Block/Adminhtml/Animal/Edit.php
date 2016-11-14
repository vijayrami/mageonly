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
 * Animal admin edit form
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Block_Adminhtml_Animal_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'training_animal';
        $this->_controller = 'adminhtml_animal';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('training_animal')->__('Save Animal')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('training_animal')->__('Eat Animal')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('training_animal')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_animal') && Mage::registry('current_animal')->getId()) {
            return Mage::helper('training_animal')->__(
                "Edit Animal '%s'",
                $this->escapeHtml(Mage::registry('current_animal')->getName())
            );
        } else {
            return Mage::helper('training_animal')->__('New Animal');
        }
    }
}
