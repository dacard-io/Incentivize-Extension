<?php
/*
 * There are many ways to create the setup file for Magento, but lets do
 * it the proper way by using Varien!
 */
$table = new Varien_Db_Ddl_Table();

/*
 * This is an alias to the real name of the database table, which is
 * configured in config.xml
 */

$table->SetName($this->getTable('incentivize'));


/*
 * Add the columns needed.
 */
$table->addColumn(
    'customer_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'auto_increment' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    )
);
$table->addColumn(
    'firstname',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'lastname',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'email',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'signdate',
    Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
    null,
    array(
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    )
);

/* And two extremely important lines below */
$table->setOption('type', 'InnoDB');
$table->setOption('charset', 'utf8');

/* Create the table */
$this->getConnection()->createTable($table);
$this->endSetup();

/*
 * Below is the rudimentary way of setting up a table.
 */
/*
$installer = $this;
$installer->startSetup();
$installer->run("
	-- DROP TABLE IF EXISTS `{$installer->getTable('incentivize')}`;

	CREATE TABLE `{$installer->getTable('incentivize')}` (
		`customer_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`firstname` varchar(255) NOT NULL default '',
		`lastname` varchar(255) NOT NULL default '',
		`email` varchar(255) NOT NULL default '',
		`signdate` timestamp NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); */

/* Please be careful with these install scripts for the love of god */