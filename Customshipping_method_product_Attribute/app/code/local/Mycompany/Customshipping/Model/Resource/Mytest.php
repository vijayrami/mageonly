<?php
// app/code/local/Mycompany/Customshipping/Model/Resource/Mytest.php
class Mycompany_Customshipping_Model_Resource_Mytest extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('mycompany_customshipping/mytest', 'entity_id');
    }
}