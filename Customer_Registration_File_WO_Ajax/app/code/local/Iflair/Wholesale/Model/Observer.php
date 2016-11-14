<?php
class Iflair_Wholesale_Model_Observer extends Varien_Object{
    
    public function saveProofFile($observer){
        $fileName = null;
        $customer = $observer->getEvent()->getCustomer();
		$post = Mage::app()->getRequest()->getParams();			
    	//Mage::log($customer, null, 'proof.log', true);
        if(isset($_FILES['proof_document'])){
        	$post = Mage::app()->getRequest()->getParams();		
            $avatarFile = ($_FILES['proof_document']) ? $_FILES['proof_document'] : $post['prev_file'];			
            $avatar = Mage::getModel('customer/customer');
            $avatar->setProof($avatarFile);
            try{
                $avatarFilenName = ($_FILES['proof_document']['name']) ? time().'_'.$_FILES['proof_document']['name'] : $post['prev_file'];
                $customer->setData('proof', $avatarFilenName);
            }catch(Exception $e){
                Mage::logException($e);
            }
        } 
        
        return $this;
    }    
}