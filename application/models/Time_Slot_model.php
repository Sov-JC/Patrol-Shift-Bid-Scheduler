<?php

class Time_Slot_model extends CI_Model { 
    
    public function get_time_slots_given_shift_type_id($shift_type_id){
        $query = $this->db->get_where('time_slot',["shiftTypeID" => $shift_type_id]);
        return $query->result();
    }
    
    public function get_time_slots_given_subcategory_id($subcategory_id){
        $query = $this->db->get_where('time_slot',["subCategoryID" => $subcategory_id]);
        return $query->result();
    }
    
    /**
    *Check if a user is already assigned to a time slot
    *
    *@param string $time_slot_id the pk of the time slot
    *                            to check
    *
    *@return bool return TRUE if the time slot exists and has a user assigned to it.
    *             Returns FALSE if the time slot exists but a user is not assigned.
    *             Returns NULL if the time slot could not be found. 
    */
    public function is_time_slot_taken($time_slot_id){        
        $this->db->select('*');
        $this->db->from('time_slot');
        $this->db->where('timeSlotID', $time_slot_id);
        $row = $this->db->get()->row();
        
        if($row == NULL)
            return NULL;
        
        
        if($row->userID == NULL)
            return FALSE;
                
        return TRUE;
    }
    
}
