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
 * Animal admin block
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Block_Adminhtml_Animal extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_animal';
        $this->_blockGroup         = 'training_animal';
        parent::__construct();
        $this->_headerText         = Mage::helper('training_animal')->__('List Animals');
        $this->_updateButton('add', 'label', Mage::helper('training_animal')->__('Add Animal'));

    }
}
