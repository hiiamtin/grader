<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examroom_model extends CI_Model {
	private $_table = '';
	private $_data = '';

	public function __construct() {
			parent::__construct();
	}

	public function getAllExamRoom() {
        $this->db->select('*')
			->from('exam_room');
		$query = $this->db->get();		
		$query = $query->result_array();
		$examRoom = array();
		foreach($query as $row) {
			$examRoom[$row['room_number']] = $row;
		}
		return $examRoom;
    }

    public function setAllowAccess($needToAllow, $roomNumber){
        $data = array('allow_access' => $needToAllow);
        $this->db->where('room_number',$roomNumber);
        $this->db->set($data);
        $query = $this->db->update('exam_room');
    }

    public function setAllowCheckIn($needToAllow, $roomNumber){
        $data = array('allow_check_in' => $needToAllow);
        $this->db->where('room_number',$roomNumber);
        $this->db->set($data);
        $query = $this->db->update('exam_room');
    }
	
}//class Examroom_model