<?php
class Mycompany_Productimage_Block_Adminhtml_Product_Renderer_SmallImage extends Mycompany_Productimage_Block_Adminhtml_Product_Renderer_Abstract
{
     public function getMediaImage($product){
         return $product->getSmallImage();
    }
    
     public function getPlaceholder(){
        return Mage::getStoreConfig("catalog/placeholder/small_image_placeholder");
    }
}
