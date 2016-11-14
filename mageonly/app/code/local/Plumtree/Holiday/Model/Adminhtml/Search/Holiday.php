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
 * Admin search model
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Model_Adminhtml_Search_Holiday extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Plumtree_Holiday_Model_Adminhtml_Search_Holiday
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('plumtree_holiday/holiday_collection')
            ->addFieldToFilter('holiday_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $holiday) {
            $arr[] = array(
                'id'          => 'holiday/1/'.$holiday->getId(),
                'type'        => Mage::helper('plumtree_holiday')->__('Holiday'),
                'name'        => $holiday->getHolidayName(),
                'description' => $holiday->getHolidayName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/holiday_holiday/edit',
                    array('id'=>$holiday->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
