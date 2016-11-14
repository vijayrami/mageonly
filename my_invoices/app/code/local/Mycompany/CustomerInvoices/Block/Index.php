<?php

class Mycompany_CustomerInvoices_Block_Index extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('customer/account/myinvoices.phtml');

        $this->setInvoices( $this->getAllInvoices() );
    }

    public function getAllInvoices()
    {
        $invoices = Mage::getResourceModel('sales/order_invoice_collection');
        $select = $invoices->getSelect();
        $select->joinLeft(array('order' => Mage::getModel('core/resource')->getTableName('sales/order')), 'order.entity_id=main_table.order_id', array('customer_id' => 'customer_id'));
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $invoices->addFieldToFilter('customer_id',$customerId);
        return $invoices;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'invoices.pager');
        $pager->setAvailableLimit(array(10=>10, 15=>15, 30=>30, $this->getInvoices()->getSize() => $this->__('All') ));
        $pager->setCollection( $this->getInvoices() );

        $this->setChild('pager', $pager);
        $this->getInvoices()->load();

        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}