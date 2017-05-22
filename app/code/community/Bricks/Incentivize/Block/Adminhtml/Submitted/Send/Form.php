<?php
class Bricks_Incentivize_Block_Adminhtml_Submitted_Send_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // Instantiate a new form to display incentivize customer for viewing
        $form = new Varien_Data_Form(array(
            'id' => 'view_form',
            'action' => $this->getUrl(
                'incentivize/submitted/send',
                array(
                    '_current' => true,
                )
            ),
            'method' => 'post',
        )); // The above code creates the action for the fieldset

        $form->setUseContainer(true);
        $this->setForm($form);

        // Define a new fieldset, only one is necassary
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Coupon Selection')
            )
        );

        // Pull available coupon data to populate option list
        $rulesCollection = Mage::getModel('salesrule/rule')->getCollection();
        $counter = 1;

        // Iterate through each shopping cart rule
        foreach($rulesCollection as $rule) {
            $coupon = $rule->getCoupons();
            // Iterate through each coupon in the current iterated shopping cart rule
            foreach ($coupon as $coupons) {
                $options[] = array(
                    'label' => $coupon[$counter]['code'],
                    'value' => $coupon[$counter]['code'],
                );
                $counter++;
            }
            /* GET THE FUCK OUTTA HERE I FUCKIN SOLVED IT! HOLY FUCKIN SHIT */

            /**
             * So its better to use '$arr[] = value' to append values to an array then
             * array_push() because it won't make a function call to your code. $arr[]
             * is more performant
             */
        };

        // Add the fields we want to be editable
        $fieldset->addField('couponselect', 'multiselect', array(
            'label'     => Mage::helper('bricks_incentivize')->__('Coupons'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'couponselect',
            'values'  => $options,
            'disabled' => false,
            'readonly' => true,
            'after_element_html' => '<small>Choose one or more coupons to send to the user</small>',
            'tabindex' => 1
        ));
        $fieldset->addField('sendcoupon', 'submit', array(
            'label'     => Mage::helper('bricks_incentivize')->__('Send Coupon'),
            'required'  => false,
            'value'  => 'Send Coupon',
            'after_element_html' => '<small>Send coupon to the current users email</small>',
            'tabindex' => 2
        ));

        //var_dump($this->getRequest()->getParam("couponselect")); // So couponselects data is in $_POST, you just can't see it without dumping the data

        $couponSelectParam = $this->getRequest()->getParam("couponselect");

        // Pull user and store data
        $idParam = $this->getRequest()->getParam('id'); // Get ID param value
        $incentivizeCustomer = Mage::getModel('incentivize/users')->load($idParam);

        $customerFirstname = $incentivizeCustomer->getFirstname(); // Pull customer firstname
        $customerLastname = $incentivizeCustomer->getLastname(); // Pull customer lastname
        $customerEmail = $incentivizeCustomer->getEmail(); // Pull user email address
        $store = Mage::app()->getStore(); // Why do I have to pull the store name in two steps?
        $storeName = $store->getName(); // Pull store name
        $storeEmail = Mage::getStoreConfig('trans_email/ident_general/email'); // Pull store general email

        // Now check if couponselect param has a value, if it does send an email
        if (isset($couponSelectParam)) {
            // Use a try and catch block for error checking
            try {
                // Load email template
                $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('incentivize_email_template');
                // Create variables to use inside the email template
                $emailTemplateVar = array(); // Declare the variable as an array first
                $emailTemplateVar['storeName'] = $storeName;
                $emailTemplateVar['firstName'] = $customerFirstname;
                $emailTemplateVar['lastName'] = $customerLastname;
                $emailTemplateVar['couponCodes'] = implode("<br/>", $couponSelectParam); // Use implode to separate the elements of the array, convert to string, and add line breaks to the output
                // Now inject the variables into the template, and it will return the parsed content to be used in the email
                $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVar);

                // Set $mail object settings (More in depth way of doing it - Keeping it for referential purposes)
                /*$mail = Mage::getModel('core/email')
                    ->setName('bilaa')
                    ->setToEmail('davidcardoso93@gmail.com')
                    ->setBody($processedTemplate)
                    ->setSubject('Subject :')
                    ->setFromEmail('billa@gmail.com')
                    ->setFromName('bilaa')
                    ->setType('html');*/
                // Send email
                // $mail->send();

                $emailTemplate->setSenderName($storeName);
                $emailTemplate->setSenderEmail($storeEmail); // This line MUST be included!
                $emailTemplate->setTemplateSubject($storeName . ' - You received a free coupon');
                // Send the email - Note: getProcessedTemplate is executed within send()
                $emailTemplate->send($customerEmail, $customerFirstname . " " . $customerLastname, $emailTemplateVar);

                // Output successful message
                Mage::getSingleton('core/session')->addSuccess('Coupon successfully emailed to user!');

                return true;

            } catch(Exception $error) {
                // If theres an error, output the error
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }
        }

        // Return the form
        return $this;
    }
}