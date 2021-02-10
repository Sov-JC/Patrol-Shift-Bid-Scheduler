<?php

class Day_Of_Week_model extends CI_Model { 
    
    public function get_days_of_the_week(){
        return $this->db->get('day_of_week')->result();
    }
    
}
