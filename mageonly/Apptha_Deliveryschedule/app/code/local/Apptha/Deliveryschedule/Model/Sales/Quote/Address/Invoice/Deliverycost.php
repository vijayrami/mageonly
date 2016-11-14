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
 * extend Mage_Sales_Model_Order_Invoice_Total_Abstract for set invoice 
 */
class Apptha_Deliveryschedule_Model_Sales_Quote_Address_Invoice_Deliverycost extends Mage_Sales_Model_Order_Invoice_Total_Abstract {
    /**
     * collect(Mage_Sales_Model_Order_Invoice $invoice) - set invoice grand total based on delivery cost
     */
 public function collect(Mage_Sales_Model_Order_Invoice $invoice)    { 
        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getOrder()->getDeliveryCost());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getOrder()->getBaseDeliveryCost());
/**
 * return this grand total and base grand total
 */
        return $this;
    }
}

    