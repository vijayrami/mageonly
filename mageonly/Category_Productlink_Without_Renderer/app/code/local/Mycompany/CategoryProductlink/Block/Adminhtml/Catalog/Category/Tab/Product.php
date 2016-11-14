<?php
require_once 'Mage/Adminhtml/Block/Catalog/Category/Tab/Product.php';
class Mycompany_CategoryProductlink_Block_Adminhtml_Catalog_Category_Tab_Product extends Mage_Adminhtml_Block_Catalog_Category_Tab_Product {

	/*Overwrite prepare column to provide edit functionality in category */
    protected function _prepareColumns()
    {
       parent::_prepareColumns();
       $this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/catalog_product/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        //'target'=>'_blank',
                        'field'   => 'id',
                    	'popup'   => true
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
        ));
    }
}