<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examroom_model extends CI_Model
{
    private $TABLE_EXAM_ROOM = 'exam_room';

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

}//class Examroom_model