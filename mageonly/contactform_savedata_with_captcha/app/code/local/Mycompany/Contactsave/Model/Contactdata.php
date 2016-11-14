<?php
class Mycompany_Contactsave_Model_Contactdata extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'mycompany_contactsave_contactdata';
    const CACHE_TAG = 'mycompany_contactsave_contactdata';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'mycompany_contactsave_contactdata';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'contactdata';

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
        $this->_init('mycompany_contactsave/contactdata');
    }

    /**
     * before save contact data
     *
     * @access protected
     * @return Mycompany_Contactsave_Model_Contactdata
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
     * save contact data relation
     *
     * @access public
     * @return Mycompany_Contactsave_Model_Contactdata
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
