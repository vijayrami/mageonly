<?php

class Mycompany_Customshipping_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * Carrier's code, as defined in parent class
     *
     * @var string
     */
    protected $_code = 'mycompany_customshipping';

    /**
     * Returns available shipping rates for Mycompany Customshipping carrier
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        /** @var Mycompany_Customshipping_Helper_Data $expressMaxPrice */        
        $expressMaxPrice = Mage::getStoreConfig('carriers/mycompany_customshipping/express_max_price',Mage::app()->getStore());
        $defaultShippingPrice = Mage::getStoreConfig('carriers/mycompany_customshipping/default_shipping_price',Mage::app()->getStore());
        
        $expressAvailable = false;
        $standardAvailable = false;       
        
        $quote = Mage::getModel('checkout/session')->getQuote();
        $quoteData= $quote->getData();
        $grandTotal= floatval ($quoteData['grand_total']);
        
        foreach ($request->getAllItems() as $item) {
        	if ($item->getProduct ()->isVirtual () || $item->getParentItem ()) {
        		continue;
        	}
        	
        	if ($item->getHasChildren () && $item->isShipSeparately ()) {
        		foreach ( $item->getChildren () as $child ) {
        			if ($child->getFreeShipping () && ! $child->getProduct ()->isVirtual ()) {
        				$product_id = $child->getProductId ();
        				$productObj = Mage::getModel ( 'catalog/product' )->load ( $product_id );
        				$ship_price = $productObj->getData ( 'custom_shipping_price' ); // our shipping attribute code
        				if ($ship_price == NULL) {
        					$price += ( float ) $defaultShippingPrice;
        				} else {
        					$price += ( float ) $ship_price;
        				}
        	
        			}
        		}
        	} else {
        		$product_id = $item->getProductId ();
        		$productObj = Mage::getModel ( 'catalog/product' )->load ( $product_id );
        		$ship_price = $productObj->getData ( 'custom_shipping_price' ); // our shipping attribute code
        		if ($ship_price == NULL) {
        			$price += ( float ) $defaultShippingPrice;
        		} else {
        			$price += ( float ) $ship_price;
        		}
        	
        	}
        }        
        //Mage::log($expressMaxPrice, null, 'totalprice.log', true);
        if ($grandTotal > intval($expressMaxPrice)) {
        	$expressAvailable = true;
        } else {
        	$standardAvailable = true;
        }
        
        if ($expressAvailable) {
            $result->append($this->_getExpressRate());
        } else {
        	$result->append($this->_getStandardRate($price));
        }
        return $result;
    }

    /**
     * Returns Allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array(
            'standard'    =>  'Standard delivery',
            'express'     =>  'Express delivery',
        );
    }

    /**
     * Get Standard rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getStandardRate($price)
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('standard');
        $rate->setMethodTitle('Standard delivery');
        $rate->setPrice($price);
        $rate->setCost(0);

        return $rate;
    }

    /**
     * Get Express rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getExpressRate()
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('express');
        $rate->setMethodTitle('Express delivery');
        $rate->setPrice(0);
        $rate->setCost(0);

        return $rate;
    }
}