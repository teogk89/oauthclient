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
		//$data['activities'] = $provider->getWorkoutbyId($token,"810464731","time_series");
		$data['activities'] = $provider->getActivityTypes($token);
		
		
		$this->load->view('mapmyapi',$data);
		
		
		
	}
	
}