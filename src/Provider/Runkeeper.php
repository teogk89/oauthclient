<?php

namespace League\OAuth2\Client\Provider;
use League\OAuth2\Client\Entity\User;


class Runkeeper extends AbstractProvider{

	 public function __construct($options)
    {
        parent::__construct($options);
        $this->headers = array(
            'Authorization' => 'Bearer'
        );
    }
	
	 public function urlAuthorize()
    {
        return 'https://runkeeper.com/apps/authorize';
    }
	
	public function urlDeauthorize(){
			
		return 'https://runkeeper.com/apps/de-authorize';
		
	}
    public function urlAccessToken()
    {
        return 'https://runkeeper.com/apps/token';
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return 'https://api.runkeeper.com/fitnessActivities';
    }
	
	
	 public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
	
	
	}
	public function userActivites ($token){
		$accept = 'application/vnd.com.runkeeper.FitnessActivityFeed+json';
		$url = 'https://api.runkeeper.com/fitnessActivities';
		$response = $this->fetchDetails($token,$accept,$url);
		return $response;
		
	}
	
	public function individualActivity($token,$url){
		$accept = "application/vnd.com.runkeeper.FitnessActivity+json";
		$url = "https://api.runkeeper.com/".$url."";	
		$response = $this->fetchDetails($token,$accept,$url);
		return $response;
	}
	public function pastActivities($token){
		$accept = "application/vnd.com.runkeeper.FitnessActivitySummary+json";	
		$url = "https://api.runkeeper.com/fitnessActivitySummary";
		$response = $this->fetchDetails($token,$accept,$url);
		return $response;
		
	}
	private function fetchDetails($token,$accept,$url){
		
		$client = $this->getHttpClient();
		$client->setBaseUrl($url);
		$header = array(
		'Authorization'=>'Bearer '.$token.'','Accept'=>$accept);
		$client->setDefaultOption('headers', $header);
		//$client->setHeader($header);
		$request = $client->get()->send();
	
		
		//$this->headers($header);
        $response = $request->json();
		return $response;
		
	}
}