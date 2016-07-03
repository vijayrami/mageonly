<?php

// app/code/local/Training/Animal/Model/Animal.php
class Training_Animal_Model_Animal extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('training_animal/animal');
    }   
}
