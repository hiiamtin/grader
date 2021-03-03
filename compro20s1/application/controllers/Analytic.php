<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytic extends CI_Controller {

  public function __construct()	{
    parent::__construct();
  }

  public function index()
  {
    echo "PLMS Analytic";
  }

  public function track_entry_point() {
    // CREATE LOG

    echo "PLMS: Page loaded in " . $_POST['time'] . " seconds";
  }

}