<?php


namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Entity\User;


class Local extends AbstractProvider{
	
	 public function __construct($options)
    {
        parent::__construct($options);
        $this->headers = array(
            'Authorization' => 'Bearer'
        );
    }
	
	 public function urlAuthorize()
    {
        return 'http://localhost:82/OauthDemo/OauthServer/authorize';
    }

    public function urlAccessToken()
    {
        return 'http://localhost:82/OauthDemo/OauthServer/token';
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return 'http://localhost:82/OauthDemo/index.php/OauthServer/resource?access_token='.$token;
    }
	
	
	 public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
		return $response;
	
	}
	
	public function test($token){
		
		//$k  = $this->fetchUserDetails($token);
		//return $k;
		$url = $this->urlUserDetails($token);
		$client = $this->getHttpClient();
		$client->setBaseUrl($url);
		$request = $client->get()->send();
        $response = $request->json();
		return $response;
	}
}