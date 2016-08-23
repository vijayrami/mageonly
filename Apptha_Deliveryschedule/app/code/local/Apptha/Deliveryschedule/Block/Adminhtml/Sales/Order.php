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
class Apptha_Deliveryschedule_Block_Adminhtml_Sales_Order extends Mage_Sales_Block_Order_Totals {
    /**
     * _initTotals() - display delivery cost and label into grand total
     */
        protected function _initTotals() {
            parent::_initTotals(); 
           /**
            * get delivery amount from sales order
            */
            $amt = $this->getSource()->getDeliveryCost();
            $baseAmt = $this->getSource()->getDeliveryCost();
            /**
             * check the $amt is not equal to zero
             */
            if ($amt != 0) {
                $this->addTotal(new Varien_Object(array(
                        'code' => 'deliveryschedule',
                        'value' => $amt,
                        'base_value' => $baseAmt,
                        'label' => 'Delivery Cost',
                )), 'deliveryschedule');
            }
            /**
             * return $this array
             */
            return $this;
        }
    
    }