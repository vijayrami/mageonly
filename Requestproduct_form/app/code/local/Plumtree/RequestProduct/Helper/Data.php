<?php 
class Plumtree_RequestProduct_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getUserFirstName()
	{
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			return '';
		}
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		return trim($customer->getFirstname());
	}
	
	public function getUserLastName()
	{
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			return '';
		}
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		return trim($customer->getLastname());
	}
	public function getUserEmail()
	{
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			return '';
		}
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		return $customer->getEmail();
	}
}