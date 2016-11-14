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
class Apptha_Deliveryschedule_Model_Sales_Quote_Address_Total_Deliverycost extends Mage_Sales_Model_Quote_Address_Total_Abstract{
    /**
     * set code for display delivery cost
     */
    protected $_code = 'deliveryschedule';
 /**
  *  collect(Mage_Sales_Model_Quote_Address $address)- used to set subtotal and grand total amount based on delivery cost
  */
    public function collect(Mage_Sales_Model_Quote_Address $address)  {
        parent::collect($address);
        $this->_setAmount(0);
        $this->_setBaseAmount(0);
 
        $items = $this->_getAddressItems($address);
        if (!count($items)) { 
            /**
             * this makes only address type shipping to come through
             */
            return $this; 
        }
        $quote = $address->getQuote();
        if(Mage::app()->getRequest()->getControllerName() == "checkout_cart"){
            $address->setDeliveryCost('');
            $address->setBaseDeliveryCost('');
            $quote->setShippingDeliveryCost('');
            $quote->setDeliveryCost('');
            $address->setGrandTotal($address->getGrandTotal() + 0);
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + 0);
            Mage::getSingleton ( 'core/session' )->setShippingDeliveryCost('');
        }
        else {
            $deliveryCost=$quote->getShippingDeliveryCost();
            $address->setDeliveryCost($deliveryCost);
            $address->setBaseDeliveryCost($deliveryCost);
            $quote->setDeliveryCost($deliveryCost);
            $address->setGrandTotal($address->getGrandTotal() + $address->getDeliveryCost());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseDeliveryCost());
            Mage::getSingleton ( 'core/session' )->setShippingDeliveryCost($deliveryCost);
        }
    }
 /**
  * fetch(Mage_Sales_Model_Quote_Address $address) - used to set a delivery cost before the grnd total
  */
    public function fetch(Mage_Sales_Model_Quote_Address $address) {
        $amt = $address->getDeliveryCost();
        /**
         * check if $amt is not zero 
         */
        if($amt !=0){
            $address->addTotal(array(
                    'code'=>$this->getCode(),
                    'title'=>Mage::helper('deliveryschedule')->__('Delivery Cost'),
                    'value'=> $amt
            ));
        }
       /**
        * return array
        */
        return $this;
    }
}

    