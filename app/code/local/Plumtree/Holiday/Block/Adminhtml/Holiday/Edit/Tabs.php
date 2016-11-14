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
 * Holiday admin edit tabs
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Block_Adminhtml_Holiday_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('holiday_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('plumtree_holiday')->__('Holiday'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_holiday',
            array(
                'label'   => Mage::helper('plumtree_holiday')->__('Holiday'),
                'title'   => Mage::helper('plumtree_holiday')->__('Holiday'),
                'content' => $this->getLayout()->createBlock(
                    'plumtree_holiday/adminhtml_holiday_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        /*if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_holiday',
                array(
                    'label'   => Mage::helper('plumtree_holiday')->__('Store views'),
                    'title'   => Mage::helper('plumtree_holiday')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'plumtree_holiday/adminhtml_holiday_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }*/
		$this->addTab(
			'products',
			 array(
    			'label' => Mage::helper('plumtree_holiday')->__('Associated products'),
				'alt' => Mage::helper('plumtree_holiday')->__('Associated products'),
    			'content' => $this->getLayout()->createBlock('plumtree_holiday/adminhtml_holiday_grid_gridproduct')->toHtml(),
			));
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve holiday entity
     *
     * @access public
     * @return Plumtree_Holiday_Model_Holiday
     * @author Ultimate Module Creator
     */
   /* public function getHoliday()
    {
        return Mage::registry('current_holiday');
    }*/
}
