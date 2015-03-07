<?php
/**
 * class AppPRIME v1.2
 * PHP Library yang mendukung penggunaan API AppPRIME di bawah ini:
 * 1. Telkom ID Authentication URL
 * 2. Send SMS Flexi
 *
 * AppPrime menggunakan framework OAuth v1.0a http://www.oauth.net
 *
 * Sebelum dapat menggunakan class ini, PHP harus mendukung extension OAuth
 * Panduan instalasi dan menggunakan extension OAuth di Apache dan PHP terdapat di http://php.net/manual/en/book.oauth.php
 *
 * Copyright 2013 PT. Telekomunikasi Indonesia, Tbk.
 */

define('RUNTIME_REQUEST_TOKEN_URL', 'https://runtime.appprime.net/RuntimeBiz/services/request_token');		// Runtime Request Token URL
define('RUNTIME_ACCESS_TOKEN_URL', 'https://runtime.appprime.net/RuntimeBiz/services/access_token');			// Runtime Access Token URL
define('RUNTIME_AUTHENTICATE_URL', 'https://runtime.appprime.net/RuntimeBiz/services/authenticate_md5');		// Runtime Telkom ID Authentication URL
define('RUNTIME_SEND_SMS_URL', 'https://runtime.appprime.net/RuntimeBiz/services/send_sms');								// Runtime Send SMS Flexi URL

define('SANDBOX_REQUEST_TOKEN_URL', 'http://sandbox.appprime.net/SandboxBiz/services/request_token');		// Runtime Request Token URL
define('SANDBOX_ACCESS_TOKEN_URL', 'http://sandbox.appprime.net/SandboxBiz/services/access_token');			// Runtime Access Token URL
define('SANDBOX_AUTHENTICATE_URL', 'http://sandbox.appprime.net/SandboxBiz/services/authenticate_md5');		// Runtime Telkom ID Authentication URL
define('SANDBOX_SEND_SMS_URL', 'http://sandbox.appprime.net/SandboxBiz/services/send_sms');								// Runtime Send SMS Flexi URL

class AppPRIME {

	/** public var */
	var $partner_key;							
	var $secret_key;								
	var $errorMsg;
	var $debug=false;
	var $debugResponseFormat="JSON";				// Format Response Debug : JSON / ARRAY
	var $param=array();
	var $envURL=array();
	var $env="sandbox";											// Environment : sandbox / runtime
	
	/** private var */
	var $oauth;
	var $debugMsg = array();
	var $request_token;
	var $request_token_secret;
	var $access_token;
	var $access_token_secret;
		
	/** consutructor */
	function __construct($config=NULL) {
		if (!extension_loaded('OAuth')) {
			$this->errorMsg = "Modul OAuth tidak tersedia";
			return false;
		}else{
			if ($config){
				$this->partner_key = $config['partner_key'];
				$this->secret_key = $config['secret_key'];
			}
		}
		
		$this->oauth = new OAuth($this->partner_key, $this->secret_key);
    $this->oauth->enableSSLChecks();

	}

	function setEnv($env){																								// Set Environment : sandbox / runtime
		if ($env == "sandbox")
			$this->envURL = array(
				'request_token_url' => SANDBOX_REQUEST_TOKEN_URL,
				'access_token_url' => SANDBOX_ACCESS_TOKEN_URL,
				'authenticate_url' => SANDBOX_AUTHENTICATE_URL,
				'send_sms_url' => SANDBOX_SEND_SMS_URL,
			);
		elseif ($env == "runtime")
			$this->envURL = array(
				'request_token_url' => RUNTIME_REQUEST_TOKEN_URL,
				'access_token_url' => RUNTIME_ACCESS_TOKEN_URL,
				'authenticate_url' => RUNTIME_AUTHENTICATE_URL,
				'send_sms_url' => RUNTIME_SEND_SMS_URL,
			);		
	}

	function setPartnerKey($key){
		$this->partner_key=$key;
	}
	
	function getPartnerKey(){
		return $this->partner_key;
	}
	
	function setSecretKey($key){
		$this->secret_key=$key;
	}
	
	function getSecretKey(){
		return $this->secret_key;
	}
		
	function setDebugResponseFormat($format){
		if ($format == "JSON" || $format == "ARRAY")
			$this->debugResponseFormat = $format;
	}
	
	function setParam($param){
		$this->param = $param;
	}
	
	function setDebug($debug){
		$this->debug = $debug;
	}
	
