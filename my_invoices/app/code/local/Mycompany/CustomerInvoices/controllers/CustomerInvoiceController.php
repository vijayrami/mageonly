<?php
class Mycompany_CustomerInvoices_CustomerInvoiceController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("Invoices"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link"  => Mage::getBaseUrl()
        ));

        $breadcrumbs->addCrumb("customer-invoices", array(
            "label" => $this->__("Invoices"),
            "title" => $this->__("Invoices")
        ));
        $this->renderLayout();
    }


    public function viewAction() {
        $orderId = (int) $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($this->_canViewOrder($order)) {
            $invoices = Mage::getResourceModel('sales/order_invoice_collection')
                ->setOrderFilter($order->getId())
                ->load();
            if ($invoices->getSize() > 0) {
                $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);

                return $this->_prepareDownloadResponse(
                    'invoice-'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(),
                    'application/pdf'
                );

            }
        }
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();

        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    protected function _canViewOrder($order)
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $availableStates = Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates();
        if ($order->getId() && $order->getCustomerId() && ($order->getCustomerId() == $customerId)
            && in_array($order->getState(), $availableStates, $strict = true)
        ) {
            return true;
        }
        return false;
    }
}