<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for Author group only
 */
class Plms_json extends CI_Controller {	

    protected $access = "supervisor";

    public function __construct()	{
        parent::__construct();		
    }

    public function index()
    {


    }

    public function get_online_student($user_id,$user_role="student") {
        //echo __METHOD__;
        $this->load->model('lab_model');
        $online_student = $this->lab_model->get_online_student();
        //echo "<pre/>"; print_r($online_student); echo "</pre>";
        echo json_encode($online_student);
    }

    public function get_online_student_exam($roomNum) {
        //echo __METHOD__;
        $this->load->model('examroom_model');
        $check_in = $this->examroom_model->getAllStudentIDSeatsData($roomNum);
        $online_student = $this->examroom_model->get_online_student_exam($roomNum);
        $check_in = 
        //echo "<pre/>"; print_r($online_student); echo "</pre>";
        $data = array('online_student' => $online_student,
                      'check_in' => $check_in);
        echo json_encode($data);
    }


}