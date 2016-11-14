<?php
class Mycompany_Contactsave_Block_Adminhtml_Contactdata_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('contactdataGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Mycompany_Contactsave_Block_Adminhtml_Contactdata_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mycompany_contactsave/contactdata')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Mycompany_Contactsave_Block_Adminhtml_Contactdata_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'customer_name',
            array(
                'header'    => Mage::helper('mycompany_contactsave')->__('Customer Name'),
                'align'     => 'left',
                'index'     => 'customer_name',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('mycompany_contactsave')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('mycompany_contactsave')->__('Enabled'),
                    '0' => Mage::helper('mycompany_contactsave')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'customer_email',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Customer Email'),
                'index'  => 'customer_email',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'customer_phone',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Customer Telephone'),
                'index'  => 'customer_phone',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'customer_fax',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Customer Fax'),
                'index'  => 'customer_fax',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'customer_company',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Customer Company Name'),
                'index'  => 'customer_company',
                'type'=> 'text',

            )
        );
        $this->addColumn(
        		'customer_comment',
        		array(
        				'header' => Mage::helper('mycompany_contactsave')->__('Customer Comment'),
        				'index'  => 'customer_comment',
        				'type'=> 'text',
        
        		)
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('mycompany_contactsave')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('mycompany_contactsave')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('mycompany_contactsave')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('mycompany_contactsave')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('mycompany_contactsave')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('mycompany_contactsave')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('mycompany_contactsave')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Mycompany_Contactsave_Block_Adminhtml_Contactdata_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('contactdata');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('mycompany_contactsave')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('mycompany_contactsave')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('mycompany_contactsave')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('mycompany_contactsave')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('mycompany_contactsave')->__('Enabled'),
                            '0' => Mage::helper('mycompany_contactsave')->__('Disabled'),
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
     * @param Mycompany_Contactsave_Model_Contactdata
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
     * @return Mycompany_Contactsave_Block_Adminhtml_Contactdata_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
