<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        /**
         * Tell Magento which collection to use for displaying the grid
         */
        $collection = Mage::getModel('incentivize/users')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, redorect user to set url
         */
        return $this->getUrl(
          'incentivize/submitted/view',
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        /**
         * Here we define the columns to display in the grid
         */

        $this->addColumn('customer_id', array(
            'header' => $this->_getHelper()->__('ID'),
            'type' => 'number',
            'index' => 'customer_id',
        ));
        $this->addColumn('firstname', array(
            'header' => $this->_getHelper()->__('First Name'),
            'type' => 'text',
            'index' => 'firstname',
        ));
        $this->addColumn('lastname', array(
            'header' => $this->_getHelper()->__('Last Name'),
            'type' => 'text',
            'index' => 'lastname',
        ));
        $this->addColumn('email', array(
            'header' => $this->_getHelper()->__('Email'),
            'type' => 'text',
            'index' => 'email',
        ));
        $this->addColumn('signdate', array(
            'header' => $this->_getHelper()->__('Sign Date'),
            'type' => 'timestamp',
            'index' => 'signdate',
        ));

        // Don't know what this line does...
        $submittedSingleton = Mage::getSingleton('incentivize/users');

        /**
         * Then add the columns with the Send Coupon, View, and Delete Button
         */
        $this->addColumn('action', array(
           'header' => $this->_getHelper()->__('Actions'),
            'width' => '100px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Send Coupon'),
                    'url' => array(
                        'base' => 'incentivize'.'/submitted/send',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'customer_id',
        ));

        /* Add export options in version 2 */
        //$this->addExportType('*/*/exportCsv', $this->_getHelper()->__('CSV'));
        //$this->addExportType('*/*/exportExcel', $this->_getHelper()->__('Excel XML'));
        
        return parent::_prepareColumns(); // Return the columns
    }

    protected function _getHelper()
    {
        return Mage::helper('bricks_incentivize');
    }
}