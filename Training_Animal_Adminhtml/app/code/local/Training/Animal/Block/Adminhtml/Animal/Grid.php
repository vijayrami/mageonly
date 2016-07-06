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
 * Animal admin grid block
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Block_Adminhtml_Animal_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('animalGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Training_Animal_Block_Adminhtml_Animal_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('training_animal/animal')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Training_Animal_Block_Adminhtml_Animal_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('training_animal')->__('Id'),
            	'sortable' => true,
            	'width' => '60px',
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('training_animal')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            	'column_css_class' => 'name'
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('training_animal')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('training_animal')->__('Enabled'),
                    '0' => Mage::helper('training_animal')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'type',
            array(
                'header' => Mage::helper('training_animal')->__('Animal Type'),
                'index'  => 'type',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'edible',
            array(
                'header' => Mage::helper('training_animal')->__('Is Edible'),
            	'width'  => '100px',
                'index'  => 'edible',
                'type'    => 'options',
            	'options' => Mage::helper('training_animal')->convertOptions(
                    Mage::getModel('training_animal/animal_attribute_source_edible')->getAllOptions(false)
                )
            )
        );
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('training_animal')->__('Store Views'),
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
                'header' => Mage::helper('training_animal')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('training_animal')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('training_animal')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('training_animal')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('training_animal')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('training_animal')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('training_animal')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Training_Animal_Block_Adminhtml_Animal_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('animal');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('training_animal')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('training_animal')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('training_animal')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('training_animal')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('training_animal')->__('Enabled'),
                            '0' => Mage::helper('training_animal')->__('Disabled'),
                        )
                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'edible',
            array(
                'label'      => Mage::helper('training_animal')->__('Change Is Edible'),
                'url'        => $this->getUrl('*/*/massEdible', array('_current'=>true)),
                'additional' => array(
                    'flag_edible' => array(
                        'name'   => 'flag_edible',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('training_animal')->__('Is Edible'),
                        'values' => array(
                                '1' => Mage::helper('training_animal')->__('Yes'),
                                '0' => Mage::helper('training_animal')->__('No'),
                            )

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
     * @param Training_Animal_Model_Animal
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
     * @return Training_Animal_Block_Adminhtml_Animal_Grid
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
     * @param Training_Animal_Model_Resource_Animal_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Training_Animal_Block_Adminhtml_Animal_Grid
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
