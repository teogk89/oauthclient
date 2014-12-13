<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->library('oauthclient');
		$provider = $this->oauthclient->setup("Runkeeper");
		
		if ( ! isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    header('Location: '.$provider->getAuthorizationUrl());
    exit;

}
$token = $provider->getAccessToken('authorization_code', array(
        'code' => $_GET['code'],
        'grant_type' => 'authorization_code'
    ));


		$k = $provider->userActivites($token);
	//	$k = $provider->individualActivity($token,"472043890");
		$data['activities']=$k['items'];

		$this->load->view("activities",$data);
	}
}

