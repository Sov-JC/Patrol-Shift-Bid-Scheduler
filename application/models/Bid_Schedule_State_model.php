<?php

class Bid_Schedule_State_model extends CI_Model { 
    
    
    
    //returns the ID of the "justCreated" state
    public function get_just_created_state_id(){
        $JC_STATE_NAME = "justCreated";
        $this->db->select("bidScheduleStateID");
        $this->db->from("bid_schedule_state");
        $this->db->where("name",$JC_STATE_NAME);
        $query = $this->db->get();
        
        $id = $query->result()[0]->bidScheduleStateID;
        
        return $id;
    }
    
    //returns the ID of the "open" state
    public function get_open_state_id(){
        $OPEN_STATE_NAME = "open";
        $this->db->select("bidScheduleStateID");
        $this->db->from("bid_schedule_state");
        $this->db->where("name",$OPEN_STATE_NAME);
        $query = $this->db->get();
        
        $id = $query->result()[0]->bidScheduleStateID;
        
        return $id;
    }
    
    //returns the ID of the "closed" state
    public function get_closed_state_id(){
        $CLOSED_STATE_NAME = "closed";
        $this->db->select("bidScheduleStateID");
        $this->db->from("bid_schedule_state");
        $this->db->where("name",$CLOSED_STATE_NAME);
        $query = $this->db->get();
        
        $id = $query->result()[0]->bidScheduleStateID;
        
        return $id;
    }
    
    
}
