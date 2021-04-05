<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examroom_model extends CI_Model
{
  private $TABLE_ROOM = 'exam_room_info';
  private $TABLE_SEAT = 'exam_seat';
  private $TABLE_SUBMISSION = 'exam_answer_submission';
  private $TABLE_SWAP = 'exam_student_swap';

  public function __construct()
  {
    parent::__construct();
  }

  public function getAllExamRoom()
  {
    $this->db->select('*')
        ->from($this->TABLE_ROOM);
    $query = $this->db->get();

    $query = $query->result_array();
    $examRoom = array();
    foreach ($query as $row) {
      $examRoom[$row['room_number']] = $row;
    }
    return $examRoom;
  }

  public function setAllowAccess($needToAllow, $roomNumber, $classId)
  {
    $data = array('allow_access' => $needToAllow,
        'class_id' => $classId);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    $this->db->update($this->TABLE_ROOM);

    if ($needToAllow == 'unchecked') {
      $this->db->where('room_number', $roomNumber);
      $this->db->delete($this->TABLE_SEAT);
    }
  }

  public function setAllowCheckIn($needToAllow, $roomNumber)
  {
    $data = array('allow_check_in' => $needToAllow);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    return $this->db->update($this->TABLE_ROOM);
  }

  public function setSocialDistancing($distancing, $roomNumber) {
    $data = array('in_social_distancing' => $distancing);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    return $this->db->update($this->TABLE_ROOM);

  }

  public function setSocialDistancing_and_clear($distancing, $roomNumber) {
    $this->db->where('room_number', $roomNumber);
    $this->db->delete($this->TABLE_SEAT);

    $data = array('in_social_distancing' => $distancing);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    return $this->db->update($this->TABLE_ROOM);

  }

  public function checkIn($roomNumber, $seatNumber, $stuId, $stuGroup)
  {
    $roomData = $this->getRoomData($roomNumber);

    if ($roomData['allow_check_in'] == 'checked') {
      if($this->isSeatAvailable($roomNumber, $seatNumber) and !$this->hasAlreadyCheckIn($stuId)){
        $data = array('room_number' => $roomNumber,
          'seat_number' => $seatNumber,
          'stu_id' => $stuId,
          'helper' => EXAM_HELPER_CREDIT,
          'progress' => 0);
        $this->db->insert($this->TABLE_SEAT, $data);
        return ERR_NONE;
      }else{
        return ERR_SEAT_NOT_AVAILABLE;
      }
    } else {
      return ERR_NOT_ALLOW_CHECK_IN;
    }

  }

  public function getRoomData($roomNumber)
  {
    $this->db->select('*')
        ->from($this->TABLE_ROOM)
        ->where('room_number', $roomNumber);
    $query = $this->db->get();
    return $query->result_array()[0];
  }

  public function isSeatAvailable($roomNumber, $seatNumber)
  {
    $seatData = $this->getSeatData($roomNumber, $seatNumber);
    return empty($seatData);
  }

  public function getSeatData($roomNumber, $seatNumber)
  {
    $this->db->select('*')
        ->from($this->TABLE_SEAT)
        ->where('room_number', $roomNumber)
        ->where('seat_number', $seatNumber);
    $query = $this->db->get();
    if (empty($query->result_array())) {
      return array();
    } else {
      return $query->result_array()[0];
    }
  }

  public function hasAlreadyCheckIn($stuId)
  {
    $this->db->select('room_number')
        ->from($this->TABLE_SEAT)
        ->where('stu_id', $stuId);
    $query = $this->db->get();
    $query = $query->result_array();
    if (empty($query)) {
      return null;
    } else {
      return $query[0];
    }
  }

  public function checkOut($stu_id)
  {
    $this->db->where('stu_id', $stu_id);
    $this->db->delete($this->TABLE_SEAT);
  }

  public function getAllSeatsData($roomNumber) {
    $sql = 'SELECT user_student.stu_id, user_student.stu_firstname, user_student.stu_avatar, exam_seat.seat_number, exam_seat.progress, exam_seat.room_number'
        .' FROM user_student, exam_seat'
        .' WHERE exam_seat.room_number = '.$roomNumber
        .' AND exam_seat.stu_id = user_student.stu_id';
    $query = $this->db->query($sql);
    $allData = $query->result_array();
    for($i=0; $i<sizeof($allData); $i++) {
      $allData[$i]['progress'] = sizeof($this->getStudentFinishedWork($roomNumber, $allData[$i]['stu_id']))*20;
    }
    return $allData;
  }

  public function getStudentData_exam_seat($stu_id)
  {
    $this->db->select('*')
        ->from($this->TABLE_SEAT)
        ->where('stu_id', $stu_id);
    $query = $this->db->get();
    return $query->result_array()[0];
  }

  public function save_Setting($room_number, $chapter_id)
  {
    $data = array('chapter_id' => $chapter_id);
    $this->db->where('room_number', $room_number);
    $this->db->set($data);
    $this->db->update($this->TABLE_ROOM);
  }

  public function notYetAssigned($stuId, $level) {
    $this->db->select('*')
      ->from($this->TABLE_SUBMISSION)
      ->where('stu_id', $stuId)
      ->where('level', $level);
    $query = $this->db->get();
    return empty($query->result_array()[0]);
  }

  public function getExamProblemList($roomNum, $stuId) {
    $chapterId= $this->getRoomData($roomNum)['chapter_id'];
    $this->db->select('*')
      ->from('student_assigned_chapter_item')
      ->where('stu_id', $stuId)
      ->where('chapter_id',$chapterId)
      ->where('exercise_id IS NOT NULL', null, false)
      ->order_by('item_id', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAllSourceCodePaths($stuId, $problemId)
  {
    $this->db->select('submission_id, UNIX_TIMESTAMP(time_submit), sourcecode_filename')
        ->from('exercise_submission')
        ->where('stu_id', $stuId)
        ->where('exercise_id',$problemId)
        ->order_by('submission_id','DESC');
    $query = $this->db->get();
    if(sizeof($query->result_array())>0) {
      return $query->result_array();
    } else {
      return null;
    }
  }

  public function getSupervisor($classId) {
    $this->db->select('lecturer')
      ->from('class_schedule')
      ->where('group_id', $classId);
    $query = $this->db->get();
    $supervisorId = $query->result_array()[0]['lecturer'];
    $this->db->select('*')
        ->from('user_supervisor')
        ->where('supervisor_id', $supervisorId);
    $query = $this->db->get();
    return $query->result_array()[0];
  }

  public function getNumberOfStudentInClass($classId) {
    $this->db->select('stu_id')
        ->from('user_student')
        ->where('stu_group', $classId);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function getClassListWithSupervisorName() {
    $this->db->select('group_id, lecturer')
        ->from('class_schedule');
    $query = $this->db->get();
    $classList = $query->result_array();

    for ($i=0; $i<sizeof($classList); $i++) {
      $this->db->select('supervisor_firstname, supervisor_lastname')
          ->from('user_supervisor')
          ->where('supervisor_id', $classList[$i]['lecturer']);
      $query = $this->db->get();
      $name = $query->result_array()[0];
      $classList[$i]['lecturer'] = $name['supervisor_firstname'].' '.$name['supervisor_lastname'];
    }
    return $classList;
  }

  public function getClassListAll() {
    $this->db->select('*')
        ->from('class_schedule');
    $query = $this->db->get();
    $classList = $query->result_array();

    for ($i=0; $i<sizeof($classList); $i++) {
      $this->db->select('supervisor_firstname, supervisor_lastname')
          ->from('user_supervisor')
          ->where('supervisor_id', $classList[$i]['lecturer']);
      $query = $this->db->get();
      $name = $query->result_array()[0];
      $classList[$i]['lecturer'] = $name['supervisor_firstname'].' '.$name['supervisor_lastname'];
    }
    return $classList;
  }

  public function getStudentAccessibleRoom($classId) {
    $this->db->select('*')
        ->from($this->TABLE_ROOM)
        ->where('class_id', $classId);
    $query = $this->db->get();
    if(empty($query->result_array())){
      return null;
    } else {
      return $query->result_array()[0];
    }
  }

  public function getDepartment($classId) {
    $this->db->select('department')
        ->from('class_schedule')
        ->where('group_id', $classId);
    $query = $this->db->get();
    $deptId = $query->result_array()[0]['department'];
    $this->db->select('dept_name')
        ->from('department')
        ->where('dept_id', $deptId);
    $query = $this->db->get();
    return $query->result_array()[0]['dept_name'];
  }

  public function getBriefInfoByStuId($stuId)
  {
    $this->db->select('stu_firstname, stu_lastname, stu_avatar')
        ->from('user_student')
        ->where('stu_id', $stuId);
    $query = $this->db->get();
    return $query->result_array()[0];
  }

  public function getStudentFinishedWork($roomNum, $stuId) {
    $chapterId = $this->getRoomData($roomNum)['chapter_id'];
    $query = $this->db->query(
        'SELECT *'
        .' FROM student_assigned_chapter_item'
        .' WHERE chapter_id = '.$chapterId
        .' AND stu_id = '.$stuId
        .' AND exercise_id IN ('
        .'    SELECT exercise_id'
        .'    FROM exercise_submission'
        .'    WHERE stu_id = '.$stuId
        .'    AND marking = 2'
        .' )'
    );
    return $query->result_array();
  }

  public function getHelperCredit($stuId) {
    $query = $this->db->query(
        'SELECT helper'
        .' FROM exam_seat'
        .' WHERE stu_id = '.$stuId
    );
    return intval($query->result_array()[0]['helper']);
  }

  public function setHelperCredit($stuId, $credit) {
    $data = array('helper' => $credit);
    $this->db->where('stu_id', $stuId);
    $this->db->set($data);
    return $this->db->update($this->TABLE_SEAT);
  }

  public function getOldProblemId($stuId, $chapterId, $level) {
    $query = $this->db->query(
        'SELECT exercise_id'
        .' FROM student_assigned_chapter_item'
        .' WHERE stu_id = '.$stuId
        .' AND chapter_id = '.$chapterId
        .' AND item_id = '.$level
    );
    return intval($query->result_array()[0]['exercise_id']);
  }

  public function removeStudentAssigned($stuId, $assigned) {
    $query = $this->db->query(
        'DELETE'
        .' FROM student_assigned_chapter_item'
        .' WHERE stu_id = '.$stuId
        .' AND exercise_id = '.$assigned
    );
    return $query;
  }

  public function removeStudentSubmission($stuId, $assigned) {
    $query = $this->db->query(
        'DELETE'
        .' FROM exercise_submission'
        .' WHERE stu_id = '.$stuId
        .' AND exercise_id = '.$assigned
    );
    return $query;
  }

  public function getExtraStudentList($roomNum) {
    $query = $this->db->query(
        'SELECT u.stu_id, u.stu_firstname, u.stu_lastname, e.stu_group'
        .' FROM user_student u, exam_student_swap e'
        .' WHERE u.stu_id = e.stu_id'
        .' AND room_number = '.$roomNum
    );
    return $query->result_array();
  }

  public function insertExtraStudent($stuId, $roomNum, $classId)
  {
    // Check if student were swapped or checked in
    $query = $this->db->query(
        'SELECT *'
        . ' FROM ' . $this->TABLE_SWAP . ' swap ,' . $this->TABLE_SEAT . ' seat'
        . ' WHERE swap.stu_id = ' . $stuId
        . ' OR seat.stu_id = '. $stuId
    );
    if (sizeof($query->result_array()) == 0) {
      $data = array('room_number' => $roomNum,
          'stu_id' => $stuId,
          'stu_group' => $classId);
      $this->db->insert($this->TABLE_SWAP, $data);
      return true;
    }
    return false;
  }

  public function removeExtraStudent($stuId) {
    $query = $this->db->query(
        'DELETE'
        .' FROM '.$this->TABLE_SWAP
        .' WHERE stu_id = '.$stuId
    );
    return $query;
  }

  public function setStudentGroupId($stuId, $groupId) {
    $data = array('stu_group' => $groupId);
    $this->db->where('stu_id', $stuId);
    $this->db->set($data);
    return $this->db->update('user_student');
  }

  public function getRealStudentGroupId($stuId) {
    $query = $this->db->query(
        'SELECT stu_group'
        .' FROM user_student'
        .' WHERE stu_id = '.$stuId
    );
    return $query->result_array()[0]['stu_group'];
  }

  public function isThisGroupInExam($classId) {
    $query = $this->db->query(
        'SELECT class_id'
        .' FROM '.$this->TABLE_ROOM
        .' WHERE class_id = '.$classId
    );
    return (sizeof($query->result_array())!=0);
  }

  public function get_class_schedule_by_class_id($class_id){
    
    $this->db->select('*')
				->from('class_schedule')
				->join('user_supervisor', 'class_schedule.lecturer = user_supervisor.supervisor_id') 
				->join('department', 'class_schedule.department = department.dept_id') 
				->where('group_id', $class_id);

		$query = $this->db->get();
		$result = $query->first_row('array');
		

		return $result;
  }

  public function set_class_schedule_allow_exercise($class_id, $value) {
    $data = array('allow_exercise' => $value);
    $this->db->where('group_id', $class_id);
    $this->db->set($data);
    return $this->db->update('class_schedule');
  }

  public function createNewRoom($roomNum) {
    $data = array('room_number' => $roomNum,
        'class_id' => 0,
        'allow_access' => "unchecked",
        'allow_check_in' => "unchecked",
        'in_social_distancing' => "unchecked",
        'is_active' => "no",
        'chapter_id' => 11);
    $this->db->insert($this->TABLE_ROOM, $data);
  }

  public function get_online_student_exam($roomNum) {
    $class_id = $this->getRoomData($roomNum)['class_id'];

		$query = $this->db->query('SELECT `T1`.`stu_id` AS `student_id` 
						FROM `user_student` AS `T1` 
						LEFT JOIN `user` AS `T2` ON `T1`.`stu_id` = `T2`.`id` 
						WHERE `status`="online" AND `stu_group` = '.$class_id);
    

		
		return $query->result_array();
	
	}

  public function getAllStudentIDSeatsData($roomNumber) {
    $sql = 'SELECT stu_id'
        .' FROM exam_seat'
        .' WHERE room_number = '.$roomNumber;
    $query = $this->db->query($sql);
    $allData = $query->result_array();
    return $allData;
  }

  public function getStudentCheckedIN($roomNumber) {
    $sql = 'SELECT stu_id'
        .' FROM exam_seat'
        .' WHERE room_number = '.$roomNumber;
    $query = $this->db->query($sql);
    $allData = $query->result_array();
    return array_column($allData,'stu_id');
  }

  public function get_students_exam_by_group_id($stu_group_id) {
		$this->db->select('stu_id,stu_firstname,stu_lastname,stu_nickname,stu_avatar,status')
				->from('user_student')
				->join('user', 'user.id = user_student.stu_id')
				->where('stu_group', $stu_group_id);
		$query = $this->db->get();
		return $query->result_array();
	}

  public function getExamProblemList_and_lab_exercise($roomNum, $stuId) {
    $chapterId= $this->getRoomData($roomNum)['chapter_id'];
    $this->db->select('*')
      ->from('student_assigned_chapter_item')
      ->join('lab_exercise','lab_exercise.exercise_id = student_assigned_chapter_item.exercise_id')
      ->where('stu_id', $stuId)
      ->where('chapter_id',$chapterId)
      ->where('student_assigned_chapter_item.exercise_id IS NOT NULL', null, false)
      ->order_by('item_id', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function getScoreFromExaminees($classId, $examListId) {
    $sql = 'SELECT a.stu_id, b.stu_firstname, b.stu_lastname, SUM(a.marking)'
        .' FROM exercise_submission a, user_student b'
        .' WHERE a.stu_id = b.stu_id'
        .' AND b.stu_group = '.$classId
        .' AND a.exercise_id IN ('
        .'    SELECT exercise_id'
        .'    FROM lab_exercise'
        .'    WHERE lab_chapter = '.$examListId
        .' )'
        .' GROUP BY b.stu_id'
        .' ORDER BY a.stu_id';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getStudentNameListByClass($classId) {
    $sql = 'SELECT stu_id, stu_firstname, stu_lastname'
        .' FROM user_student'
        .' WHERE stu_group = '.$classId
        .' ORDER BY stu_id';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getAllExamChapter() {
    $sql = 'SELECT *'
        .' FROM lab_classinfo'
        //.' WHERE chapter_id > 10'
        .' ORDER BY chapter_id';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function removeSubmissionById($submissionId) {
    $sql = 'DELETE'
        .' FROM exercise_submission'
        .' WHERE submission_id = '.$submissionId;
    return $this->db->query($sql);
  }
}//class Examroom_model