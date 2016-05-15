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
 * Holiday model
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Model_Holiday extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'plumtree_holiday_holiday';
    const CACHE_TAG = 'plumtree_holiday_holiday';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'plumtree_holiday_holiday';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'holiday';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('plumtree_holiday/holiday');
    }

    /**
     * before save holiday
     *
     * @access protected
     * @return Plumtree_Holiday_Model_Holiday
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save holiday relation
     *
     * @access public
     * @return Plumtree_Holiday_Model_Holiday
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
	public function getAllAvailProductIds(){
        $collection = Mage::getResourceModel('catalog/product_collection')
                        ->getAllIds();
        return $collection;
    }
    
}
