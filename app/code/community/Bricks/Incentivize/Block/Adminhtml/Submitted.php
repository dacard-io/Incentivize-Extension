<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct(); // Still don't know what this does

        /*
         * the _blockGroup property tells Magento which alias to use to locate the
         * blocks to be displayed within this grid container. So it should be in
         * the directory Bricks/Incentivize/Block/Adminhtml
         */
        $this->_blockGroup = 'bricks_incentivize_adminhtml';

        /**
         * _controller refers to the folder containing the Grid.php and View.php. So
         * in this module, its in Bricks/Incentivize/Block/Adminhtml/Submitted, so in
         * this case it would be 'submitted'
         */
        $this->_controller = 'submitted';

        /**
         * The title of the page in the admin panel (look for the node declared in adminhtml.xml)
         */
        $this->_headerText = Mage::helper('bricks_incentivize')
            ->__('Submitted Emails');
    }

    // This code controls the redirect for the 'Add New' button
    public function getCreateUrl()
    {
        /**
         * When the Add button is clicked, this is where the user will be redirected
         */
        return $this->getUrl(
            'incentivize/submitted/view'
        );
    }


    protected function _prepareLayout() {
        $this->_removeButton('add');  // Remove unused buttons
        return parent::_prepareLayout();
    }
}