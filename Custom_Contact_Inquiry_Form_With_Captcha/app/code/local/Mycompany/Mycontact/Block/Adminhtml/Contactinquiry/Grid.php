<?php
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Contact Inquiry Data admin grid block
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('contactinquiryGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mycompany_mycontact/contactinquiry')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('mycompany_mycontact')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('mycompany_mycontact')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('mycompany_mycontact')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('mycompany_mycontact')->__('Enabled'),
                    '0' => Mage::helper('mycompany_mycontact')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'email',
            array(
                'header' => Mage::helper('mycompany_mycontact')->__('Email'),
                'index'  => 'email',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'mobile',
            array(
                'header' => Mage::helper('mycompany_mycontact')->__('Mobile'),
                'index'  => 'mobile',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'city',
            array(
                'header' => Mage::helper('mycompany_mycontact')->__('City'),
                'index'  => 'city',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'pincode',
            array(
                'header' => Mage::helper('mycompany_mycontact')->__('Pincode'),
                'index'  => 'pincode',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('mycompany_mycontact')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('mycompany_mycontact')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('mycompany_mycontact')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('mycompany_mycontact')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('mycompany_mycontact')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('contactinquiry');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('mycompany_mycontact')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('mycompany_mycontact')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('mycompany_mycontact')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('mycompany_mycontact')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('mycompany_mycontact')->__('Enabled'),
                            '0' => Mage::helper('mycompany_mycontact')->__('Disabled'),
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
     * @param Mycompany_Mycontact_Model_Contactinquiry
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
     * @return Mycompany_Mycontact_Block_Adminhtml_Contactinquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
