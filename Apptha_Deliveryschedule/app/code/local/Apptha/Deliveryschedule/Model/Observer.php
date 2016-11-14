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
class Apptha_Deliveryschedule_Model_Observer {
    /**
     * checkout_controller_onepage_save_shipping_method($observer) - for set delivery schedule information into quote
     */
    public function checkout_controller_onepage_save_shipping_method($observer) {
        /**
         * Check the delivery schedule module is enable or not
         */
        if (Mage::getStoreConfig ( 'deliveryschedule/general/delivery_schedule_enabled' ) == 1) {
            $request = $observer->getEvent ()->getRequest ();
            $quote = $observer->getEvent ()->getQuote ();
            $desiredDeliverySchedule = $request->getPost ( 'delivery_schedule_types');
            $shippingDeliveryTimeId = $request->getPost ( 'shipping_delivery_time' );
            $shippingDeliveryCost = $request->getPost ( 'shipping_delivery_cost' );
            $desireDeliveryDate = $request->getPost ( 'shipping_delivery_date' );
            $desireDeliveryComments = $request->getPost ( 'shipping_delivery_comments' );
            /**
             * shipping delivery time slot using id
             */
            $getTimeById = Mage::helper('deliveryschedule')->getTimeById($shippingDeliveryTimeId);
            /**
             * get delivery schedule type by id
             */
            $getScheduleTypeById = Mage::helper('deliveryschedule')->getScheduleTypeById($desiredDeliverySchedule);
            $title = $scheduleTypeName = "";
            foreach($getTimeById as $row){
                $title = $row->getTimeSlot();
            }
            foreach($getScheduleTypeById as $rows){
                $scheduleTypeName = $rows->getName();
            }
            /**
             * check the delivery date is not equal to empty 
             */
            if (isset ( $desireDeliveryDate ) && ! empty ( $desireDeliveryDate )) {
                $quote->setShippingDeliverySchedule ( $scheduleTypeName );
                $quote->setShippingDeliveryComments ( $desireDeliveryComments );
                $quote->setShippingDeliveryDate ($desireDeliveryDate);
                $quote->setShippingDeliveryTime($title);
                $quote->setShippingDeliveryCost($shippingDeliveryCost);
                $quote->save ();
            }
        }
        /**
         * return this observer method
         */
        return $this;
    }
public function updatePaypalTotal(Varien_Event_Observer $observer)
    {
       $deliveryCost =  Mage::getSingleton ( 'core/session' )->getShippingDeliveryCost();
        /* @var $cart Mage_Paypal_Model_Cart */
        $cart = $observer->getEvent()->getPaypalCart();
        $cart->addItem('Delivery Cost', 1, $deliveryCost, 'Delivery Cost');
        return $this;
    }
}