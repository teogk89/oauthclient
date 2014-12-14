<?php

namespace League\OAuth2\Client\Provider;
use League\OAuth2\Client\Entity\User;


class Mapmyapi extends AbstractProvider{
	
	
	
	
	public $rootUrl = "https://oauth2-api.mapmyapi.com";
	
	// Oauth
	 public function urlAuthorize()
    {
        return 'https://www.mapmyfitness.com/v7.0/oauth2/authorize';
    }
	
	
    public function urlAccessToken()
    {
        return 'https://api.mapmyfitness.com/v7.0/oauth2/access_token/';
    }
	
	
	public function getAuthorizationUrl($options = array()){
        $this->state = md5(uniqid(rand(), true));

        $params = array(
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $this->state,
            'response_type' => isset($options['response_type']) ? $options['response_type'] : 'code',
            'approval_prompt' => 'auto'
        );

        return $this->urlAuthorize() . '?' . $this->httpBuildQuery($params, '', '&');
    }
	
	private function setHeader(\League\OAuth2\Client\Token\AccessToken $token){
		
		$this->headers = array('authorization'=>'Bearer '.$token->accessToken.'','api-key'=>$this->clientId);
		
	}
	
	// User Resources 	
	
    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return $this->rootUrl.'/v7.0/user/self/';
    }
	
	public function getUserById (\League\OAuth2\Client\Token\AccessToken $token,$uid){
		
		$url = $this->rootUrl.'/v7.0/user/'.$uid.'/'; 
		$response = json_decode($this->fetchDetails($token,$url),true);
		
		return $response;
		
	}
	
	 public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
		
		$user = new User;
		$user->exchangeArray(array(
            'uid' => $response->id,
            'name' => $response->display_name,
            'firstname' => $response->first_name,
            'lastName' => $response->last_name,
            'email' => $response->email,
            'urls'=>$response->_links,
        ));

        return $user;
	
	
	}
	
	
	
	 public function getUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
		$this->setHeader($token);
        $response = $this->fetchUserDetails($token);

        return $this->userDetails(json_decode($response), $token);
    }
	
	//User Profile Photo Resources 
	
	public function getUserProfilePicture(\League\OAuth2\Client\Token\AccessToken $token,$uid){
		
		$url = $this->rootUrl."/v7.0/user_profile_photo/".$uid."/";
		$result = json_decode($this->fetchDetails($token,$url),true);
		
		return array(
			"small" => $result["_links"]["medium"][0]["href"],
			"medium" =>$result["_links"]["medium"][0]["href"],
			"large" => $result["_links"]["large"][0]["href"]
		);
		
	}
	
	// Privacy Resources 
	
	public function getPrivacyOptions(\League\OAuth2\Client\Token\AccessToken $token){
		
		$url = $this->rootUrl."/v7.0/privacy_option/";
		return json_decode($this->fetchDetails($token,$url),true);
		
	}
	
	public function getPrivacyOption(\League\OAuth2\Client\Token\AccessToken $token,$uid){
		
		$url = $this->rootUrl."/v7.0/privacy_option/".$uid;
		return json_decode($this->fetchDetails($token,$url),true);
		
	}
	
	public function getMembership(\League\OAuth2\Client\Token\AccessToken $token,$uid){
		
		$url = $tihs->rootUrl."/vx/membership/61486810/".$uid;
		return json_decode($this->fetchDetails($token,$url),true);	
		
	}
	// Friend Resources
	
	public function getFriends(\League\OAuth2\Client\Token\AccessToken $token,$uid){
		
		$url = $tihs->rootUrl."/v7.0/user/?friends_with=".$uid;
		return json_decode($this->fetchDetails($token,$url),true);
		
	}
	
	// User Achievement Resources 
	
	public function getUserAchievements(\League\OAuth2\Client\Token\AccessToken $token,$uid){
		$url = $this->rootUrl."/v7.0/user_achievement/?user=".$uid;
		$response = $this->fetchDetails($token,$url);
		return json_decode($response,true);
		
	}
	
	// Activity Type Resources
	public function getActivityTypes(\League\OAuth2\Client\Token\AccessToken $token){
		$url = $this->rootUrl."/v7.0/activity_type/";
		$response = json_decode($this->fetchDetails($token,$url),true);
		$data = array();
		foreach ($response['_embedded']['activity_types'] as $v=>$row){
			$data[] = array('id'=>$row['_links']['self'][0]['id'],'name'=>$row['name']);	
		}
		
		//return collection of activity types with name and id
		return $data;
		
		
	}
	
	public function getActivityType (\League\OAuth2\Client\Token\AccessToken $token,$id){
		$url = $this->rootUrl."/v7.0/activity_type/".$id;
		$response = json_decode($this->fetchDetails($token,$url),true);
		
	}
	
	
	// User Stats Resources
	
	public function userStats(\League\OAuth2\Client\Token\AccessToken $token,$id,$param){
		
		$url = $this->rootUrl."/user_stats/".$id."/?".$this->httpBuildQuery($param, '', '&');
		$response = json_decode($this->fetchDetails($token,$url),true);
	
		
		
	}
	
	//Workout Resources
	
	public function getWorkouts(\League\OAuth2\Client\Token\AccessToken $token,$param){
		$url = $this->rootUrl."/v7.0/workout/?".$this->httpBuildQuery($param, '', '&');
		$response = json_decode($this->fetchDetails($token,$url),true);
		return $response;
		
	}
	
	public function getWorkoutbyId(\League\OAuth2\Client\Token\AccessToken $token,$id,$field){
		
		$url = $this->rootUrl."/v7.0/workout/".$id."/?field_set=".$field;
		return json_decode($this->fetchDetails($token,$url),true);
		
	}
	public function user3($token){
		
		return $this->httpBuildQuery($token, '', '&');
		
		
			
		
	}
	
	public function activityStory($token){
		
		$url = $this->rootUrl."/v7.0/activity_story/";
		$response = $this->fetchDetails($token,$url);
		return $response;
	}
	private function fetchDetails(\League\OAuth2\Client\Token\AccessToken $token,$url){
		
		
		try{
			
			$client = $this->getHttpClient();
			
			$client->setBaseUrl($url);
			$header = array('authorization'=>'Bearer '.$token->accessToken.'','api-key'=>$this->clientId);
			$client->setDefaultOption('headers', $header);
		
			$request = $client->get()->send();
			$response = $request->getBody();
		}
		catch (BadResponseException $e){
			
			$raw_response = explode("\n", $e->getResponse());
            throw new IDPException(end($raw_response));
			
		}
		return $response;
		
	}
	
	
}