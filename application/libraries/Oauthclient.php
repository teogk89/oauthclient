<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Oauthclient{
	
	
	public static function setup($input){
		
		//$CI =& get_instance();
		include_once("./vendor/autoload.php");
		
		$CI =& get_instance();
		$CI->config->load("oauthclient");
		$class = 'League\\OAuth2\\Client\\Provider\\'.$input;
		$config = $CI->config->item($input);
		$provider = new $class($config);
		return $provider;
		
		
		
		
		
	}
	
	public static function token($input){
		
		include_once("./vendor/autoload.php");
		$token = new League\OAuth2\Client\Token\AccessToken($input);
		return $token; 	
		
	}
	
}