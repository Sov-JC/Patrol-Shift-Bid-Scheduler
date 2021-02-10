<?php

class Bid_Schedule_model extends CI_Model {    
    
    //returns all bid schedules
	public function get_bid_schedules() {            
		return $this->db->get('bid_schedule')->result();
	}
    
    //returns a bid schedule with id 'id'
    public function get_bid_schedule($id){
        $this->db->select('*');
        $this->db->from('bid_schedule');
        $this->db->where('bidScheduleID', $id);
        $query = $this->db->get();
        $row = $query->row();
        
        return $row;
    }
    
    //get all the schedules that are "open"
    public function get_open_schedules(){
        $STATE_NAME = "open";        
        
        #select the bid schedules that are in the state of "open"
        $sql = "            
            select b.*
            from (bid_schedule as b) join (bid_schedule_state as s) on (b.bidScheduleStateID = s.bidScheduleStateID)
            where s.name = \"$STATE_NAME\"";  
        
        $query = $this->db->query($sql);        
        return $query->result();
    }
    
    //get all the schedules that are "closed"
    public function get_closed_schedules(){
        $STATE_NAME = "closed";        
        
        #select the bid schedules that are in the state of "closed"
        $sql = "            
            select b.*
            from (bid_schedule as b) join (bid_schedule_state as s) on (b.bidScheduleStateID = s.bidScheduleStateID)
            where s.name = \"$STATE_NAME\"";  
        
        $query = $this->db->query($sql);        
        return $query->result();
    }
    
    //get all the schedules that are "just created"
    public function get_just_created_schedules(){
        $STATE_NAME = "justCreated";
        
        #select the bid schedules that are in the state of "just created"
        $sql = "            
            select b.*
            from (bid_schedule as b) join (bid_schedule_state as s) on (b.bidScheduleStateID = s.bidScheduleStateID)
            where s.name = \"$STATE_NAME\"";  
        
        $query = $this->db->query($sql);        
        return $query->result();
    }
    
    //checks if an an attribute exists with the value of 'value' in the bid schedule table
    public function attribute_value_exists($attribute_name, $value){
        echo "\$value before escape is: $value <br>";
        echo "\$attribute_name before escape is: $attribute_name <br>";
        //$attribute_name = $this->db->escape($attribute_name);
        //$value = $this->db->escape($value);
        //echo "\$value (after escape) is: " . $value . "<br>";
        /*
        $this->db->select("*");
        $this->db->from("bid_schedule");
        $this->db->where("$attribute_name = $value");
        */
        $this->db->select("*");
        $this->db->from('bid_schedule');          
        $this->db->where($attribute_name, $value);
        
        $query = $this->db->get();
        
        return sizeof($query->result()) > 0 ? TRUE : FALSE;
    }
    
    //get all the subcategories that belong to the bid schedule
    //with id $bid_schedule_id
    public function get_all_subcategories($bid_schedule_id){
        $this->db->select('*');
        $this->db->from('subcategory');
        $this->db->where('bidScheduleID',$bid_schedule_id);
        $query = $this->db->get();        
        return $query->result();
    }
    

    /**
     * Creates a bid schedule. Newly created bid schedules
     * start in the 'Just Created' state.
     * @param string $name The name of the bidding schedule
     * @param string $datetimeStart The start date of the patrol schedule (in EST timezone) 
     *                                      in MySQL datetime format: 'YYYY-MM-DD HH:MM:SS'
     * @param string $dateTimeEnd The end date of the patrol schedule (in EST timezone)
     *                                      in MySQL datetime format: 'YYYY-MM-DD HH:MM:SS'
     *      
    */ 
    public function create_bid_schedule($name, $datetimeStart, $datetimeEnd){
        $this->load->model("bid_schedule_state_model");
        $bid_schedule_state_id = $this->bid_schedule_state_model->get_just_created_state_id();
        $date_created = NULL; //TODO: IMPLEMENT LATER
        
        //TODO: Add date created attribute
        $data = ['scheduleStart' => $datetimeStart,
                'scheduleEnd' => $datetimeEnd,
                'name' => $name,
                'bidScheduleStateID' => $bid_schedule_state_id
                ];
        
        return $this->db->insert('bid_schedule', $data);
    }
    
    //Retrives the state name that the bid schedule is in
    public function get_state_name_of_bid_schedule($bid_schedule_id){
        //get bss state id
        $this->db->select('*');
        $this->db->from('bid_schedule');
        $this->db->where('bidScheduleID', $bid_schedule_id);
        $query = $this->db->get();
        $row = $query->row();
        
        
        $bss_state_id = $row->bidScheduleStateID;
        
        //get bss name
        $this->db->select('*');
        $this->db->from('bid_schedule_state');
        $this->db->where('bidScheduleStateID', $bss_state_id);
        $query = $this->db->get();
        $row = $query->row();
        
        $name = $row->name;
        
        return $name;
    }
    
    //change a bid schedules state
    public function change_bid_schedule_state($bid_schedule_id, $new_state_id){
        $data = ['bidScheduleStateId' => $new_state_id];
        $this->db->where('bidScheduleID', $bid_schedule_id);
        return $this->db->update('bid_schedule', $data);
    }
    
    //get all the open schedules the user with userID equal to $user_id
    //belongs to.
    public function get_all_open_schedules_from_user($user_id){
        $OPEN_STATE_NAME = "open";
        
        $this->db->select('bid_schedule.*');
        $this->db->from('subcategory');
        $this->db->join('subcategory_user', 'subcategory.subCategoryID = subcategory_user.subCategoryID');
        $this->db->join('bid_schedule', 'subcategory.bidScheduleID = bid_schedule.bidScheduleID');
        $this->db->join('bid_schedule_state', 'bid_schedule.bidScheduleStateID = bid_schedule_state.bidScheduleStateID');
        $this->db->where('userID', $user_id);
        $this->db->where('bid_schedule_state.name', $OPEN_STATE_NAME);
        
        return $this->db->get()->result();
    }
    
    //get all the closed schedules the user with userID equal to $user_id
    //belongs to.
    public function get_all_closed_schedules_from_user($user_id){
        $CLOSED_STATE_NAME = "closed";
        
        $this->db->select('bid_schedule.*');
        $this->db->from('subcategory');
        $this->db->join('subcategory_user', 'subcategory.subCategoryID = subcategory_user.subCategoryID');
        $this->db->join('bid_schedule', 'subcategory.bidScheduleID = bid_schedule.bidScheduleID');
        $this->db->join('bid_schedule_state', 'bid_schedule.bidScheduleStateID = bid_schedule_state.bidScheduleStateID');
        $this->db->where('userID', $user_id);
        $this->db->where('bid_schedule_state.name', $CLOSED_STATE_NAME);
        
        return $this->db->get()->result();
    }
}
