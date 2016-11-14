<?php
/**
 * Training_Animal extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Training
 * @package        Training_Animal
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Animal admin controller
 *
 * @category    Training
 * @package     Training_Animal
 * @author      Ultimate Module Creator
 */
class Training_Animal_Adminhtml_AnimalController extends Mage_Adminhtml_Controller_Action
{
    /**
     * init the animal
     *
     * @access protected
     * @return Training_Animal_Model_Animal
     */
    protected function _initAnimal()
    {
        $animalId  = (int) $this->getRequest()->getParam('id');
        $animal    = Mage::getModel('training_animal/animal');
        if ($animalId) {
            $animal->load($animalId);
        }
        Mage::register('current_animal', $animal);
        return $animal;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('training_animal')->__('Manage Animals'))
             ->_title(Mage::helper('training_animal')->__('Animals'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit animal - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $animalId    = $this->getRequest()->getParam('id');
        $animal      = $this->_initAnimal();
        if ($animalId && !$animal->getId()) {
            $this->_getSession()->addError(
                Mage::helper('training_animal')->__('This animal no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getAnimalData(true);
        if (!empty($data)) {
            $animal->setData($data);
        }
        Mage::register('animal_data', $animal);
        $this->loadLayout();
        $this->_title(Mage::helper('training_animal')->__('Manage Animals'))
             ->_title(Mage::helper('training_animal')->__('Animals'));
        if ($animal->getId()) {
            $this->_title($animal->getName());
        } else {
            $this->_title(Mage::helper('training_animal')->__('Add animal'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new animal action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save animal - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('animal')) {
            try {
                $animal = $this->_initAnimal();
                $animal->addData($data);
                $animal->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('training_animal')->__('Animal was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $animal->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setAnimalData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('training_animal')->__('There was a problem saving the animal.')
                );
                Mage::getSingleton('adminhtml/session')->setAnimalData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('training_animal')->__('Unable to find animal to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete animal - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $animal = Mage::getModel('training_animal/animal');
                $id = $this->getRequest()->getParam('id');
                $name = $animal->getName();
                $animal->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('training_animal')->__('%s (ID %d) was successfully deleted', $name, $id)
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('training_animal')->__('There was an error deleting animal.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('training_animal')->__('Could not find animal to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete animal - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $animalIds = $this->getRequest()->getParam('animal');
        if (!is_array($animalIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('training_animal')->__('Please select animals to delete.')
            );
        } else {
            try {
                foreach ($animalIds as $animalId) {
                    $animal = Mage::getModel('training_animal/animal');
                    $animal->setId($animalId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('training_animal')->__('Total of %d animals were successfully deleted.', count($animalIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('training_animal')->__('There was an error deleting animals.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $animalIds = $this->getRequest()->getParam('animal');
        if (!is_array($animalIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('training_animal')->__('Please select animals.')
            );
        } else {
            try {
                foreach ($animalIds as $animalId) {
                $animal = Mage::getSingleton('training_animal/animal')->load($animalId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d animals were successfully updated.', count($animalIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('training_animal')->__('There was an error updating animals.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Is Edible change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massEdibleAction()
    {
        $animalIds = $this->getRequest()->getParam('animal');
        if (!is_array($animalIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('training_animal')->__('Please select animals.')
            );
        } else {
            try {
                foreach ($animalIds as $animalId) {
                $animal = Mage::getSingleton('training_animal/animal')->load($animalId)
                    ->setEdible($this->getRequest()->getParam('flag_edible'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d animals were successfully updated.', count($animalIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('training_animal')->__('There was an error updating animals.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'animal.csv';
        $content    = $this->getLayout()->createBlock('training_animal/adminhtml_animal_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'animal.xls';
        $content    = $this->getLayout()->createBlock('training_animal/adminhtml_animal_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'animal.xml';
        $content    = $this->getLayout()->createBlock('training_animal/adminhtml_animal_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('training_animal/animal');
    }
}
