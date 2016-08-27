<?php
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('mycompany_contactsave/contactdata'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Contact Data ID'
    )
    ->addColumn(
        'customer_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Customer Name'
    )
    ->addColumn(
        'customer_email',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Customer Email'
    )
    ->addColumn(
        'customer_phone',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer Telephone'
    )
    ->addColumn(
        'customer_fax',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer Fax'
    )
    ->addColumn(
        'customer_company',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer Company Name'
    )
    ->addColumn(
        'customer_comment',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(
            'nullable'  => false,
        ),
        'Customer Comment'
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
        'Contact Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Contact Data Creation Time'
    ) 
    ->setComment('Contact Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
