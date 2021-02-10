<?php

class Migration_version_0_4 extends CI_Migration {
	public function up() {
		$this->load->dbforge();
        
        //USER_TURN_NOTICE table
        $this->dbforge->add_field([
           'userTurnNoticeID' => [
               'type' => 'INT',
               'auto_increment' => TRUE
           ],
            'userID' => [
                'type' => 'INT'
            ],
            'bidMade' => [
                'type' => 'BOOL'
            ],
            'bidScheduleID' =>[
                'type' => 'INT'
            ],
            'turnNumber' => [
                'type' => 'INT'
            ]
        ]);
        $this->dbforge->add_key('userTurnNoticeID', TRUE);
        $this->dbforge->create_table("user_turn_notice");
        
        //BID_SCHEDULE_STATE table
        
        //make name unique
        $fields = [
                'name' => [
                        'name' => 'name',
                        'type' => 'varchar',
                        'unique' => TRUE,
                        'constraint' => '32'
                ],
        ];
        $this->dbforge->modify_column('bid_schedule_state', $fields);
        
        //OVERTIME_REQUEST table
        
        //add new column
        $fields = [
                'timeSlotID' => [
                    'type' => 'TEXT'
                ]
        ];
                
        $this->dbforge->add_column('overtime_request', $fields);
        
        //OVERTIME_ACCEPTED table
        
        //rename attribute
        $fields = [
                'date' => [
                        'name' => 'dateAccepted',
                        'type' => 'DATE',
                ],
        ];
        $this->dbforge->modify_column('overtime_accepted', $fields);
        
        
        //SHIFT_BID table
        
        //drop the table        
        $this->dbforge->drop_table('shift_bid',TRUE);
        
        //SHIFT_TYPE table
        //add new column
        $fields = [
                'bidScheduleID' => [
                    'type' => 'INT'
                ]
        ];
                
        $this->dbforge->add_column('shift_type', $fields);
        
        
        
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
