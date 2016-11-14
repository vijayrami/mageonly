<?php
class Mycompany_Contactsave_Model_Resource_Contactdata extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        $this->_init('mycompany_contactsave/contactdata', 'entity_id');
    }
}
