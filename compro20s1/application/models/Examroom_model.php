<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examroom_model extends CI_Model
{
  private $TABLE_EXAM_ROOM = 'exam_room';
  private $TABLE_EXAM_SEAT = 'exam_seat';
  private $TABLE_EXAM_SUBMISSION = 'exam_answer_submission';

  public function __construct()
  {
    parent::__construct();
  }

  public function getAllExamRoom()
  {
    $this->db->select('*')
        ->from($this->TABLE_EXAM_ROOM);
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
    $this->db->update($this->TABLE_EXAM_ROOM);

    if ($needToAllow == 'unchecked') {
      $this->db->where('room_number', $roomNumber);
      $this->db->delete($this->TABLE_EXAM_SEAT);
    }
  }

  public function setAllowCheckIn($needToAllow, $roomNumber)
  {
    $data = array('allow_check_in' => $needToAllow);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    return $this->db->update($this->TABLE_EXAM_ROOM);
  }

  public function setSocialDistancing($distancing, $roomNumber) {
    $data = array('in_social_distancing' => $distancing);
    $this->db->where('room_number', $roomNumber);
    $this->db->set($data);
    return $this->db->update($this->TABLE_EXAM_ROOM);
  }

  public function checkIn($roomNumber, $seatNumber, $stuId, $stuGroup)
  {
    $roomData = $this->getRoomData($roomNumber);

    if ($roomData['allow_check_in'] == 'checked' and $this->isSeatAvailable($roomNumber, $seatNumber) and !$this->hasAlreadyCheckIn($stuId)) {
      $data = array('room_number' => $roomNumber,
          'seat_number' => $seatNumber,
          'stu_id' => $stuId,
          'helper' => EXAM_HELPER_CREDIT,
          'progress' => 0);
      $this->db->insert($this->TABLE_EXAM_SEAT, $data);
      return true;
    } else {
      return false;
    }

  }

  public function getRoomData($roomNumber)
  {
    $this->db->select('*')
        ->from($this->TABLE_EXAM_ROOM)
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
        ->from($this->TABLE_EXAM_SEAT)
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
        ->from($this->TABLE_EXAM_SEAT)
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
    $this->db->delete($this->TABLE_EXAM_SEAT);
  }

  public function getAllSeatsData($roomNumber) {
    $classId = $this->getRoomData($roomNumber)['class_id'];
    $sql = 'SELECT user_student.stu_id, user_student.stu_firstname, user_student.stu_avatar, exam_seat.seat_number, exam_seat.progress'
        .' FROM user_student, exam_seat'
        .' WHERE user_student.stu_group = '.$classId
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
        ->from($this->TABLE_EXAM_SEAT)
        ->where('stu_id', $stu_id);
    $query = $this->db->get();
    return $query->result_array()[0];
  }

  public function save_Setting($room_number, $chapter_id)
  {
    $data = array('chapter_id' => $chapter_id);
    $this->db->where('room_number', $room_number);
    $this->db->set($data);
    $this->db->update($this->TABLE_EXAM_ROOM);
  }

  public function notYetAssigned($stuId, $level) {
    $this->db->select('*')
      ->from($this->TABLE_EXAM_SUBMISSION)
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
      ->where('exercise_id IS NOT NULL', null, false);
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

  public function getStudentAccessibleRoom($classId) {
    $this->db->select('*')
        ->from($this->TABLE_EXAM_ROOM)
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
    return $this->db->update($this->TABLE_EXAM_SEAT);
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


}//class Examroom_model