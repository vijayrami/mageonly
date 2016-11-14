<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Deliveryschedule
 * @version     0.1.0
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2015 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 * */
class Apptha_Deliveryschedule_Block_Adminhtml_Deliveryscheduletypes_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * Call construct for set delivery schedule type grid data
     */ 
    public function __construct() {
        parent::__construct ();
        $this->setId ( 'deliveryscheduletypesGrid' );
        $this->setDefaultSort ( 'id' );
        $this->setDefaultDir ( 'ASC' );
        $this->setSaveParametersInSession ( true );
    }
    /**
     * Prepare delivery schedule types collection 
     */ 
    protected function _prepareCollection() {
        $collections = Mage::getModel ( 'deliveryschedule/deliveryscheduletypes' )->getCollection ();
        foreach ( $collections as $typeLinks ) {
            /**
             * Check store view is zero or not if not equal to zero explode the data which is stored in row
             */ 
            if ($typeLinks->getStoreView () && $typeLinks->getStoreView () != 0) {
                $typeLinks->setStoreView ( explode ( ',', $typeLinks->getStoreView () ) );
            } else {
                /**
                 * if it is zero set store view array is zero
                 */ 
                $typeLinks->setStoreView ( array ('0') );
            }
        }
        $this->setCollection ( $collections );
        /**
         * return collection
         */ 
        return parent::_prepareCollection ();
    }
    /**
     * Filter stores from row
     */ 
    protected function _filterStoreCondition($collection, $column) {
        if (! $value = $column->getFilter ()->getValue ()) {
            return;
        }
        $this->getCollection ()->addStoreFilter ( $value );
    }
    /**
     * Prepare column from delivery schedule types collection
     */ 
    protected function _prepareColumns() {
        /**
         * Display column id
         */ 
        $this->addColumn ( 'id', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'ID' ),'align' => 'right','width' => '50px','index' => 'id') );
        /**
         * Display the column which is type  name
         */ 
        $this->addColumn ( 'name', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'Name' ),'align' => 'left','width' => '150px','index' => 'name') );
        /**
         * Display the column which is description
         */ 
        $this->addColumn ( 'description', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'Description' ),'width' => '250px','index' => 'description') );
        /**
         * Display the column which is store views
         */
        $this->addColumn ( 'store_view', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'Store Views' ),'index' => 'store_view','width' => '100px','type' => 'store','store_all' => true,'store_view' => true,'sortable' => true,'filter_condition_callback' => array ($this,'_filterStoreCondition')) );
        /**
         * Display the column which is status
         */
        $this->addColumn ( 'status', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'Status' ),'align' => 'left','width' => '80px','index' => 'status','type' => 'options','options' => array (1 => 'Enabled',2 => 'Disabled') ) );
        /**
         * Display the column which is Action
         */
        $this->addColumn ( 'action', array ('header' => Mage::helper ( 'deliveryschedule' )->__ ( 'Action' ),'width' => '100','type' => 'action','getter' => 'getId','actions' => array (array ('caption' => Mage::helper ( 'deliveryschedule' )->__ ( 'Edit' ), 'url' => array ('base' => '*/*/edit'),'field' => 'id')),'filter' => false,'sortable' => false,'index' => 'stores','is_system' => true) );
        /**
         * add the download options 'CSV', 'XML' 
         */
        $this->addExportType ( '*/*/exportCsv', Mage::helper ( 'deliveryschedule' )->__ ( 'CSV' ) );
        $this->addExportType ( '*/*/exportXml', Mage::helper ( 'deliveryschedule' )->__ ( 'XML' ) );
        /**
         * return prepare columns
         */
        return parent::_prepareColumns ();
    }
    /**
     * Prepare mass action which is grid multiple rows
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField ( 'id' );
        $this->getMassactionBlock ()->setFormFieldName ( 'deliveryschedule' );
        /**
         * Multiple delete option in grid
         */
        $this->getMassactionBlock ()->addItem ( 'delete', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Delete' ),'url' => $this->getUrl ( '*/*/massDelete' ),'confirm' => Mage::helper ( 'deliveryschedule' )->__ ( 'Are you sure?' )) );
        /**
         * Chnage status option for multiple rows
         */
        $statuses = Mage::getSingleton ( 'deliveryschedule/status' )->getOptionArray ();
        /**
         * prepends the another array values
         */ 
        array_unshift ( $statuses, array (
                'label' => '',
                'value' => '' 
        ) );
        $this->getMassactionBlock ()->addItem ( 'status', array ('label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Change status' ),'url' => $this->getUrl ( '*/*/massStatus', array ('_current' => true) ),'additional' => array ('visibility' => array ('name' => 'status','type' => 'select','class' => 'required-entry','label' => Mage::helper ( 'deliveryschedule' )->__ ( 'Status' ),'values' => $statuses) )));
        return $this;
    }
    /**
     * getRowUrl() - for edit the row from grid
     */
    public function getRowUrl($row) {
        return $this->getUrl ( '*/*/edit', array (
                'id' => $row->getId () 
        ) );
    }
}