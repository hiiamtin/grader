<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examroom_model extends CI_Model
{
    private $TABLE_EXAM_ROOM = 'exam_room';
    private $TABLE_EXAM_SEAT = 'exam_seat';

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

        if($needToAllow == 'unchecked') {
            $this->db->where('room_number',$roomNumber);
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

    public function getRoomData($roomNumber)
    {
        $this->db->select('*')
            ->from($this->TABLE_EXAM_ROOM)
            ->where('room_number', $roomNumber);
        $query = $this->db->get();
        return $query->result_array()[0];
    }

    public function checkIn($roomNumber, $seatNumber, $stuId, $stuGroup)
    {
        $roomData = $this->getRoomData($roomNumber);

        if($roomData['allow_check_in']=='checked' and $this->isSeatAvailable($roomNumber, $seatNumber) and !$this->hasAlreadyCheckIn($stuId)) {
            $data = array('room_number' => $roomNumber,
                'seat_number' => $seatNumber,
                'stu_id' => $stuId,
                'progress' => 0);
            $this->db->insert($this->TABLE_EXAM_SEAT, $data);
            return true;
        }
        else {
            return false;
        }

    }

    public function checkOut($stu_id){
        $this->db->where('stu_id', $stu_id);
        $this->db->delete($this->TABLE_EXAM_SEAT);
    }

    public function hasAlreadyCheckIn($stuId) {
        $this->db->select('room_number')
            ->from($this->TABLE_EXAM_SEAT)
            ->where('stu_id', $stuId);
        $query = $this->db->get();
        $query = $query->result_array();
        if (empty($query)) {
            return null;
        }
        else {
            return $query[0];
        }
    }

    public function getSeatData($roomNumber) {
        $this->db->select('*')
            ->from($this->TABLE_EXAM_SEAT)
            ->where('room_number', $roomNumber)
            ->order_by("seat_number");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStudentData_exam_seat($stu_id) {
        $this->db->select('*')
            ->from($this->TABLE_EXAM_SEAT)
            ->where('stu_id', $stu_id);
        $query = $this->db->get();
        return $query->result_array()[0];
    }

    public function save_Setting($room_number,$chapter_id)
    {
        $data = array('chapter_id' => $chapter_id);
        $this->db->where('room_number', $room_number);
        $this->db->set($data);
        $this->db->update($this->TABLE_EXAM_ROOM);
    }
    public function isSeatAvailable($roomNumber, $seatNumber) {
        $this->db->select('*')
            ->from($this->TABLE_EXAM_SEAT)
            ->where('room_number', $roomNumber)
            ->where('seat_number', $seatNumber)
            ->order_by("seat_number");
        $query = $this->db->get();
        return empty($query->result_array());
    }


}//class Examroom_model