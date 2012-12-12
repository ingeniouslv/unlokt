<?php
/* 
 * Created by Zach Jones <zach@peacefulcomputing.com>
 * This custom email transport will save email object into database for sending via cron/daemon.
 */
App::uses('AbstractTransport', 'Network/Email');

class PCMailTransport extends AbstractTransport {

	var $uses = array('Notification'); // Load dat model.

    public function send(CakeEmail $email) {
    	// Let's save the email to the database, or send it (depends on whether or not this application is set to send instantly).
    	
		// Serialize the CakeEmail object. Create a new array for saving into database.
		$_email = serialize($email);
		$notification = array(
			'Notification'=>array(
				'to'=>implode(', ', $email->to()),
				'subject'=>$email->subject(),
				'email'=>$_email,
				'is_sent' => (SITE_EMAIL_SEND_IMMEDIATELY ? 1 : 0)
			)
		);
		
		// Save the email to the database. A cron job will run to find these emails and send them.
        Controller::loadModel('Notification');
		// Make sure to create a new object - otherwise it will be overwritten when sending multiple emails.
		$this->Notification->create(false);
		if (!$this->Notification->save($notification)) {
			throw new Exception("Error Processing Request - PCMailTransport->send()");			
		}
		
		// Send email using SMTP.
    	if (SITE_EMAIL_SEND_IMMEDIATELY) {
			$email->config('postmark');
			$email->send();
			return;
    	}
        
    } // end of function send();

}