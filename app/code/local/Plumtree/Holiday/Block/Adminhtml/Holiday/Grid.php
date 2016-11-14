<?php
/**
 * Plumtree_Holiday extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Plumtree
 * @package        Plumtree_Holiday
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Holiday admin grid block
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_Block_Adminhtml_Holiday_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('holidayGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('plumtree_holiday/holiday')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('plumtree_holiday')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'holiday_name',
            array(
                'header'    => Mage::helper('plumtree_holiday')->__('Holiday Name'),
                'align'     => 'left',
                'index'     => 'holiday_name',
            )
        );
        
        $this->addColumn(
            'from_date',
            array(
                'header' => Mage::helper('plumtree_holiday')->__('From Date'),
                'index'  => 'from_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'end_date',
            array(
                'header' => Mage::helper('plumtree_holiday')->__('End Date'),
                'index'  => 'end_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('plumtree_holiday')->__('status'),
                'index'  => 'status',
                'type'  => 'options',
                'options' => Mage::helper('plumtree_holiday')->convertOptions(
                    Mage::getModel('plumtree_holiday/holiday_attribute_source_holidaystatus')->getAllOptions(false)
                )

            )
        );
        /*if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('plumtree_holiday')->__('Store Views'),
                    'index'      => 'store_id',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                )
            );
        }
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('plumtree_holiday')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('plumtree_holiday')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );*/
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('plumtree_holiday')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('plumtree_holiday')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('plumtree_holiday')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('plumtree_holiday')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('plumtree_holiday')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('holiday');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('plumtree_holiday')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('plumtree_holiday')->__('Are you sure?')
            )
        );
        
        $this->getMassactionBlock()->addItem(
            'holiday_status',
            array(
                'label'      => Mage::helper('plumtree_holiday')->__('Change Holiday Status'),
                'url'        => $this->getUrl('*/*/massHolidayStatus', array('_current'=>true)),
                'additional' => array(
                    'flag_holiday_status' => array(
                        'name'   => 'flag_holiday_status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('plumtree_holiday')->__('Holiday Status'),
                        'values' => Mage::getModel('plumtree_holiday/holiday_attribute_source_holidaystatus')
                            ->getAllOptions(true),

                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Plumtree_Holiday_Model_Holiday
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     *
     * @access protected
     * @param Plumtree_Holiday_Model_Resource_Holiday_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Plumtree_Holiday_Block_Adminhtml_Holiday_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
