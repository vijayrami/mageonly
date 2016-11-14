<?php
/**
 * Mycompany_Mycontact extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Mycompany
 * @package        Mycompany_Mycontact
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Mycontact module install script
 *
 * @category    Mycompany
 * @package     Mycompany_Mycontact
 * @author      Ultimate Module Creator
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('mycompany_mycontact/contactinquiry'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Contact Inquiry Data ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Name'
    )
    ->addColumn(
        'email',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Email'
    )
    ->addColumn(
        'mobile',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Mobile'
    )
    ->addColumn(
        'city',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'City'
    )
    ->addColumn(
        'pincode',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Pincode'
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
        'Contact Inquiry Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Contact Inquiry Data Creation Time'
    ) 
    ->setComment('Contact Inquiry Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
