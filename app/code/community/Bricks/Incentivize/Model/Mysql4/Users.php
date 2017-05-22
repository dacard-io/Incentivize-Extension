<?php
	class Bricks_Incentivize_Model_Mysql4_Users extends Mage_Core_Model_Mysql4_Abstract {
		// Create construct for initializing the mysql database for this module
		protected function _construct() {
			$this->_init('incentivize/users', 'customer_id'); // Table in name is actually named incentivize_anything
		}
		// Load the incentivize table using the customer_id index
	}