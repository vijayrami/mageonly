<?php

class Iflair_Wholesale_Block_Adminhtml_Customer_Form_Element_File extends Mage_Adminhtml_Block_Customer_Form_Element_File
{
     /**
     * Return Form Element HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $this->addClass('input-file');
        if ($this->getRequired()) {
            $this->removeClass('required-entry');
            $this->addClass('required-file');
        }

        $element = sprintf('<input id="%s" name="%s" %s />%s%s',
            $this->getHtmlId(),
        	// Remove Add file butoon for admin.
            //$this->getName(),
            $this->serialize($this->getHtmlAttributes()),
            $this->getAfterElementHtml(),
            $this->_getHiddenInput()
        );
		
        // Remove Checkbox for delete file.
        //return $this->_getPreviewHtml() . $element . $this->_getDeleteCheckboxHtml();
        return $this->_getPreviewHtml() . $element;
    }
}
