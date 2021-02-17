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

  public function unixTimeToRelativeFormat($ts)
  {
    if(!ctype_digit($ts))
      $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
      return 'now';
    elseif($diff > 0)
    {
      $day_diff = floor($diff / 86400);
      if($day_diff == 0)
      {
        if($diff < 60) return 'just now';
        if($diff < 120) return '1 minute ago';
        if($diff < 3600) return floor($diff / 60) . ' minutes ago';
        if($diff < 7200) return '1 hour ago';
        if($diff < 86400) return floor($diff / 3600) . ' hours ago';
      }
      if($day_diff == 1) return 'Yesterday';
      if($day_diff < 7) return $day_diff . ' days ago';
      if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
      if($day_diff < 60) return 'last month';
      return date('F Y', $ts);
    }
    else
    {
      $diff = abs($diff);
      $day_diff = floor($diff / 86400);
      if($day_diff == 0)
      {
        if($diff < 120) return 'in a minute';
        if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
        if($diff < 7200) return 'in an hour';
        if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
      }
      if($day_diff == 1) return 'Tomorrow';
      if($day_diff < 4) return date('l', $ts);
      if($day_diff < 7 + (7 - date('w'))) return 'next week';
      if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
      if(date('n', $ts) == date('n') + 1) return 'next month';
      return date('F Y', $ts);
    }
  }

  public function unixTimeToRelativeFormat2($time) {

    $d[0] = array(1,"second");
    $d[1] = array(60,"minute");
    $d[2] = array(3600,"hour");
    $d[3] = array(86400,"day");
    $d[4] = array(604800,"week");
    $d[5] = array(2592000,"month");
    $d[6] = array(31104000,"year");

    $w = array();

    $return = "";
    $now = time();
    $diff = ($now-$time);
    $secondsLeft = $diff;

    for($i=6;$i>-1;$i--)
    {
      $w[$i] = intval($secondsLeft/$d[$i][0]);
      $secondsLeft -= ($w[$i]*$d[$i][0]);
      if($w[$i]!=0)
      {
        $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
      }

    }

    $return .= ($diff>0)?"ago":"left";
    return $return;
  }
}