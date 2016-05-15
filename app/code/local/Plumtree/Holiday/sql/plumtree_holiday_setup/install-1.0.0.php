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
 * Holiday module install script
 *
 * @category    Plumtree
 * @package     Plumtree_Holiday
 * @author      Ultimate Module Creator
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('plumtree_holiday/holiday'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Holiday ID'
    )
    ->addColumn(
        'from_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(
            'nullable'  => false,
        ),
        'From Date'
    )
    ->addColumn(
        'end_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(
            'nullable'  => false,
        ),
        'End Date'
    )
    ->addColumn(
        'holiday_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Holiday Name'
    )
    ->addColumn(
        'holiday_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable'  => false,
        ),
        'Holiday Status'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Holiday Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Holiday Creation Time'
    ) 
    ->setComment('Holiday Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('plumtree_holiday/holiday_store'))
    ->addColumn(
        'holiday_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'nullable'  => false,
            'primary'   => true,
        ),
        'Holiday ID'
    )
    ->addColumn(
        'store_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Store ID'
    )
    ->addIndex(
        $this->getIdxName(
            'plumtree_holiday/holiday_store',
            array('store_id')
        ),
        array('store_id')
    )
    ->addForeignKey(
        $this->getFkName(
            'plumtree_holiday/holiday_store',
            'holiday_id',
            'plumtree_holiday/holiday',
            'entity_id'
        ),
        'holiday_id',
        $this->getTable('plumtree_holiday/holiday'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $this->getFkName(
            'plumtree_holiday/holiday_store',
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id',
        $this->getTable('core/store'),
        'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Holidays To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();
