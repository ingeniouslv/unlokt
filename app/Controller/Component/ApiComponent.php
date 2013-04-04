<?php
	class ApiErrors{
		//Error Codes
		public static $GENERIC									= array(0,"Generic Error");
		public static $NO_DATA_PASSED							= array(1,"No Data Passed");
		public static $MISSING_REQUIRED_PARAMATERS				= array(2,"Missing Required Paramaters");
		public static $NOT_LOGGED_IN							= array(3,"Must Be Logged In");
		public static $EMAIL_IN_USE								= array(4,"Non Unique Email");
		public static $COULD_NOT_REGISTER						= array(5,"Error Registering User");
		public static $ALREADY_LOGGED_IN						= array(6,"Already Logged In");
		public static $INVALID_API_KEY							= array(7,"Invalid API Passed");
		public static $INVALID_LOGIN							= array(8,"Invalid User Name Or Password");
		public static $MAX_REDEEM								= array(9,"You have redeemed this Special too many times");
		public static $MISMATCH_FACEBOOK_CREDENTIALS			= array(10,"Facebook- and User-supplied credentials do not match");
		public static $MISMATCH_PASSWORDS						= array(11,"Passwords must match");
		
		
	}
	
	class ApiSuccessMessages{
		//Success Codes
		public static $USER_REGISTERED							= array(1, "User Registered");
		public static $USER_LOGGED_IN							= array(2, "User Logged In");
		public static $USER_LOGGED_OUT							= array(3, "User Logged Out");
		public static $GENERIC_SUCESS							= array(4, "Generic Success");
		public static $SPOT_RECOMMENDED							= array(5, "Spot has been submitted.  Thank you.");
	}
	
	class ApiComponent extends Component{
		
		public static $controller;
		public static $currentController;
		public static $currentAction;
		public static $currentUrl;
		public static $PUBLIC_URLS = array(
			array("users", "api_login"), 
			array("users", "api_register")
		);
		
		public static $GET_URLS = array(
			
		);
		
		
		/**
		 * array of api calls and their paramters list 
		 * $key = url, 
		 * $i[0] = array of required paramaters, 
		 * $i[1] = array of optional paramaters
		 * $i[2] = description of possible data returned in success json 
		 */
		public static $ACTION_LIST = array(
			
			"api/users/login"					=> array(array("email", "password"), array(), array("api_key", "email", "first_name", "last_name")),
			
			"api/users/register"				=> array(array("email", "password", "first_name", "last_name"), array(), array("api_key", "email", "first_name", "last_name")),
			
			"api/users/logout"				=> array(array(),array(),array()),
			
			"api/survey/survey"				=> array(array(), array(), array()),
		
		);

		function __construct($collection, $settings = array()) { 
			$this->settings = $settings;
			parent::__construct($collection, $settings); 
		} 

		public function initialize(&$controller){
			self::$controller = &$controller;
			
			self::$currentController = strtolower($controller->params['controller']);
			self::$currentAction = strtolower($controller->params['action']);
			
			self::$currentUrl = self::toUrl($controller->params['controller'], $controller->params['action']);
		}
		
		static public function createJsonObject($type, $number = null, $descrption = null, $data = null){
			return json_encode(array("type" => $type, "code" => $number, "description" => $descrption, "data" => $data));
		}
		
		static public function error($error, $data = null, $description = null){
			$description = isset($description)?$description:$error[1];
			echo self::createJsonObject("error", $error[0], $description, $data);
			exit;
		}
		
		static public function success($msg, $data = null, $forceValidData = false, $description = null){
			if($forceValidData){
				$data = self::stripInvalidOutGoingParamaters($data);
			}
			$description = isset($description)?$description:$msg[1];
			echo self::createJsonObject("success", $msg[0], $description, $data);
			exit;
		}
		
		static public function isPublicAccessible($controller = null, $action = null){
			if(!isset($controller) && !isset($action)){
				
				$controller = self::$currentController;
				$action = self::$currentAction;
			}
		
			return in_array(array($controller,$action), self::$PUBLIC_URLS);
		}
		static public function isGetAccessible($controller = null, $action = null){
			if(!isset($controller) && !isset($action)){
				$controller = self::$currentController;
				$action = self::$currentAction;
			}
			return in_array(array($controller,$action), self::$GET_URLS);
		}
		static public function checkRequiredParamaters($data, $controller = null, $action = null,  $exitOnError = true){
			if(!isset($controller) && !isset($action)){
				$controller = self::$currentController;
				$action = self::$currentAction;
			}
			$url = self::toUrl($controller, $action);
			if(!isset(self::$ACTION_LIST[$url])){
				return false;
			}
			foreach(self::$ACTION_LIST[$url][0] as $paramater){
				if(!isset($data[$paramater])){
					if($exitOnError){
						self::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS,self::$ACTION_LIST[$url][0]);
					}
					return false;
				}
			}
			
			return true;
		}
		
		static public function stripInvalidOutGoingParamaters($data, $url = null){
			if(!isset($url)){
				$url = self::$currentUrl;
			}	
			if(!isset(self::$ACTION_LIST[$url])){
				return array();
			}
			
			$validParmaters = self::$ACTION_LIST[$url][2];
			
			return self::stripInvalidParamaters($data, $validParmaters);
		}
		
		static public function stripInvalidIncomingParamaters($data, $url = null){
			if(!isset($url)){
				$url = self::$currentUrl;
			}	
			if(!isset(self::$ACTION_LIST[$url])){
				return array();
			}
			
			$validParmaters = array_merge(self::$ACTION_LIST[$url][0], self::$ACTION_LIST[$url][1]);
			return self::stripInvalidParamaters($data, $validParmaters);
		}
		
		static public function stripInvalidParamaters($data,$validParmaters, $url = null){
			if(!isset($url)){
				$url = self::$currentUrl;
			}	

			$ndata = array();
			
			
			if(!isset(self::$ACTION_LIST[$url]) || empty($validParmaters)){
				return array();
			}
			
			
			foreach ($data as $key => $value) {
				if(!empty($value) && array_search($key, $validParmaters) !== false){			
					$ndata[$key] = "$value";
				}
			}
	
			return $ndata;
		}
		
		static public function toUrl($controller, $action){
			$controller = strtolower($controller);
			$action = strtolower($action);
			$url = "api/" . $controller . "/" . substr($action, 4);
			return $url;
		}
		
	}