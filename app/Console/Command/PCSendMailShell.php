<?php

/* Created by Zach Jones < zach@peacefulcomputing.com >
 * 
 * This script is intended to be ran continuously - 24x7.
 * Currently this script should be configured to be ran through `supervisor` ... a Linux utility.
 */

App::uses('CakeEmail', 'Network/Email');
class PCSendMailShell extends AppShell {
	
	public $uses = array('Notification');
	
    public function main()
    {
    	$this->out();
        $this->out("Loading {$this->name}");
		
		while (1)
		{
			$this->check_mail();
			sleep(4);
		}
		
	}
	
	public function check_mail()
	{
		$mails = $this->Notification->findAllByIsSentAndIsError(0, 0);	
		if (count($mails))
		{
			$this->out(count($mails).' unsent mails found.');
			foreach ($mails as $mail)
			{
				$email = unserialize($mail['Notification']['email']);
				$email->config('postmark');
				$error = $email->send();
				$this->out("Response from Postmark: $error ".(!$error ? ' (good)' : ' (!!! error)'));
				if (!$error)
				{
					// Mail was sent successfully.
					$mail['Notification']['is_sent'] = 1;
				}
				else
				{
					// Mark the mail as being an error. We could query for these issues later.
					$mail['Notification']['is_error'] = 1;
				}
				$this->Notification->save($mail);
			}
			$this->out('Mail sending finished. Until next time...');
			$this->out('');
		}
		
	}
	
}