<?php
	class Bricks_Incentivize_Model_Users extends Mage_Core_Model_Abstract {

		protected function _construct() {
			/*
			 * Tell Magento where the related MySQL model can be found
			 */
			$this->_init('incentivize/users'); // Table in name is actually named incentivize_anything
		}
	}