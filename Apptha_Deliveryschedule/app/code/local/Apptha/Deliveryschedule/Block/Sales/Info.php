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

/**
 * Invoice view  comments form
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Apptha_Deliveryschedule_Block_Sales_Info extends Mage_Core_Block_Template
{
    protected $_links = array();

    protected function _construct()
    { 
        parent::_construct();
        $this->setTemplate('deliveryschedule/info.phtml');
    }

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->__('Order # %s', $this->getOrder()->getRealOrderId()));
        }
        $this->setChild(
            'payment_info',
            $this->helper('payment')->getInfoBlock($this->getOrder()->getPayment())
        );
    }

    public function getPaymentInfoHtml()
    {
        return $this->getChildHtml('payment_info');
    }

    /**
     * Retrieve current order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('current_order');
    }

    public function addLink($name, $path, $label)
    {
        $this->_links[$name] = new Varien_Object(array(
            'name' => $name,
            'label' => $label,
            'url' => empty($path) ? '' : Mage::getUrl($path, array('order_id' => $this->getOrder()->getId()))
        ));
        return $this;
    }

    public function getLinks()
    {
        $this->checkLinks();
        return $this->_links;
    }

    private function checkLinks()
    {
        $order = $this->getOrder();
        if (!$order->hasInvoices()) {
            unset($this->_links['invoice']);
        }
        if (!$order->hasShipments()) {
            unset($this->_links['shipment']);
        }
        if (!$order->hasCreditmemos()) {
            unset($this->_links['creditmemo']);
        }
    }

    /**
     * Get url for reorder action
     *
     * @deprecated after 1.6.0.0, logic moved to new block
     * @param Mage_Sales_Order $order
     * @return string
     */
    public function getReorderUrl($order)
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            return $this->getUrl('sales/guest/reorder', array('order_id' => $order->getId()));
        }
        return $this->getUrl('sales/order/reorder', array('order_id' => $order->getId()));
    }

    /**
     * Get url for printing order
     *
     * @deprecated after 1.6.0.0, logic moved to new block
     * @param Mage_Sales_Order $order
     * @return string
     */
    public function getPrintUrl($order)
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            return $this->getUrl('sales/guest/print', array('order_id' => $order->getId()));
        }
        return $this->getUrl('sales/order/print', array('order_id' => $order->getId()));
    }

}
