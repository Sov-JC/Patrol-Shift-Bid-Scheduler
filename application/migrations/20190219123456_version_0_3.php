<?php

class Migration_version_0_3 extends CI_Migration {
	public function up() {
		$this->load->dbforge();
        
        //SUBCATEGORY table alter
        $fields = [
            'countsTowardStaffing' => ['type' => 'BOOL'],
            'bidScheduleID' => ['type' => 'INT'],
            'isDeleted' => ['type' => 'BOOL']
        ];
        $this->dbforge->add_column('subcategory', $fields);
        
        //USER table alter
        $fields = [
            'isBlocked' => ['type' => 'BOOL']
        ];
        $this->dbforge->add_column('users', $fields);
        
        $this->dbforge->drop_column('users', 'subCategoryID');
        
        
        //SUBCATEGORY_BID_ORDER table
        $this->dbforge->add_field([
            'subCategoryBidOrderID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'subCategoryID' => [
                'type' => 'INT',
            ],
            'bidOrder' => [
                'type' => 'INT'
            ]        
        ]);
        
        
        $this->dbforge->add_key('subCategoryBidOrderID', TRUE);
		$this->dbforge->create_table('subcategory_bid_order');
        
        //BID_SCHEDULE_STATE table
        $this->dbforge->add_field([
            'bidScheduleStateID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 32
            ],
            'description' => [
                'type' => 'TEXT'
            ]        
        ]);
        
        $this->dbforge->add_key('bidScheduleStateID', TRUE);
		$this->dbforge->create_table('bid_schedule_state');
        
        //SUB_CATEGORY_USER table   
        $this->dbforge->add_field([
            'subCategoryUserID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'userID' => [
                'type' => 'int'                
            ],
            'subCategoryID' => [
                'type' => 'int'
            ]        
        ]);
        
        $this->dbforge->add_key('subCategoryUserID', TRUE);
		$this->dbforge->create_table('subcategory_user');
        
        //BID_SCHEDULE table 
        $fields = [
            'dateCreated' => ['type' => 'DATETIME'],
            'bidScheduleStateID' => ['type' => 'INT'],
        ];
        
        $this->dbforge->add_column('bid_schedule', $fields);
        $this->dbforge->drop_column('bid_schedule', 'bidProcessStart');
        $this->dbforge->drop_column('bid_schedule', 'bidProcessEnd');
        
        
        
        //ACCEPTED_VACATION_BID table alter
        $fields = [
            'dateTimeAccepted' => ['type' => 'datetime']
        ];
        $this->dbforge->add_column('accepted_vacation_bid', $fields);      
        
        //TIME_SLOT table
        //modify attribute
        $fields = [
        'shiftType' => [
                'name' => 'shiftTypeID',
                'type' => 'INT',
            ]
        ];
        
        $this->dbforge->modify_column('time_slot', $fields);
    }
    
    
	public function down() {        
		$this->dbforge->drop_table('overtime_accepted', TRUE);
        $this->dbforge->drop_table('overtime_accepted', TRUE);
        $this->dbforge->drop_table('overtime_request', TRUE);
        $this->dbforge->drop_table('shift_bid', TRUE);
        $this->dbforge->drop_table('accepted_vacation_bid', TRUE);
        $this->dbforge->drop_table('vacation_bid_request', TRUE);
        $this->dbforge->drop_table('work_day_override', TRUE);
        $this->dbforge->drop_table('time_slot', TRUE);
        $this->dbforge->drop_table('subcategory_user', TRUE);
        $this->dbforge->drop_table('users', TRUE);
        $this->dbforge->drop_table('subcategory', TRUE);
        $this->dbforge->drop_table('subcategory_bid_order', TRUE);
        $this->dbforge->drop_table('bid_schedule', TRUE);
        $this->dbforge->drop_table('bid_schedule_state', TRUE);
        $this->dbforge->drop_table('privilege', TRUE);
        $this->dbforge->drop_table('shift_type', TRUE);
        
        
        /*drop tables in order v0.3
        overtime_accepted
        overtime_request
        shift_bid
        accepted_vacation_bid
        vacation_bid_request
        work_day_override
        time_slot
        subcategory_user
        users
        subcategory
        subcategory_bid_order
        bid_schedule
        bid_schedule_state
        privilege
        shift_type
        */
	}
}
