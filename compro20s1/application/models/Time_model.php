<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Time_model extends CI_Model {
	private $_table = '';
	private $_data = '';

	public function __construct() {
			parent::__construct();
			// Your own constructor code
			//echo "model constructor : ".__FILE__." <br>";
			
    }
    
    public function set_time_open_close($class_id, $chapter_id, $time_start, $time_end) {
		$current_date = date('d/m/Y == H:i:s');
		$data = array('time_start' => $time_start);
		$data['time_end'] = $time_end;
		$this->db->where('class_id',$class_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->set($data);
		$query = $this->db->update('group_chapter_permission');
		if($query == 1){
			if($time_start>$time_end){
				return ERR_INVALID_TIME_START;
			}
			return ERR_TIME_NONE;
		}else{
			return ERR_CANNOT_UPDATE_TIME;
		}
	}

	public function check_allow_access_and_submit($time_start,$time_end) {
		date_default_timezone_set("Asia/Bangkok");
		$current_date = date('Y-m-d H:i');
		if(strtotime($current_date)<strtotime($time_start)){
			$allow_access = 'no';
			$allow_submit = 'no';
		}else if(strtotime($current_date)>=strtotime($time_start) && strtotime($current_date)<strtotime($time_end)){
			$allow_access = 'yes';
			$allow_submit = 'yes';
		}else if(strtotime($current_date)>=strtotime($time_end)){
			$allow_access = 'yes';
			$allow_submit = 'no';
		}else{
			$allow_access = 'no';
			$allow_submit = 'no';
		}
		return [$allow_access,$allow_submit];
	}
}