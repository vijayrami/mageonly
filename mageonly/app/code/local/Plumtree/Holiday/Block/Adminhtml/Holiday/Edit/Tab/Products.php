<?php
class Plumtree_Holiday_Block_Adminhtml_Holiday_Edit_Tab_Products
    extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct(){
        parent::__construct();
        $this->setId('holidayLeftgrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
		$this->setDefaultFilter(array('in_products'=>1)); 
        $this->setUseAjax(true);
    }
   protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
	
	protected function _prepareCollection() {
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
                        ->addAttributeToSelect('sku')
                        ->addAttributeToSelect('name')
                        ->addAttributeToSelect('attribute_set_id')
                        ->addAttributeToSelect('type_id')
                        ->joinField('qty',
                                'cataloginventory/stock_item',
                                'qty',
                                'product_id=entity_id',
                                '{{table}}.stock_id=1',
                                'left');

        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute('name', 'catalog_product/name', 'entity_id', null, 'inner', $adminStore);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        } else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }
	
	protected function _addColumnFilterToCollection($column) {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField('websites',
                        'catalog/product_website',
                        'website_id',
                        'product_id=entity_id',
                        null,
                        'left');                
            } else if ($column->getId() == 'in_products') {
                $productIds = $this->_getSelectedProducts();
                if (empty($productIds)) {
                    $productIds = 0;
                }
                if ($column->getFilter()->getValue()) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
                } else {
                    if ($productIds) {                        
                        $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));                        
                    }
                }
            } else {
                parent::_addColumnFilterToCollection($column);
            }
        }
        return $this;;
    }
	
    protected function _prepareColumns(){
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_products',
            'values'=> $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'entity_id'
        ));
		$this->addColumn('entity_id',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('ID'),
                    'width' => '40px',
                    'type' => 'number',
                    'index' => 'entity_id',
        ));
		$this->addColumn('name',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Name'),
                    'index' => 'name',
        ));
		$store = $this->_getStore();
        if ($store->getId()) {
            $this->addColumn('custom_name',
                    array(
                        'header' => Mage::helper('plumtree_holiday')->__('Name in %s', $store->getName()),
                        'index' => 'custom_name',
            ));
        }
		 $this->addColumn('type',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Type'),
                    'width' => '60px',
                    'index' => 'type_id',
                    'type' => 'options',
                    'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
		$sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                        ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                        ->load()
                        ->toOptionHash();

        $this->addColumn('set_name',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Attrib. Set Name'),
                    'width' => '100px',
                    'index' => 'attribute_set_id',
                    'type' => 'options',
                    'options' => $sets,
        ));

        $this->addColumn('sku',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('SKU'),
                    'width' => '80px',
                    'index' => 'sku',
        ));
		$this->addColumn('qty',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Qty'),
                    'width' => '100px',
                    'type' => 'number',
                    'index' => 'qty',
        ));
		$this->addColumn('visibility',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Visibility'),
                    'width' => '70px',
                    'index' => 'visibility',
                    'type' => 'options',
                    'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('status',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Status'),
                    'width' => '70px',
                    'index' => 'status',
                    'type' => 'options',
                    'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
		if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites',
                    array(
                        'header' => Mage::helper('plumtree_holiday')->__('Websites'),
                        'width' => '100px',
                        'sortable' => false,
                        'index' => 'websites',
                        'type' => 'options',
                        'options' => Mage::getModel('core/website')->getCollection()->toOptionHash(),
            ));
        }
		$this->addColumn('action',
                array(
                    'header' => Mage::helper('plumtree_holiday')->__('Action'),
                    'width' => '50px',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('plumtree_holiday')->__('Edit'),
                            'url' => array(
                                'base' => 'adminhtml/catalog_product/edit',
                                'params' => array('store' => $this->getRequest()->getParam('store'))
                            ),
                            'field' => 'id'
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
        ));
        /*$this->addColumn('product_name', array(
            'header'=> Mage::helper('plumtree_holiday')->__('Name'),
            'align' => 'left',
            'index' => 'product_name',
        ));
        
        $this->addColumn('price', array(
            'header'=> Mage::helper('plumtree_holiday')->__('Price'),
            'type'  => 'currency',
            'width' => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        $this->addColumn('position', array(
            'header'=> Mage::helper('plumtree_holiday')->__('Position'),
            'name'  => 'position',
            'width' => 60,
            'type'  => 'number',
            'validate_class'=> 'validate-number',
            'index' => 'position',
            'editable'  => true,
        ));*/
		return parent::_prepareColumns();
    }
	
	public function getRowUrl(){
        return '#';
    }
	public function getGridUrl(){
        //return $this->getUrl('*/*/productsGrid', array(
            //'id'=>$this->get[Entity]()->getId()
        //));
		return $this->getUrl('*/*/productgrid', array('_current' => true));
    }
	protected function getHolidayData() {
        return Mage::registry('holiday_data');
    }
    protected function _getSelectedProducts(){
         $products = $this->getRequest()->getPost('selected_products');
		 
        /*if (!is_array($products)) {
            $products = array_keys($this->getSelectedProducts());
        }*/
        
		if (is_null($products)) {
			$id     = $this->getRequest()->getParam('id');
            if($id)
			{
				$model  = Mage::getModel('plumtree_holiday/holiday')->load($id);
				$products = explode(',', $model->getProductIds());
			}
			return (sizeof($products) > 0 ? $products : 0);
        }
        return $products;
    }
   /* public function getSelectedProducts() {
        $products = array();
        /*$selected = Mage::registry('current_[entity]')->getSelectedProducts();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition());
        }*/
		/*$sId = Mage::app()->getFrontController()->getRequest()->getParams();
        if (isset($sId)) {

            $model = Mage::getModel('holiday/holiday')->load($sId['id']);
            $products = $model->getItemProducts();
        }
        return $products;
    }
    
    
    /*public function get[Entity](){
        return Mage::registry('current_[entity]');
    }*/
    
}