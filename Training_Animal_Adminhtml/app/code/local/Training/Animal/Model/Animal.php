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
 * Animal model
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Model_Animal extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'training_animal_animal';
    const CACHE_TAG = 'training_animal_animal';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'training_animal_animal';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'animal';

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
        $this->_init('training_animal/animal');
    }

    /**
     * before save animal
     *
     * @access protected
     * @return Training_Animal_Model_Animal
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
     * save animal relation
     *
     * @access public
     * @return Training_Animal_Model_Animal
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
    
}
