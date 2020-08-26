<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Dashboard extends MY_Controller {	

	public function index()
	{
		$this->load->view("auth_header");
		$this->load->view("auth_navbar");
		$this->load->view("auth_dashboard");
		$this->load->view("auth_footer");
	}

}