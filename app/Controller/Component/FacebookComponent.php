<?php
/* 


Created by Mike Berman June 5, 2013


 */


//App::path('Vendor') or just APP . 'Vendor' . DS.
$facebook_api = APP . 'Vendor' . DS . "Facebook/facebook.php";
require_once $facebook_api;


class FacebookComponent extends Component {
	
 
	
	public function login( $force = false ) {
		
	 
		$config = array(
    		'appId' => FACEBOOK_APPID,
    		'secret' => FACEBOOK_SECRET,
		'redirect_uri' => "http://unlokt.com/users/login_facebook"
  		);
		
		$this->facebook = new Facebook($config);
  		$user_id = $this->facebook->getUser();
  		
  		if ($user_id && ! $force ) {
  			
  			echo "reutrn id $user_id";
  			
  			return $user_id;
  			
  		} else {
  			
  		 
  			$params = array("scope" => "publish_stream,email" );
  			
  			 // No user, print a link for the user to login
  			 $dialog_url = $this->facebook->getLoginUrl($params);
  	 
  			 
      		
  			header("Location: $dialog_url");
			exit();
     
  			
  		}
		
		
	}
	
	
	public function post( $passed = array() ) {
		
		if (empty($passed))
			return false;
			
	 
		if (isset($passed['message']))
		$message = $passed['message'];
		else return false;
		
		if (isset($passed['user_id']))
		$user_id = $passed['user_id'];
		else return false;
		
		
		if (isset($passed['url']))
		$link = $passed['url'];
		else 
		$link = "";
		
		if (isset($passed['image']))
		$image = $passed['image'];
		else
		$image = '';
		
		//$user_id = $this->login();
		
		//echo $this->Auth->user("id");
		//return;
		//set the user model
		//$this->loadModel('User');
		$this->User = ClassRegistry::init('User');
		$user = $this->User->read( null, $user_id );
		
		if (!$user)
			return false;
	 
	  
		$config = array(
    		'appId' => FACEBOOK_APPID,
    		'secret' => FACEBOOK_SECRET,
	 
  		);
  		
  		if (!$user['User']['facebook_id'])
  			return false;
  		
  		//we have no token lets get one
  		if (!$user['User']['facebook_token']) {
  		
  			$this->login( true );
  			return false;
  		}
  		
		$this->facebook = new Facebook($config);
		$this->facebook->setAccessToken($user['User']['facebook_token']);
		//grab the current facebook id
		//grab current token
 
		
		// We have a user ID, so probably a logged in user.
		// If not, we'll get an exception, which we handle below.
		try {
			
			//DO WE NEED NEXT LINE??
    		//$me = $facebook->api('/me');
    	  
            	  $privacy = array(  'value' => 'SELF' );
   
    
    		 
    			$statusUpdate = $this->facebook->api('/me/feed', 'post', array('message'=> $message, 
    				'link' => $link, 'cb' => '', 'picture' => $image, 'privacy' => json_encode($privacy) ));
    	 
    			return true;
	 
		} 
		catch(FacebookApiException $e) {
			
			// If the user is logged out, you can have a 
			// user ID even though the access token is invalid.
			// In this case, we'll get an exception, so we'll
			// just ask the user to login again here.
			$this->log($e->getType());
			$this->log($e->getMessage());
			$this->login( true );
			 
			return false;
			
	      }   
 
		
	}
	
 

} //end facebook component