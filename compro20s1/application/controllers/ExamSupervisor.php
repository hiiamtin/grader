<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class ExamSupervisor extends MY_Controller {

  protected $access = "supervisor";
  private $MODULE_PATH = "ExamSupervisor/";

  public function __construct() {
    parent::__construct();
    $this->load->model('examroom_model');
  }

  public function index() {
    $this->load->model('supervisor_model');
    $data = array('supervisor_data'	=> $this->supervisor_model->get_supervisor_data());
    $exam_data = array(
        'exam_rooms' => $this->examroom_model->getAllExamRoom(),
        'class_list' => $this->examroom_model->getClassListAll(),
        'group_permission' => $this->examroom_model->getAllExamChapter()
    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/nav_sideleft',$data);
    $this->load->view('supervisor/exam_room/panel',$exam_data);
    $this->load->view('supervisor/exam_room/popup_group_select');
    $this->load->view('supervisor/exam_room/popup_group_select_score');
    $this->load->view('supervisor/exam_room/popup_allow_exercise');
    $this->load->view('supervisor/footer');
  }

  public function seating_chart($roomNum) {
    /// หน้าแสดงแผนผังที่นั่งห้องสอบ
    /// Url จะเป็น exam_room_seating_chart/{เลขห้อง}

    $this->load->model('supervisor_model');
    $this->load->model('lab_model');
    $this->load->model('time_model');
    $roomData = $this->examroom_model->getRoomData($roomNum);
    $class_id = $roomData["class_id"];
    $chapter_id = $roomData["chapter_id"];
    $group_permission = $this->lab_model->get_group_permission($class_id);
    $class_schedule = $this->lab_model->get_class_schedule_by_group_id($class_id);
    // print_r($class_schedule);

    if($chapter_id!=NULL){
      $chapter_data = $group_permission[$chapter_id];
      $result = $this->time_model->check_allow_access_and_submit($chapter_data['time_start'],$chapter_data['time_end']);
      $chapter_data["allow_access"] = $result[0];
      $chapter_data["allow_submit"] = $result[1];
    }else{
      $chapter_data = NULL;
    }
    $seatData = array(
      //'seat_list' => $this->examroom_model->getAllSeatsData($roomNum),
        'roomData' => $roomData,
        'accessible_room' => $roomNum,
        'chapter_data' => $chapter_data,
        'allow_login' => $class_schedule['allow_login'],
        'allow_exercise' => $class_schedule['allow_exercise'],
      //'in_social_distancing' => $roomData["in_social_distancing"],
        'group_number' => $class_id,
        'department' => $this->examroom_model->getDepartment($class_id),
        'supervisor_info' => $this->examroom_model->getSupervisor($class_id),
        'num_of_student' => $this->examroom_model->getNumberOfStudentInClass($class_id)
    );
    $roomData = array(
        'room_number' => $roomNum,
        'chapter_id' => $chapter_id,
        'group_permission' => $group_permission
    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/exam_room/seating_chart',$seatData);
    $this->load->view('supervisor/exam_room/popup_group_select');
    $this->load->view('supervisor/exam_room/popup_setting1',$roomData);
    $this->load->view('supervisor/exam_room/popup_setting2');
    $this->load->view('supervisor/exam_room/popup_stu_preview');
    $this->load->view('supervisor/exam_room/exam_footer');
  }

  public function seating_chart_dashboard($roomNum) {
    $this->load->model('lab_model');
    $this->load->model('supervisor_model');
    $roomData = $this->examroom_model->getRoomData($roomNum);
    $class_id = $roomData["class_id"];

    $seatData = array(
        'seat_list' => $this->examroom_model->getAllSeatsData($roomNum),
        'in_social_distancing' => $roomData["in_social_distancing"],
    );

    $this->load->view('supervisor/exam_room/seating_chart_dashboard',$seatData);
  }

  public function setting()
  {
    /// Form action ตั้งค่าห้องสอบ
    /// เมื่อตั้งค่าเสร็จจะ Refresh หน้าเดิม

    $room_number = $_POST['room_number'];
    $chapter_id = $_POST['chapter_id'];
    $class_id = $_POST['class_id'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $this->load->model("time_model");
    $this->examroom_model->save_Setting($room_number, $chapter_id);
    $status = $this->time_model->set_time_open_close($class_id, $chapter_id, $time_start, $time_end);
    if ($status == ERR_INVALID_TIME_START) {
      $this->session->set_flashdata("error_time" . $chapter_id, "Open time is more than close time.");
    } else if ($status == ERR_CANNOT_UPDATE_TIME) {
      $this->session->set_flashdata("error_time" . $chapter_id, "Network ERROR! Please try again.");
    } else if ($status == ERR_TIME_NONE) {
      $this->session->set_flashdata("error_time" . $chapter_id, "Update Complete.");
      $result = $this->time_model->check_allow_access_and_submit($time_start, $time_end);
      $allow_access = $result[0];
      $allow_submit = $result[1];
      /*
      $this->load->model("lab_model");
      $this->lab_model->set_allow_access($class_id,$chapter_id,$allow_access);
      $this->lab_model->set_allow_submit_class_chapter($class_id,$chapter_id,$allow_submit);*/
    }
    redirect(site_url($this->MODULE_PATH.'seating_chart/'.$room_number));
  }

  public function change_time() {
    //print_r($_POST);
    $this->load->model("time_model");
    $room_number = $_POST['room_number'];
    $time_start = $_POST["quick-time-starttime"];
    $time_end = $_POST["quick-time-endtime"];
    $data = $this->examroom_model->getRoomData($room_number);
    $class_id = $data["class_id"];
    $chapter_id = $data["chapter_id"];
    $status = $this->time_model->set_time_open_close($class_id, $chapter_id, $time_start, $time_end);
    redirect(site_url($this->MODULE_PATH.'seating_chart/'.$room_number));
  }

  public function set_level_allow_access($roomNum) {
    $this->load->model('supervisor_model');
    $supervisor_data = array(
        'supervisor_data'	=> $this->supervisor_model->get_supervisor_data()
    );
    $roomData = $this->examroom_model->getRoomData($roomNum);
    $class_id = $roomData["class_id"];
    $chapter_id = $roomData["chapter_id"];
    $this->load->model('lab_model');
    //echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
    $group_permission = $this->lab_model->get_group_permission($class_id);
    //echo "<h3>". __METHOD__ ." : group_permission :</h3><pre>"; print_r($group_permission); echo "</pre>";
    $group_id = $class_id;
    $group_exercise_chapter = $this->lab_model->get_group_exercise_chapter($group_id,$chapter_id);
    //echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($group_exercise_chapter); echo "</pre>";
    $class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
    $group_lab_list = array();
    foreach($group_exercise_chapter as $row) {
      $item = $row['item_id'];
      $exercises = unserialize($row['exercise_id_list']);
      for($i=1; $i<=sizeof($exercises); $i++) {
        $group_lab_list[$item][$i]=$exercises[$i-1];
      }
    }

    $lab_exercise = $this->lab_model->get_lab_exercise_by_chapter($chapter_id);
    //echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";

    $lab_list = array();
    for ($i=0,$count=1; $i<sizeof($lab_exercise); $i++,$count++) {
      $level = $lab_exercise[$i]['lab_level'];			;
      $lab_list[$level][$count] = $lab_exercise[$i];
      if (!empty($lab_exercise[$i+1]) && $level < $lab_exercise[$i+1]['lab_level'])
        $count = 0;

    }
    //echo '<h4>$lab_list <pre>'; print_r($lab_list); echo "</pre>";





    //echo '<h4>$group_exercise_chapter <pre>'; print_r($group_exercise_chapter); echo "</pre>";
    //echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";
    $chapter_permission = $this->lab_model->get_group_permission($group_id);
    $chapter_permission = $chapter_permission[$chapter_id];
    $this->load->model('time_model');
    $chapter_data = $chapter_permission;
    $result = $this->time_model->check_allow_access_and_submit($chapter_data['time_start'],$chapter_data['time_end']);
    $chapter_data["allow_access"] = $result[0];
    $chapter_data["allow_submit"] = $result[1];



    $data = array(
        'group_exercise_chapter'	=>	$group_exercise_chapter,
        'group_id'					=>	$group_id,
        'lab_no'					=>	$chapter_id,
        'group_lab_list'			=>	$group_lab_list,
        'lab_list'					=>	$lab_list,
        'class_schedule'			=>	$class_schedule,
        'chapter_permission'		=>	$chapter_data,
        'lab_info'		=>	$this->lab_model->get_lab_info(),
				'levels'	 	=> 	$this->lab_model->get_level()
    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/nav_sideleft',$supervisor_data);
    $this->load->view('supervisor/exam_room/exam_select_for_group',$data);
    $this->load->view('supervisor/exam_room/exam_footer_no_roomnum');
  }

  public function ajax_allow_access() {
    /// JQuery เปิด-ปิด การเข้าถึงห้องสอบ

    $roomNumber = intval($_POST['roomNumber']);
    $needToAllow = $_POST['needToAllow'];
    $classId = $_POST['classId'];
    $this->examroom_model->setAllowAccess($needToAllow,$roomNumber,$classId);
    if($needToAllow=='unchecked') {
      $extraStuList = $this->examroom_model->getExtraStudentList($roomNumber);
      foreach ($extraStuList as $exStu) {
        $this->examroom_model->setStudentGroupId($exStu['stu_id'], $exStu['stu_group']);
        $this->examroom_model->removeExtraStudent($exStu['stu_id']);
      }
    }
  }

  public function ajax_allow_check_in() {
    /// JQuery เปิด-ปิด Check-in ห้องสอบ

    $roomNumber = intval($_POST['roomNumber']);
    $needToAllow = $_POST['needToAllow'];
    $this->examroom_model->setAllowCheckIn($needToAllow,$roomNumber);
  }

  public function ajax_allow_log_in() {
    /// JQuery เปิด-ปิด login

    $roomNumber = intval($_POST['roomNumber']);
    $roomData = $this->examroom_model->getRoomData($roomNumber);
    $class_id = $roomData["class_id"];
    $allow_login = $_POST['value'];
		$this->load->model('lab_model');
		$this->lab_model->set_allow_class_login($class_id,$allow_login);
  }

  public function ajax_social_distancing() {
    /// JQuery เปิด-ปิด เว้นระยะห่าง

    $roomNumber = intval($_POST['roomNumber']);
    $distancing = $_POST['value'];
    $this->examroom_model->setSocialDistancing($distancing,$roomNumber);
  }

  
  public function ajax_social_distancing_and_clear() {
    /// JQuery เปิด-ปิด เว้นระยะห่าง

    $roomNumber = intval($_POST['roomNumber']);
    $distancing = $_POST['value'];
    $this->examroom_model->setSocialDistancing_and_clear($distancing,$roomNumber);
  }

  public function ajax_allow_exercise() {
    /// JQuery เปิด-ปิด exercise
    $class_id = intval($_POST['class_id']);
    $value = $_POST['value'];
    $this->examroom_model->set_class_schedule_allow_exercise($class_id,$value);
  }

  public function ajax_allow_exercise_all() {
    /// JQuery เปิด-ปิด exercise
    $class_list = $this->examroom_model->getClassListAll();
    $value = $_POST['value'];
    foreach ($class_list as $class) {
      $class_id = $class['group_id'];
      $this->examroom_model->set_class_schedule_allow_exercise($class_id,$value);
    }
    
  }

  public function ajax_stu_preview() {
    /// JQuery ดึงข้อมูลนักศึกษาตามที่นั่งที่กด

    $roomNum = intval($_POST['roomNum']);
    $seatNum = intval($_POST['seatNum']);
    $this->load->model('lab_model');

    $seatData = $this->examroom_model->getSeatData($roomNum,$seatNum);
    $stuData = $this->examroom_model->getBriefInfoByStuId($seatData['stu_id']);
    $examItems = $this->examroom_model->getExamProblemList($roomNum, $seatData['stu_id']);
    $finishedWork = $this->examroom_model->getStudentFinishedWork($roomNum, $seatData['stu_id']);
    for ($i=0; $i<sizeof($examItems); $i++) {
      $examItems[$i]['name'] = $this->lab_model->get_lab_name($examItems[$i]['exercise_id']);
      foreach ($finishedWork as $submission) {
        if($submission['exercise_id']==$examItems[$i]['exercise_id']) {
          $examItems[$i]['marking'] = '2';
        }
      }
    }


    $stuPreview = new stdClass();
    $stuPreview->stuId = $seatData['stu_id'];
    $stuPreview->stuFullname = $stuData['stu_firstname'].' '.$stuData['stu_lastname'];
    $stuPreview->stuAvatar = $stuData['stu_avatar']?:'user.png';
    $stuPreview->examItems = $examItems;
    $stuPreview->progress = sizeof($finishedWork)*20;

    echo json_encode($stuPreview);

  }

  public function stu_code_preview($stuId, $problemId) {
    $this->load->model('time_model');
    $submissions = $this->examroom_model->getAllSourceCodePaths($stuId, $problemId);
    if($submissions != null) {
      for($i=0; $i<sizeof($submissions); $i++) {
        $path = $submissions[$i]['sourcecode_filename'];
        $srcFile = fopen("student_data/c_files/".$path,"r") or die("File Error Krub!");
        $srcStream = fread($srcFile, filesize("student_data/c_files/".$path));
        fclose($srcFile);
        $submissions[$i]['source_code'] = $srcStream;
        $submissions[$i]['time_submit'] = $this->time_model->unixTimeToRelativeFormat($submissions[$i]['UNIX_TIMESTAMP(time_submit)']);
      }
    }
    $this->load->view('supervisor/exam_room/window_pop_head');
    $this->load->view('supervisor/exam_room/code_preview',
        array('submissions' => $submissions,
            'stuId' => $stuId,
            'problemId' => $problemId));
    $this->load->view('supervisor/exam_room/window_pop_foot');
  }

  public function create_room($roomNum) {
    $this->examroom_model->createNewRoom($roomNum);
    redirect(site_url($this->MODULE_PATH."index"));
    die();
  }

  public function extra_student($roomNum) {
    $data = array(
        'room_num' => $roomNum,
        'temp_class_id' => $this->examroom_model->getRoomData($roomNum)['class_id'],
        'stu_list' => $this->examroom_model->getExtraStudentList($roomNum)
    );
    $this->load->view('supervisor/exam_room/window_pop_head');
    $this->load->view('supervisor/exam_room/extra_student',$data);
    $this->load->view('supervisor/exam_room/window_pop_foot');
  }

  public function add_swap_student() {
    $roomNum = intval($_POST['roomNum']);
    $stuId = intval($_POST['stuId']);
    $tempClassId = intval($_POST['tempClassId']);

    $realClassId = intval($this->examroom_model->getRealStudentGroupId($stuId));
    if($realClassId!=0 && $tempClassId!=$realClassId) {
      $swappable = $this->examroom_model->insertExtraStudent($stuId, $roomNum, $realClassId);
      if($swappable) {
        $this->examroom_model->setStudentGroupId($stuId, $tempClassId);
      }
    }
    redirect(site_url($this->MODULE_PATH."extra_student/".$roomNum));
    die();
  }

  public function revert_swap_student() {
    $roomNum = intval($_POST['roomNum']);
    $stuId = intval($_POST['stuId']);
    $realClassId = intval($_POST['realClassId']);

    $this->examroom_model->setStudentGroupId($stuId, $realClassId);
    $this->examroom_model->removeExtraStudent($stuId);

    redirect(site_url($this->MODULE_PATH."extra_student/".$roomNum));
    die();
  }

  public function get_online_student_exam($roomNum) {
    //echo __METHOD__;
    $this->load->model('examroom_model');
    $check_in = $this->examroom_model->getAllStudentIDSeatsData($roomNum);
    $online_student = $this->examroom_model->get_online_student_exam($roomNum);
    //$check_in = 
    //echo "<pre/>"; print_r($online_student); echo "</pre>";
    $data = array('online_student' => $online_student,
                  'check_in' => $check_in);
    echo json_encode($data);
  }

  public function display_score() {
    $classId = $_POST['group'];
    $examListId = $_POST['exam'];
    $data = array(
        'student_list' => $this->fetch_exam_score($classId, $examListId),
        'info' => array(
            'class_id' => $classId,
            'exam_list_id' => $examListId,
            'supervisor' => $this->examroom_model->getSupervisor($classId)
        )
    );
    $this->load->view('supervisor/exam_room/window_pop_head');
    $this->load->view('supervisor/exam_room/display_score',$data);
    $this->load->view('supervisor/exam_room/window_pop_foot');
  }

  private function fetch_exam_score($classId, $chapterId) {
    $scoreList = $this->examroom_model->getScoreFromExaminees($classId, $chapterId);
    $studentList = $this->examroom_model->getStudentNameListByClass($classId);
    for($i=0; $i<sizeof($studentList); $i++) {
      if(sizeof($scoreList)>0 &&  $studentList[$i]['stu_id']==$scoreList[0]['stu_id']) {
        $studentList[$i]['score'] = $scoreList[0]['SUM(a.marking)'];
        array_shift($scoreList);
      } else {
        $studentList[$i]['score'] = '0';
      }
    }
    return $studentList;
  }

  public function export_score_json() {
    $classId = $_POST['group'];
    $chapterId = $_POST['exam'];
    $data = json_encode($this->fetch_exam_score($classId, $chapterId) , JSON_PRETTY_PRINT);
    $fileName = 'exam_lab_'.$classId.'.json';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-Type: application/json;");
    $file = fopen('php://output', 'w');
    fwrite($file, $data);
    fclose($file);
    exit;
  }

  public function export_score_csv() {
    $classId = $_POST['group'];
    $chapterId = $_POST['exam'];
    $data = $this->fetch_exam_score($classId, $chapterId);
    $fileName = 'exam_lab_'.$classId.'.csv';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-Type: application/csv;");
    $file = fopen('php://output', 'w');
    $header = array("รหัสนักศึกษา", "ชื่อ", "นามสกุล", "คะแนนสอบ");
    fputcsv($file, $header);
    foreach ($data as $row)
    {
      fputcsv($file, $row);
    }
    fclose($file);
    exit;
  }

  public function check_student_out($room_number, $stu_id) {
    $this->examroom_model->checkOut($stu_id);
    redirect(site_url($this->MODULE_PATH.'seating_chart/'.$room_number));
  }

  public function update_selected_exam() {
    //echo '_POST : <pre>'; print_r($_POST); echo '</pre>';
    //	$_POST Array (    [user_id] => 900001    [group_id] => 17010010    [chapter] => 5;    [level] => 1    
    //	[selected_id_1] => 47   [selected_id_2] => 64)
    $group_id = $_POST['group_id'];		unset($_POST['group_id']);
    $user_id = $_POST['user_id'];		unset($_POST['user_id']);
    $chapter = $_POST['chapter'];		unset($_POST['chapter']);
    $level = $_POST['level'];			unset($_POST['level']);
    if(sizeof($_POST) <= 0 ) {
      $this->show_message("You must select at least ONE." );
      return;
    }

    //ตรวจสอบสิทธิ ในการแก้ไข
    $this->load->model('lab_model');
    $class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);

    //echo '<pre>'; print_r($class_schedule) ; echo '</pre>';
    $previledge = $this->check_previledge($group_id);
    if ($previledge == "none") {
      $this->show_message("You are not allow to select Exercises for student group : ".$class_schedule['group_no']);
    } else {
      //set selected exercise
      //echo "updating . . . \n";
      //echo '<pre>'; print_r($_POST); echo '</pre>';
      $list = $_POST;
      $this->lab_model->update_lab_class_item($group_id,$chapter,$level,$list);
    }
    $_POST['group_id'] = $group_id;
    $_POST['lab_no'] = $chapter;
    $this->select_exam_for_group();

  }

  public function show_message($message) {

		$data = array("message" => $message);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
		$this->load->view('supervisor/show_message',$data);
		$this->load->view('supervisor/footer');
	}

  public function select_exam_for_group() {
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($_POST); echo "</pre>";
		$group_id = $_POST['group_id'];
		$chapter_id = $_POST['lab_no'];
		
		$this->load->model('lab_model');
		$group_exercise_chapter = $this->lab_model->get_group_exercise_chapter($group_id,$chapter_id);
		//echo "<h3>". __METHOD__ ." : _POST :</h3><pre>"; print_r($group_exercise_chapter); echo "</pre>";
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
		$students_data = $this->lab_model->get_students_by_group_id($group_id); // array
		$group_lab_list = array();
		foreach($group_exercise_chapter as $row) {
			$item = $row['item_id'];
			$exercises = unserialize($row['exercise_id_list']);
			for($i=1; $i<=sizeof($exercises); $i++) {
				$group_lab_list[$item][$i]=$exercises[$i-1];
			}
		}

		$lab_exercise = $this->lab_model->get_lab_exercise_by_chapter($chapter_id);
		//echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";

		$lab_list = array();
		for ($i=0,$count=1; $i<sizeof($lab_exercise); $i++,$count++) {
			$level = $lab_exercise[$i]['lab_level'];			;
			$lab_list[$level][$count] = $lab_exercise[$i];
			if (!empty($lab_exercise[$i+1]) && $level < $lab_exercise[$i+1]['lab_level'])
				$count = 0;
			
		}
		//echo '<h4>$lab_list <pre>'; print_r($lab_list); echo "</pre>";

		



		//echo '<h4>$group_exercise_chapter <pre>'; print_r($group_exercise_chapter); echo "</pre>";
		//echo '<h4>$lab_exercise <pre>'; print_r($lab_exercise); echo "</pre>";
		$chapter_permission = $this->lab_model->get_group_permission($group_id);
		$chapter_permission = $chapter_permission[$chapter_id];
		$this->load->model('time_model');
		$chapter_data = $chapter_permission;
		$result = $this->time_model->check_allow_access_and_submit($chapter_data['time_start'],$chapter_data['time_end']);
		$chapter_data["allow_access"] = $result[0];
		$chapter_data["allow_submit"] = $result[1];



		$data = array(	
					'group_exercise_chapter'	=>	$group_exercise_chapter,
					'group_id'					=>	$group_id,
					'lab_no'					=>	$chapter_id,
					'group_lab_list'			=>	$group_lab_list,
					'lab_list'					=>	$lab_list,
					'class_schedule'			=>	$class_schedule,
					'chapter_permission'		=>	$chapter_data,
					'students_data'				=>	$students_data,
					'lab_info'		=>	$this->lab_model->get_lab_info(),
					'levels'	 	=> 	$this->lab_model->get_level()
				);
		$this->load->view('supervisor/head');
		$this->load->view('supervisor/nav_fixtop');
		$this->load->view('supervisor/nav_sideleft');
    $this->load->view('supervisor/exam_room/exam_select_for_group',$data);
    $this->load->view('supervisor/exam_room/exam_footer_no_roomnum');
		/* */
		
	}

  private function check_previledge($group_id) {
		$user_id = $_SESSION['id'];
		$this->load->model('lab_model');
		$class_schedule = $this->lab_model->get_class_schedule_by_group_id($group_id);
    $previledge = "none";
		if ($user_id == $class_schedule['lecturer']) {
			//this user is lecturer of the group
			$previledge = "lecturer";
		} else {
			foreach ( $class_schedule['lab_staff'] as $staff) {
				//echo '$staff<pre>'; print_r($staff) ; echo '</pre>';
				if($staff['staff_id'] == $user_id) {
					//this user is staff of this group
					$previledge = "staff";
				}
			}
		}
		//echo '$previledge : '.$previledge.'<br/>';
		return $previledge;
	}

  public function show_all_student($roomNum) {
    $this->load->model('lab_model');
    $class_id = $this->examroom_model->getRoomData($roomNum)["class_id"];
    $examListId = $this->examroom_model->getRoomData($roomNum)["chapter_id"];
    $students_data = $this->fetch_exam_list_level($class_id, $examListId,$roomNum);
    $check_in_list = $this->examroom_model->getStudentCheckedIN($roomNum);
    
    $data = array(
        'room_num' => $roomNum,
        'temp_class_id' => $class_id,
        'students_data' => $students_data,
        'check_in_list' => $check_in_list,
        'no_items' => $this->examroom_model->getAllExamChapter()[$examListId-1]['no_items']
    );
    $this->load->view('supervisor/exam_room/table_list_student',$data);
  }

  public function exam_student_password_reset() {
    $this->load->model('examroom_model');
		$stu_id = $_POST['stu_id'];
		$roomNumber = $_POST['roomNumber'];
    $stu_group = $this->examroom_model->getRoomData($roomNumber)["class_id"];
		echo 'stu_group : '.$stu_group.' stu_id :'.$stu_id;
		$this->load->model('student_model');
		$this->student_model->student_reset_password($stu_id);
		$this->createLogfile(__METHOD__ ." stu_id : $stu_id");
		
	}

  private function fetch_exam_list_level($classId, $chapterId,$roomNum) {
    $scoreList = $this->examroom_model->getScoreFromExaminees($classId, $chapterId);
    $studentList = $this->examroom_model->get_students_exam_by_group_id($classId);
    for($i=0; $i<sizeof($studentList); $i++) {
      if(sizeof($scoreList)>0 &&  $studentList[$i]['stu_id']==$scoreList[0]['stu_id']) {
        $studentList[$i]['score'] = $scoreList[0]['SUM(a.marking)'];
        $list_item = $this->examroom_model->getExamProblemList_and_lab_exercise($roomNum, $studentList[$i]['stu_id']);
        $studentList[$i]['list_item'] = array_column($list_item,'lab_name');
        array_shift($scoreList);
      } else {
        $studentList[$i]['score'] = '0';
        $list_item = $this->examroom_model->getExamProblemList_and_lab_exercise($roomNum, $studentList[$i]['stu_id']);
        $studentList[$i]['list_item'] = array_column($list_item,'lab_name');
      }
    }
    return $studentList;
  }

  public function reject_submission() {
    $submissionId = $_POST['submissionId'];
    $this->examroom_model->removeSubmissionById($submissionId);
    redirect(site_url($this->MODULE_PATH."stu_code_preview/".$_POST['stuId']."/".$_POST['problemId']));
    die();
  }

  public function CopyFrom() {
		$group_id = $_POST['group_id'];
		// $chapter_id = $_POST['lab_no'];
		print_r($_POST);
	}

  public function copyTo() {
		//echo "<h1 style='color:darkblue'>".__METHOD__."</h1>";
		// echo "<h2 style='color:blue'>Post variable </h2><br/><pre>"; print_r($_POST); echo "</pre><br/>";
		// echo "<h2 style='color:blue'>Environment</h2><br/><pre>"; print_r($_ENV); echo "</pre><br/>";
		// echo "<h2 style='color:blue'>Cookie </h2><br/><pre>"; print_r($_COOKIE); echo "</pre><br/>";
		// echo "<h2 style='color:blue'>Server </h2><br/><pre>"; print_r($_SERVER); echo "</pre><br/>";
		// //echo "<h2 style='color:blue'>FILE </h2><br/><pre>"; print_r($_FILE); echo "</pre><br/>";
		// echo "<h2 style='color:blue'>FILES </h2><br/><pre>"; print_r($_FILES); echo "</pre><br/>";
		$source_exercise_id = $this->input->post('exercise_id');
		$target_chapter_id = $this->input->post('chapter_id');
		$target_level = $this->input->post('level');
		$this->load->model('lab_model');

		// add a row in lab_exercise table
		$clone_exercise_id = $this->lab_model->cloneExercise($source_exercise_id, $target_chapter_id, $target_level);
		
		// clone all testcases in exercise_testcase table from $source_exercise_id to $clone_exercise_id
		// $source_exercise_id=63; $clone_exercise_id=  1301125;
		$this->lab_model->cloneTestcase($source_exercise_id, $clone_exercise_id);



		$source_lab_exercise = $this->lab_model->get_lab_exercise_by_id($source_exercise_id);
		//echo "<h2 style='color:blue'>Exercise ID: $source_exercise_id</h2><br/><pre>"; print_r($source_lab_exercise); echo "</pre><br/>";
		
		$sourcecode_filename = $source_lab_exercise['sourcecode'];
		$clone_filename = "exercise_".$clone_exercise_id.".c";
		if (file_exists(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename)) {
			// echo "The file $sourcecode_filename ==> OK.\n";
			// echo "target = $clone_filename \n";
			$status = copy(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename , SUPERVISOR_CFILES_FOLDER.$clone_filename);
			// if ($status) {
			// 	echo "copy ok";
			// } else {
			// 	echo "copy NG.";
			// }
		}

		$_POST = array();
		$_POST['exercise_id']= $clone_exercise_id;
		$this->exercise_edit();
		
	}
  

}
?>