	function getRequestToken(){
		try {
    	$request_token_info = $this->oauth->getRequestToken($this->envURL['request_token_url']);
    	if(!empty($request_token_info)) {
    		$this->request_token = $request_token_info['oauth_token'];
    		$this->request_token_secret = $request_token_info['oauth_token_secret'];
    		return true;
    	}else
    		return false;
    }catch(OAuthException $E) {
    		$this->errorMsg = "Error Request Token";
    		$this->debugMsg = array(
					'response' => $E->lastResponse,
				);
    		return false;
		}
	}
	
	function getAccessToken(){
		try {
    	$this->oauth->setToken($this->request_token, $this->request_token_secret);
    	$access_token_info = $this->oauth->getAccessToken($this->envURL['access_token_url']);
    	if(!empty($access_token_info)) {
    		$this->access_token = $access_token_info['oauth_token'];
    		$this->access_token_secret = $access_token_info['oauth_token_secret'];
    		return true;
    	}else
    		return false;
    }catch(OAuthException $E) {
    		$this->errorMsg = "Error Access Token";
				$this->debugMsg = array(
					'response' => $E->lastResponse,
				);
    		return false;
		}
	}
	
	function authTelkomID(){
		$requestToken = $this->getRequestToken(); 		
		die($requestToken);																		
		if ($requestToken){
			$accessToken = $this->getAccessToken();		
			if ($accessToken){
				try {
					$this->oauth->setToken($this->access_token,$this->access_token_secret);
					$method = OAUTH_HTTP_METHOD_POST;																										
					$headers = array('Content-Type' => 'text/xml');	
					$this->param['password'] = md5($this->param['password']);
					$param2=array(
							"product_name" => "SELFCARE",
							"login_from" => "AppPrime",
					);																		
					$body=json_encode($this->param + $param2);
					$fetch_token_info = $this->oauth->fetch($this->envURL['authenticate_url'], $body, $method, $headers);
					$response_info = $this->oauth->getLastResponseInfo();
					$response=$this->oauth->getLastResponse();
					if(!empty($response)) {
						$return=json_decode($response);
						if ($return->return_code	 == "01"){
							$this->errorMsg = "Error Authenticate Telkom ID";
							$this->debugMsg = $return;
							return false;
						}else if ($return->return_code == "00"){
							return true;
						}
					} else {
						$this->errorMsg = "Error Authenticate Telkom ID";
						$this->debugMsg = array(
							'response' => $oauth->getLastResponse(),
						);
						return false;
					}
				} catch(OAuthException $E) {
						$this->errorMsg = "Error Authenticate Telkom ID";
						$this->debugMsg = array(
							'response' => $E->lastResponse,
						);
						return false;
				}
			}else
				return false;
		}else
			return false;
	}
	
	function sendSMS(){
		$requestToken = $this->getRequestToken(); 																								
		if ($requestToken){
			$accessToken = $this->getAccessToken();		
			if ($accessToken){
				try {
					$this->oauth->setToken($this->access_token,$this->access_token_secret);
					$method = OAUTH_HTTP_METHOD_POST;																										
					$headers = array('Content-Type' => 'text/xml');							
					$param2=array(
						"sender" => "1441",
						"simplereference" => array(
							"endpoint" => "1",
							"interfaceName" => "1",
							"correlator" => "1"
						)
					);							
					$body = json_encode($this->param + $param2);
					$fetch_token_info = $this->oauth->fetch($this->envURL['send_sms_url'], $body, $method, $headers);
					$response_info = $this->oauth->getLastResponseInfo();
					$response=$this->oauth->getLastResponse();
					if(!empty($response)) {
						$t=json_decode($response);
						$a=explode("-",$t->response);
						$st="";
						if (count($a) == 2)
							return true;
						else{
							$this->errorMsg = "Error Send SMS";
							$this->debugMsg = array(
								'response' => $this->oauth->getLastResponse(),
							);
							return false;
						}
					}
				} catch(OAuthException $E) {
						$this->errorMsg = "Error Send SMS";
						$this->debugMsg = array(
							'response' => $E->lastResponse,
						);
						return false;
				}
			}else
				return false;
		}else
			return false;
	}
	
	function showError(){
		$msg = array();
		if ($this->errorMsg)
			$msg['errorMsg'] = $this->errorMsg;
		if ($this->debug && $this->debugMsg){
			$msg['debugFormat'] = $this->debugResponseFormat;
			if ($this->debugResponseFormat == "ARRAY")
				$msg['debugMsg'] = $this->debugMsg;
			else if ($this->debugResponseFormat == "JSON")
				$msg['debugMsg'] = json_encode($this->debugMsg);
		}
		return $msg;
	}
}
?>