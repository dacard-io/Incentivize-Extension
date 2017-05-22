<?php
class Bricks_Incentivize_Adminhtml_SubmittedController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Load the grid container block and add to the page content.
	 */
	public function IndexAction() {

		// Instantiate the grid container
		$submittedBlock = $this->getLayout()
			->createBlock('bricks_incentivize_adminhtml/submitted');

		// Add the grid container as the item on the page, and set the active menu item and title
		$this->loadLayout()
			->_setActiveMenu('bricks/submitted_emails')
			->_title('Submitted Emails / Incentivize')
			->_addContent($submittedBlock)
			->renderLayout();
	}

	/* Action to handle sending emails to customers */
	public function sendAction() {
		// If
		if ($this->getRequest()->getParam('continue')) {
			echo "It sent!";
		}
		// Instantiate the grid container
		$submittedBlock = $this->getLayout()
			->createBlock('bricks_incentivize_adminhtml/submitted_send');

		// Add the grid container as the item on the page, and set the active menu item and title
		$this->loadLayout()
			->_setActiveMenu('bricks/submitted_emails')
			->_title('Send Coupon / Incentivize')
			->_addContent($submittedBlock)
			->renderLayout();
	}

	/* Action to handle viewing and editing incentivized customer */
	public function viewAction()
	{
		// Retrieve existing customer data if ID was specified
		$customer = Mage::getModel('incentivize/users');

		if($customer_id = $this->getRequest()->getParam('customer_id', false)) {
			$customer->load($customer_id);

			// If Customer ID not found, show error, and redirect
			if ($customer->getCustomerId() < 1) {
				$this->_getSession()->addError(
					$this->__('This customer no longer exists')
				);
				return $this->_redirect(
					'bricks_incentivize_adminhtml/submitted/index'
				);
			}
		}

		// Make customer_id available to blocks
		//Mage::register('current_id', $customer_id);

		// Instantiate the form container
		$viewBlock = $this->getLayout()->createBlock(
			'bricks_incentivize_adminhtml/submitted_view'
		);

		$this->loadLayout()
			->_addContent($viewBlock)
			->renderLayout();
	}

	/* Action to handle deletion of an incentivized customer */
	public function deleteAction()
	{
		$customerId = $this->getRequest()->getParam('id');
		$customerModel = Mage::getModel('incentivize/users');
		$customer = $customerModel->load($customerId);
		// Delete the incentivized user
		$customer->delete();

		// Send a success message
		Mage::getSingleton('core/session')->addSuccess('Incentivized user deleted');

		// Instantiate the form container
		$viewBlock = $this->getLayout()->createBlock(
			'bricks_incentivize_adminhtml/submitted'
		);

		$this->loadLayout()
			->_addContent($viewBlock)
			->renderLayout();
	}

	/**
	 * Now create the exporter actions
	 */
	/* Add this in version 2!
	public function exportCsvAction()
	{
		$fileName = 'incentivized_customers.csv';
		$submittedBlock = $this->getLayout()
			->createBlock('bricks_incentivize_adminhtml/submitted');

		$this->_prepareDownloadResponse($fileName, $submittedBlock->getCsvFile());
	}
	public function exportExcelAction()
	{
		$fileName = 'incentivized_customers.xml';
		$submittedBlock = $this->getLayout()
			->createBlock('bricks_incentivize_adminhtml/submitted');

		$this->_prepareDownloadResponse($fileName, $submittedBlock->getExcelFile($fileName));
	}

	/* Check if ACL rules permit the module from making any changes */
	/*protected function _isAllowed() {

	}*/
}