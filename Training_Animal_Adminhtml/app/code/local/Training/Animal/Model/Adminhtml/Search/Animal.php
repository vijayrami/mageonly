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
 * Admin search model
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Model_Adminhtml_Search_Animal extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Training_Animal_Model_Adminhtml_Search_Animal
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('training_animal/animal_collection')
            ->addFieldToFilter('name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $animal) {
            $arr[] = array(
                'id'          => 'animal/1/'.$animal->getId(),
                'type'        => Mage::helper('training_animal')->__('Animal'),
                'name'        => $animal->getName(),
                'description' => $animal->getName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/animal/edit',
                    array('id'=>$animal->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
