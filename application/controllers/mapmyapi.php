<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapmyapi extends CI_Controller {
	
	
	
	public function index(){
		
		$this->load->library('oauthclient');
		$provider = $this->oauthclient->setup("Mapmyapi");
		$code = $this->input->get('code');
		$this->load->helper('url');
		
		if(!$code) {
			
			$provider->authorize();
			
		}
		
		$token = $provider->getAccessToken('authorization_code', array(
        															'code' => $code,
        															'grant_type' => 'authorization_code'
   																));
																
		$data['user'] = $provider->getUserDetails($token);
		
		$data['img'] = $provider->getUserProfilePicture($token,$data['user']->uid);
		//$data['activities_id'] = $provider->getWorkoutbyId($token,"810464731","time_series");
		
		$param = array("started_after"=>"2014-02-25T20:32:33+00:00","started_before"=>"2014-02-28T20:32:33+00:00","user"=>"/v7.0/user/".$data['user']->uid."/");
		
		$data['workout'] = $provider->getWorkouts($token,$param);
		$data['activities'] = $provider->getActivityTypes($token);
		
		
		$this->load->view('mapmyapi',$data);
		
		
		
	}
	
	public function test2(){
		
		$this->load->library('oauthclient');
		$token = $this->oauthclient->token(array('access_token'=>'885b98cb62325ecf6d8b1c380ed559e969f54490'));
		$provider = $this->oauthclient->setup("Mapmyapi");
		$data['user'] = $provider->getUserDetails($token);
		print_r($data);	
		
	}
	
}