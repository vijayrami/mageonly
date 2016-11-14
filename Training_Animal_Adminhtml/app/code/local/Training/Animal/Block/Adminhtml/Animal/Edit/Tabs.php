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
 * Animal admin edit tabs
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Block_Adminhtml_Animal_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('animal_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('training_animal')->__('Training Setup'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Training_Animal_Block_Adminhtml_Animal_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_animal',
            array(
                'label'   => Mage::helper('training_animal')->__('General'),
                'title'   => Mage::helper('training_animal')->__('General'),
                'content' => $this->getLayout()->createBlock(
                    'training_animal/adminhtml_animal_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_animal',
                array(
                    'label'   => Mage::helper('training_animal')->__('Store views'),
                    'title'   => Mage::helper('training_animal')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'training_animal/adminhtml_animal_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve animal entity
     *
     * @access public
     * @return Training_Animal_Model_Animal
     * @author Ultimate Module Creator
     */
    public function getAnimal()
    {
        return Mage::registry('current_animal');
    }
}
