<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for Admin group only
 */
class Admin extends MY_Controller {

	protected $access = "admin";
	
	public function index()
	{
		$this->load->view("header");
		$this->load->view("body_nav");
		$this->load->view("admin");
		$this->load->view("footer");
	}

}