<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // Instantiate a new form to display incentivize customer for viewing
        $form = new Varien_Data_Form(array(
            'id' => 'view_form',
            'action' => $this->getUrl(
                'incentivize/submitted/view',
                array(
                    '_current' => true,
                )
            ),
            'method' => 'post',
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        // Define a new fieldset, only one is necassary
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Customer Details')
            )
        );

        // Pull data to populate user fields
        $idParam = $this->getRequest()->getParam('id');
        $incentivizeCustomer = Mage::getModel('incentivize/users');
        $incentivizeCustomer->load($idParam); // load pulls the data with the specified primary key indicated in the model resource

        // Add the fields we want to be editable
        $fieldset->addField('firstname', 'text', array(
            'label'     => Mage::helper('bricks_incentivize')->__('First  Name'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'firstname',
            'value'  => $incentivizeCustomer->getFirstname(),
            'readonly' => true,
            'disabled' => false,
            'after_element_html' => '<small>First name of Incentivized Customer</small>',
            'tabindex' => 1
        ));
        $fieldset->addField('lastname', 'text', array(
            'label'     => Mage::helper('bricks_incentivize')->__('Last  Name'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'lastname',
            'value'  => $incentivizeCustomer->getLastname(),
            'readonly' => true,
            'disabled' => false,
            'after_element_html' => '<small>Last name of Incentivized Customer</small>',
            'tabindex' => 2
        ));
        $fieldset->addField('email', 'text', array(
            'label'     => Mage::helper('bricks_incentivize')->__('Email'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'email',
            'value'  => $incentivizeCustomer->getEmail(),
            'disabled' => true,
            'readonly' => true,
            'after_element_html' => '<small>Email of Incentivized Customer</small>',
            'tabindex' => 3
        ));

        // Return the form
        return parent::_prepareForm();
    }
}