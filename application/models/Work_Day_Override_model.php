<?php

class Work_Day_Override_model extends CI_Model { 
    
    public function get_work_day_overrides_given_time_slot_id($time_slot_id){
        $query = $this->db->get_where('work_day_override',["timeSlotID" => $time_slot_id]);
        return $query->result();
    }
    
}
