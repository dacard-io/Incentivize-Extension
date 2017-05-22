<?php
	class Bricks_Incentivize_Model_Mysql4_Users_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
		// Create construct for initializing a collection from the mysql database for this module
		protected function _construct() {
			$this->_init('incentivize/users');
		}
	}