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
 * Contact Inquiry Data model
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Model_Contactinquiry extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'mycompany_mycontact_contactinquiry';
    const CACHE_TAG = 'mycompany_mycontact_contactinquiry';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'mycompany_mycontact_contactinquiry';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'contactinquiry';

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
        $this->_init('mycompany_mycontact/contactinquiry');
    }

    /**
     * before save contact inquiry data
     *
     * @access protected
     * @return Mycompany_Mycontact_Model_Contactinquiry
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
     * save contact inquiry data relation
     *
     * @access public
     * @return Mycompany_Mycontact_Model_Contactinquiry
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
