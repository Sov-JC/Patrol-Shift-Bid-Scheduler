<?php

class Shift_Type_model extends CI_Model { 
    
    /*
    //DEP
    public function get_shift_types_given_subcategory_id($subcategory_id){
        $query = $this->db->get_where('shift_type', ["subCategoryID" => $subcategory_id]);
        return $query->result();
    }
    */
    
    
    //DEP
    public function get_shift_types(){        
        return $this->db->get("shift_type")->result();        
    }
    
    /**
    * get the shifts that belong to a bid schedule
    * 
    * @param $bid_schedule_id the bid schedule that you want to find
    *                         all the bids for
    *
    * @return CI_result_object[] the bid shifts belonging to the bid schedule
    */
    public function get_shift_types_for_a_schedule($bid_schedule_id){
        $this->db->select('*');
        $this->db->from('shift_type');
        $this->db->where('bidScheduleID', $bid_schedule_id);
        
        return $this->db->get()->result();
    }
    
    public function get_shift_types_given_time_slot($time_slot_id){
        $query = $this->db->get_where('shift_type', ["timeSlotID" => $time_slot_id]);
        return $query->result();
    }
    
    
    public function get_shifts_given_bid_schedule($bid_schedule_id){
        $att_val = ["bidScheduleID" => $bid_schedule_id];
        $query = $this->db->get_where('shift_type', $att_val);
        return $query->result();
    }
    
    public function add_shift($shift_name, $bid_schedule_id){
        $row = [
            "shiftName" => $shift_name,
            "bidScheduleID" => $bid_schedule_id
        ];
        
        return $this->db->insert("shift_type", $row);
    }
    
}
