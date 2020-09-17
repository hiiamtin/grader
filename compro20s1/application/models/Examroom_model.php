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

    public function setAllowAccess($needToAllow, $roomNumber)
    {
        $data = array('allow_access' => $needToAllow);
        $this->db->where('room_number', $roomNumber);
        $this->db->set($data);
        return $this->db->update($this->TABLE_EXAM_ROOM);
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
        if($roomData['allow_check_in']=='checked' and $roomData['class_id']==$stuGroup) {
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

}//class Examroom_model