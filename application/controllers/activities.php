<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Activities extends CI_Controller {
	
	
	
	
	public function index(){
		$this->config->load("oauthclient");
		$this->load->library('oauthclient');
		$this->load->helper('url');
		
		 
		$provider = $this->oauthclient->setup("Runkeeper");
		
		
		$code = $this->input->get('code');
		if(!$code){
		
			 redirect($provider->getAuthorizationUrl());
   			 exit;
			
		}
		$token = $provider->getAccessToken('authorization_code', array(
        																	'code' => $code,
        															'grant_type' => 'authorization_code'
   		 															));
		
		
			
		
		
		 //$this->session->set_userdata('some_name', $token);
		 
		$ac = $provider->userActivites($token);
		
		if(isset($ac['items'])){
		foreach ($ac['items'] as $n=>$row){
			
			$k = $provider->individualActivity($token,$row['uri']);
			$ac['items'][$n]['link'] = $k['activity'];
			
		}
		
		
		$data['activities'] = $ac['items'];
		
		$this->load->view('activities',$data);
		}
			
		else{
			
			echo "there is no activities found";	
			
		}
		
		
	}
	
	
	
}