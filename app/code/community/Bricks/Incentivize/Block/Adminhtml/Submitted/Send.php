<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted_Send extends  Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'bricks_incentivize_adminhtml';
        $this->_controller = 'submitted';

        /**
         * The _mode property tells Magento which folder to locate the
         * related form blocks to be displayed within this form container.
         * In this module, the form is in Incentivize/Block/Adminhtml/Submitted/Send/
         */
        $this->_mode = 'send';


        $this->_headerText = $this->__('Send Coupon');
    }

    // Strange, removing buttons doesn't work in _construct, only in _prepareLayout
    protected function _prepareLayout() {
        $this->_removeButton('reset');  // Remove unused buttons
        $this->_removeButton('delete');
        $this->_removeButton('save');

        return parent::_prepareLayout();
    }
}