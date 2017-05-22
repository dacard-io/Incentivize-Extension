<?php

class Bricks_Incentivize_Block_Form extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface {
	protected function _toHtml()
    {	
    	// Remember, any other operations go above return!
        $loggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        $submitted_email = $this->getRequest()->getParam('email'); // Haha params is plural, so will output an array. use Param
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($submitted_email)['subscriber_email'];

        // If loggedIn true, show form
        if ($loggedIn)
        {
            if ($submitted_email == null)
            {
                // Do nothing
            } else if ($subscriber == $submitted_email) {
                /* Verify if email submitted is the same as a subscriber in a database,
                   If found, run one more check to see if the customer is already on the database
                */

                // I should definitely look into using something other than a foreach loop. This can't be that fast
                $AllUsers = Mage::getModel('incentivize/users')->getCollection();
                $AllUserEmails = $AllUsers->getColumnValues('email');

                // Check if no data exists, if none exists create the user
                if (empty($AllUserEmails)) {
                    // If match not found in the database, Incentivize user!
                    $customer = Mage::getModel('customer/customer');
                    $customer->setWebsiteId(Mage::app()->getWebsite()->getId()); // Not sure why, but you have to set the website ID first...
                    $customer_firstName = $customer->loadByEmail($submitted_email)['firstname'];
                    $customer_lastName = $customer->loadByEmail($submitted_email)['lastname'];

                    // Save user to database
                    $incentivizeUser = Mage::getModel('incentivize/users');
                    $incentivizeUser->setFirstname($customer_firstName);
                    $incentivizeUser->setLastname($customer_lastName);
                    $incentivizeUser->setEmail($submitted_email);
                    $incentivizeUser->save();

                    // Output successful message
                    Mage::getSingleton('core/session')->addSuccess('You have been added to the Incentivize list!');
                } else {
                    // Else run a duplicate check
                    foreach ($AllUserEmails as $email) {
                        if ($email == $submitted_email) {
                            // If match found for user in the database, don't incentivize user
                            // Output error message
                            Mage::getSingleton('core/session')->addError('You have already been incentivized!');
                        } else {
                            // If match not found in the database, Incentivize user!
                            $customer = Mage::getModel('customer/customer');
                            $customer->setWebsiteId(Mage::app()->getWebsite()->getId()); // Not sure why, but you have to set the website ID first...
                            $customer_firstName = $customer->loadByEmail($submitted_email)['firstname'];
                            $customer_lastName = $customer->loadByEmail($submitted_email)['lastname'];

                            // Save user to database
                            $incentivizeUser = Mage::getModel('incentivize/users');
                            $incentivizeUser->setFirstname($customer_firstName);
                            $incentivizeUser->setLastname($customer_lastName);
                            $incentivizeUser->setEmail($submitted_email);
                            $incentivizeUser->save();

                            // Output successful message
                            Mage::getSingleton('core/session')->addSuccess('You have been added to the Incentivize list!');
                            return; // Exit the foreach loop
                        }
                    }
                }
            } else
            {
              // The user is not a newsletter subscriber, so output an error
                Mage::getSingleton('core/session')->addError('You are not subscribed to any newsletters. No incentives will be given');
            }

            // Show form
            $html = '
            <form>
                <input type="text" name="email" placeholder="Enter your email"/>
                <input type="submit" name="submit" value="Submit"/>
            </form>';

            return $html;
        }
    }
}