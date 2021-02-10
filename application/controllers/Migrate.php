<?php

class Migrate extends CI_Controller {
    
	public function index() {
		$this->load->library('migration');
        
        echo '<h1>$this->migration->current() : ' . $this->migration->current() ."</h1>";

		if ($this->migration->current() == FALSE) {
			show_error($this->migration->error_string());
		}   
        
	}
    
    //populate the database with test data from database version 0.3
    public function populate_with_v_0_3_data(){
        $this->load->helper("db_dummy_data_helper");
        add_dummy_data_v_0_3();
        
        echo "done populating with v0.3 data";
    }
    
    //populate the database with test data from database version 0.4
    public function populate_with_v_0_4_data(){
        $this->load->helper("db_dummy_data_helper");
        add_dummy_data_v_0_4();        
    }
    
    //populate the database with test data from database version 0.5
    public function populate_with_v_0_5_data(){
        $this->load->helper("db_dummy_data_helper");
        add_dummy_data_v_0_5(); 
    }
    
    
    /*
    //generate test data for the subcategory table
    private function populate_subcategory_table(){
        $TABLE_NAME = "subcategory";
        
        $ATT_NAMES = array("subcategoryID","title");
        
        $rows = array(
            array('title' => "Sergeant"),
            array('title' => "CSI"),
            array('title' => "Motormen"),
            array('title' => "Patrol Officer (K-9)"),
            array('title' => "Patrol Officer")
        );
        
        
        foreach($rows as $row){
            $this->db->insert($TABLE_NAME, $row);
        }        
    }
    
    private function populate_shift_type_table(){        
        $rows = array(
            array('shiftName' => 'A shift'),
            array('shiftName' => 'B shift'),
            array('shiftName' => 'C shift')            
        );
        
        foreach($rows as $row){
            $this->db->insert('shift_type', $row);
        }
    }
    
    private function populate_privilege_table(){
        $rows = array(
            array('Name' => 'root'),
            array('Name' => 'admin'),
            array('Name' => 'supervisor'),
            array('Name' => 'user')
        );
            
        foreach($rows as $row){
            $this->db->insert('privilege', $row);
        }
    }
    
    
    
    private function populate_bid_schedule(){
        $bid_shift_summer = [
            "bidProcessStart" => "2019-02-16 00:00:00",
            "bidProcessEnd" => "2019-05-25 00:00:00",
            "scheduleStart" => "2019-06-01 00:00:00",
            "scheduleEnd" => "2019-09-22 23:59:59",
            "name" => "Summer 2019"
        ];
            
        $bid_shift_fall = [
            "bidProcessStart" => "2019-02-16 00:00:00",
            "bidProcessEnd" => "2019-05-25 00:00:00",
            "scheduleStart" => "2019-09-23 00:00:00",
            "scheduleEnd" => "2019-12-21 00:00:00",
            "name" => "Fall 2019"            
        ];
        
        $rows = [
            $bid_shift_summer,
            $bid_shift_fall
        ];
            
        foreach($rows as $row)
            $this->db->insert('bid_schedule', $row);
    }
    
    private function populate_user_table(){
        $user_jose = [
            "email" => "jose@gmail.com",
            "privilegeID" => 4, //user
            "password" => password_hash("jose", PASSWORD_DEFAULT),
            "subCategoryID" => 4, //k-9
            "first_name" => "Jose",
            "last_name" => "Mallone",
            "dateHired" => "2001-05-11" 
        ];
            
        $user_carl = [
            "email" => "carl@gmail.com",
            "privilegeID" => 4, //user
            "password" => password_hash("carl", PASSWORD_DEFAULT),
            "subCategoryID" => 1, //Seargent
            "first_name" => "Carl",
            "last_name" => "David",
            "dateHired" => "2008-06-08" 
        ];
        
        $rows = [
            $user_carl,
            $user_jose
        ];
            
        foreach($rows as $row)
            $this->db->insert('users', $row);            
    }
    */
    
}
