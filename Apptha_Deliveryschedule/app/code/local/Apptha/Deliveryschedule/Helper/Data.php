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
class Apptha_Deliveryschedule_Helper_Data extends Mage_Core_Helper_Abstract {
    public function getScheduleData($scheduleTypeId) {
    return Mage::getModel('deliveryschedule/deliveryschedule')->getCollection()->addFieldToFilter("status",1)->setOrder('sorting','ASC')->addFieldToFilter("schedule_type_id",$scheduleTypeId);
    }
    public function getScheduleTypes($storeId) {
    return Mage::getModel('deliveryschedule/deliveryscheduletypes')->getCollection()->addFieldToFilter("status",1)->setOrder('sorting','ASC')->addFieldToFilter("store_view",array("in"=>array('0',$storeId)));
    }
    public function getTimeById($shippingDeliveryTimeId){
        return Mage::getModel('deliveryschedule/deliveryschedule')->getCollection()->addFieldToFilter("deliveryschedule_id",$shippingDeliveryTimeId);
    }
    public function getScheduleTypeById($desiredDeliverySchedule){
        return Mage::getModel('deliveryschedule/deliveryscheduletypes')->getCollection()->addFieldToFilter("id",$desiredDeliverySchedule);
    }
    public function saveShippingDeliveryScedule($observer){
        $order = $observer->getEvent()->getOrder();
            $cart = Mage::getModel('checkout/cart')->getQuote()->getData();
            $desiredDeliverySchedule = $cart['shipping_delivery_schedule'];
            $shippingDeliveryComments = $cart['shipping_delivery_comments'];
            $shippingDeliveryDate = $cart['shipping_delivery_date'];
            $shippingDeliveryTimeId = $cart['shipping_delivery_time'];
            $shippingDeliveryCost = $cart['shipping_delivery_cost'];
            if (isset($shippingDeliveryDate) && !empty($shippingDeliveryDate)){
                $order->setShippingDeliveryComments($shippingDeliveryComments);
                $order->setShippingDeliverySchedule($desiredDeliverySchedule);
                $order->setShippingDeliveryDate($shippingDeliveryDate);
                $order->setShippingDeliveryTime($shippingDeliveryTimeId);
                $order->setShippingDeliveryCost($shippingDeliveryCost);
        }
    }
    }