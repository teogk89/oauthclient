<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Oauthclient{
	
	
	public static function setup($input){
		
		//$CI =& get_instance();
		include_once("./vendor/autoload.php");
		
		$CI =& get_instance();
		$CI->config->load("oauthclient");
		switch ($input){
		case "Runkeeper":
		
		
		$config = $CI->config->item("runkeeper");
		$provider = new League\OAuth2\Client\Provider\Runkeeper($config);
		break;
		
		case "Mapmyapi":
		$config = $CI->config->item('mapmyapi');
		$provider = new League\OAuth2\Client\Provider\Mapmyapi($config);
		break;	
		}
		return $provider;
		
		
		
		
	}
	
	public static function token($input){
		
		include_once("./vendor/autoload.php");
		$token = new League\OAuth2\Client\Token\AccessToken($input);
		return $token; 	
		
	}
	
}