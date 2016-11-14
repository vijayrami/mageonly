<?php 
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Contact Inquiry Data helper
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
class Mycompany_Mycontact_Helper_Contactinquiry extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the contact inquiry datas list page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getContactinquiriesUrl()
    {
        if ($listKey = Mage::getStoreConfig('mycompany_mycontact/contactinquiry/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('mycompany_mycontact/contactinquiry/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('mycompany_mycontact/contactinquiry/breadcrumbs');
    }
}
