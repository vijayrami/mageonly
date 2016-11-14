<?php
/**
 * Plumtree_Holiday extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Plumtree
 * @package        Plumtree_Holiday
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Holiday front contrller
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
class Plumtree_Holiday_HolidayController extends Mage_Core_Controller_Front_Action
{
	
	public function productsAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('products.grid')
                ->setProdlist($this->getRequest()->getPost('products_prodlist', null));
        $this->renderLayout();
    }

}
