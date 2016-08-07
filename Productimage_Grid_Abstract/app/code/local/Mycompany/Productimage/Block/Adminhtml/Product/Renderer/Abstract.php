<?php

Abstract class Mycompany_Productimage_Block_Adminhtml_Product_Renderer_Abstract extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $product = $row->load($row->getId());
        $proimage ='';
        if ($this->getMediaImage($product) != "no_selection" && $this->getMediaImage($product) != "" ) {
            $proimage = Mage::getModel('catalog/product_media_config')->getMediaUrl($this->getMediaImage($product));
            } else if ($this->getPlaceholder()) {
            $proimage = Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl() . '/placeholder/' . $this->getPlaceholder();
            }
        $width = filter_var(Mage::getStoreConfig('productimage/grid_config/image_width'), FILTER_SANITIZE_NUMBER_INT);
        $height = filter_var(Mage::getStoreConfig('productimage/grid_config/image_height'), FILTER_SANITIZE_NUMBER_INT);
        if ($proimage != '') {
            echo "<image src='" . $proimage . "' width='" . $width . "' height='" . $height . "'/>";
        }
        return parent::_toHtml();
    }
    

    abstract public function getMediaImage($product);
    abstract public function getPlaceholder();
}