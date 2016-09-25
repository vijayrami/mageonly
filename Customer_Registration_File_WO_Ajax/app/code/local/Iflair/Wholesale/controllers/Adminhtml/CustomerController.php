<?php
include_once("Mage/Adminhtml/controllers/CustomerController.php");
class Iflair_Wholesale_Adminhtml_CustomerController extends Mage_Adminhtml_CustomerController {
    /*
     * Minor changes to show our logo as thumbnail in preview
     */
	const XML_WHOLESALE_FORM_ENABLED = 'customer/wholesale_group/customformfields_enabled';
    public function viewfileAction() {

        $file = null;
        $plain = false;
        if ($this->getRequest()->getParam('file')) {
            // download file
            $file = Mage::helper('core')->urlDecode($this->getRequest()->getParam('file'));
        } else if ($this->getRequest()->getParam('image')) {
            // show plain image
            $file = Mage::helper('core')->urlDecode($this->getRequest()->getParam('image'));
            $plain = true;
        } else {
            return $this->norouteAction();
        }
		
		if (Mage::getStoreConfigFlag(self::XML_WHOLESALE_FORM_ENABLED)){
			$path = Mage::getBaseDir('media') . DS . 'customer_documents/';
		} else {
			$path = Mage::getBaseDir('media') . DS . 'customer';
		}
        $ioFile = new Varien_Io_File();
        $ioFile->open(array('path' => $path));
        $fileName = $ioFile->getCleanPath($path . $file);
        $path = $ioFile->getCleanPath($path);
		
        if ((!$ioFile->fileExists($fileName) || strpos($fileName, $path) !== 0) && !Mage::helper('core/file_storage')->processStorageFile(str_replace('/', DS, $fileName))
        ) {
            return $this->norouteAction();
        }

        if ($plain) {
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            switch (strtolower($extension)) {
                case 'gif':
                    $contentType = 'image/gif';
                    break;
                case 'jpg':
                    $contentType = 'image/jpeg';
                    break;
                case 'png':
                    $contentType = 'image/png';
                    break;
                default:
                    $contentType = 'application/octet-stream';
                    break;
            }

            $ioFile->streamOpen($fileName, 'r');
            $contentLength = $ioFile->streamStat('size');
            $contentModify = $ioFile->streamStat('mtime');

            $this->getResponse()
                    ->setHttpResponseCode(200)
                    ->setHeader('Pragma', 'public', true)
                    ->setHeader('Content-type', $contentType, true)
                    ->setHeader('Content-Length', $contentLength)
                    ->setHeader('Last-Modified', date('r', $contentModify))
                    ->clearBody();
            $this->getResponse()->sendHeaders();

            while (false !== ($buffer = $ioFile->streamRead())) {
                echo $buffer;
            }
        } else {
            $name = pathinfo($fileName, PATHINFO_BASENAME);
            $this->_prepareDownloadResponse($name, array(
                'type' => 'filename',
                'value' => $fileName
            ));
        }

        exit();
    }

}
