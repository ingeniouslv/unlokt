<?php

App::uses('AbstractTransport', 'Network/Email');

class PostmarkTransport extends AbstractTransport {

	var $uses = array('Notification');

    public function send(CakeEmail $email) {

		$details = array(
			'From' => SITE_EMAIL_FROM_ADDR,
			'To' => implode(', ', $email->to()),
			'Subject' => $email->subject(),
			'TextBody' => $email->message('text'),
			'HtmlBody' => $email->message('html')
		);
		
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: '.POSTMARK_APP_API
		);

		$ch = curl_init('http://api.postmarkapp.com/email');
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($details));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = json_decode(curl_exec($ch));
		return $response->ErrorCode;
        
    } // end of function send();

}