<?php
class Mycompany_Productimage_Block_Adminhtml_Product_Renderer_BaseImage extends Mycompany_Productimage_Block_Adminhtml_Product_Renderer_Abstract
{
      
    public function getMediaImage($product){
         return $product->getImage();
    }
    public function getPlaceholder(){
        return Mage::getStoreConfig("catalog/placeholder/image_placeholder");
    }
}
