<?php
class Mycompany_Productimage_Block_Adminhtml_Product_Renderer_ThumbnailImage extends Mycompany_Productimage_Block_Adminhtml_Product_Renderer_Abstract
{
    
    public function getMediaImage($product){
         return $product->getThumbnail();
    }
    
     public function getPlaceholder(){
        return Mage::getStoreConfig("catalog/placeholder/thumbnail_placeholder");
    }
}
