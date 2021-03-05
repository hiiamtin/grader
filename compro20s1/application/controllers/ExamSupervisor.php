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
        'class_list' => $this->examroom_model->getClassListWithSupervisorName()
    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/nav_sideleft',$data);
    $this->load->view('supervisor/exam_room/panel',$exam_data);
    $this->load->view('supervisor/exam_room/popup_group_select');
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
        'accessible_room' => $roomNum,
        'chapter_data' => $chapter_data,
      //'in_social_distancing' => $roomData["in_social_distancing"],
        'group_number' => substr($class_id, 6),
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
    $this->load->view('supervisor/exam_room/popup_setting1',$roomData);
    $this->load->view('supervisor/exam_room/popup_stu_preview',$roomData);
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

  public function set_level_allow_access() {
    $this->load->model('supervisor_model');
    $supervisor_data = array(
        'supervisor_data'	=> $this->supervisor_model->get_supervisor_data()
    );
    $class_id = $_POST["class_id"];
    $chapter_id = $_POST["chapter_id"];
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

    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/nav_sideleft',$supervisor_data);
    $this->load->view('supervisor/exam_room/exam_select_for_group',$data);
    $this->load->view('supervisor/footer');
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

  public function ajax_social_distancing() {
    /// JQuery เปิด-ปิด เว้นระยะห่าง

    $roomNumber = intval($_POST['roomNumber']);
    $distancing = $_POST['value'];
    $this->examroom_model->setSocialDistancing($distancing,$roomNumber);
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
    $this->load->view('supervisor/head');
    //$this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/exam_room/code_preview', array('submissions' => $submissions));
    $this->load->view('supervisor/footer');
  }

  public function create_room($roomNum) {
    $this->examroom_model->createNewRoom($roomNum);
    redirect(site_url($this->MODULE_PATH."exam_room_panel"));
    die();
  }

  public function extra_student($roomNum) {
    $data = array(
        'room_num' => $roomNum,
        'temp_class_id' => $this->examroom_model->getRoomData($roomNum)['class_id'],
        'stu_list' => $this->examroom_model->getExtraStudentList($roomNum)
    );
    $this->load->view('supervisor/head');
    $this->load->view('supervisor/nav_fixtop');
    $this->load->view('supervisor/nav_sideleft');
    $this->load->view('supervisor/exam_room/extra_student',$data);
    $this->load->view('supervisor/footer');
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

}

?>