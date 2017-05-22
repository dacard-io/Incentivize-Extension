<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted_View extends  Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'bricks_incentivize_adminhtml';
        $this->_controller = 'submitted';

        /**
         * The _mode property tells Magento which folder to locate the
         * related form blocks to be displayed within this form container.
         * In this module, the form is in Incentivize/Block/Adminhtml/Submitted/View/
         */
        $this->_mode = 'view';

        $this->_headerText = $this->__('View Incentivized Customer');
    }

    // Strange, removing buttons doesn't work in _construct, only in _prepareLayout
    protected function _prepareLayout() {
        /* Remove save button, since user information is declared by the customer */
        $this->_removeButton("save");

        return parent::_prepareLayout();
    }
}