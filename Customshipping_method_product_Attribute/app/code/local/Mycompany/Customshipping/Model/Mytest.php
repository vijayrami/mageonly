<?php
// app/code/local/Mycompany/Customshipping/Model/Mytest.php
class Mycompany_Customshipping_Model_Mytest extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mycompany_customshipping/mytest');
    }   
}