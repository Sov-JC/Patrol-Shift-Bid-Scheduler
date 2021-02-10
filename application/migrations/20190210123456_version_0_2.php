<?php

class Migration_version_0_2 extends CI_Migration {
	public function up() {
		$this->load->dbforge();
		$this->load->model('user_model');
        
        //PRIVILEGE table        
        $this->dbforge->add_field([
            'privilegeID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '32'
            ]
        ]);
        
        $this->dbforge->add_key('privilegeID', TRUE);
		$this->dbforge->create_table('privilege');
        
        
        //SHIFT_TYPE table
        $this->dbforge->add_field([
            'shiftTypeID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'shiftName' => [
                'type' => 'VARCHAR',
                'constraint' => '32'
            ]
        ]);
        $this->dbforge->add_key('shiftTypeID', TRUE);
		$this->dbforge->create_table('shift_type');
        
        //SUBCATEGORY table
        $this->dbforge->add_field([
            'subCategoryID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '64'
            ]
        ]);
        $this->dbforge->add_key('subCategoryID', TRUE);
		$this->dbforge->create_table('subcategory');
        
        //BID_SCHEDULE table
        $this->dbforge->add_field([
            'bidScheduleID'   => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'bidProcessStart' => [
                'type' => 'DATETIME'
            ],
            'bidProcessEnd' => [
                'type' => 'DATETIME'
            ],
            'scheduleStart' => [
                'type' => 'DATETIME'
            ],
            'scheduleEnd' => [
                'type' => 'DATETIME'
            ],            
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '64'
            ]            
        ]);
        $this->dbforge->add_key('bidScheduleID', TRUE);
		$this->dbforge->create_table('bid_schedule');
        
        //USERS table 
        // - renamed table to user
        // - 'is_admin' field removed
        // - changed constraint on first name and last name.   
        // - added three columns
        $this->dbforge->add_column('users', [
            'privilegeID' => [
                'type' => 'INT'
            ],
            'subCategoryID' => [
                'type' => 'INT'
            ],
            'dateHired' => [
                'type' => 'DATE',                
            ],
        ]); 
        
        /*
        $this->dbforge->modify_column('users', [
                'first_name' => [
                    'name' => 'firstName',
                    'type' => 'VARCHAR',
                    'constraint' => 32,                
                ],
                'last_name' => [
                    'name' => 'lastName',
                    'type' => 'VARCHAR',
                    'constraint' => 64, 
                ]
        ]);  
        $this->dbforge->drop_column('users', 'is_admin');
        $this->dbforge->rename_table('users', 'user');
        */
        
        
        
        //TIME_SLOT table
        $this->dbforge->add_field([
            'timeSlotID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'startTime' => [
                'type' => 'TIME'                
            ],
            'endTime' => [
                'type' => 'TIME'
            ],
            'userID' => [ 
                'type' => 'INT'
            ],
            'isDayOffTimeSlot' => [
                'type' => 'BOOL'
            ],            
            'shiftType' => [
                'type' => 'INT',
            ],
            'subCategoryID' => [
                'type' => 'INT'
            ],
            'dayOfWeekOne' => [ 
                'type' => 'TINYINT'
            ],
            'dayOfWeekTwo' => [
                'type' => 'TINYINT'                
            ]
        ]);
        
        $this->dbforge->add_key('timeSlotID', TRUE);
		$this->dbforge->create_table('time_slot');
        
        //WORK_DAY_OVERRIDE table
        $this->dbforge->add_field([
            'workDayOverrideID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'timeSlotID' => [
                'type' => 'INT',                
            ],
            'dayOfWeekStart' => [
                'type' => 'TINYINT'
            ],
            'dayOfWeekEnd' => [
                'type' => 'TINYINT'
            ],
            'startTime' => [
                'type' => 'TIME'
            ],
            'endTime' => [
                'type' => 'TIME'
            ]
        ]);
        
        $this->dbforge->add_key('workDayOverrideID', TRUE);
		$this->dbforge->create_table('work_day_override');
        
        //VACATION_BID_REQUEST table
        $this->dbforge->add_field([
            'vacationBidRequestID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'userID' => [
                'type' => 'INT'
            ],
            'bidScheduleID' => [
                'type' => 'INT'
            ],
            'dateTimeRequested' => [
                'type' => 'DATETIME'
            ],
            'startDate' => [
                'type' => 'DATE'
            ],
            'endDate' => [
                'type' => 'DATE'
            ]
        ]);
        
        $this->dbforge->add_key('vacationBidRequestID', TRUE);
		$this->dbforge->create_table('vacation_bid_request');
        
        //ACCEPTED_VACATION_BID table
        $this->dbforge->add_field([
            'acceptedVacationBidID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'vacationBidRequestID' => [
                'type' => 'INT',
                'dateTimeAccepted' => 'DATETIME'
            ]
        ]);
        
        $this->dbforge->add_key('acceptedVacationBidID', TRUE);
		$this->dbforge->create_table('accepted_vacation_bid');
        
        //SHIFT_BID table
        $this->dbforge->add_field([
            'shiftBidID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'userID' => [
                'type' => 'INT'
            ],
            'shiftTypeID' => [
                'type' => 'INT'
            ],
            'bidScheduleID' => [
                'type' => 'INT'
            ],
            'timeSlotID' => [
                'type' => 'INT'
            ]
        ]);
        
        $this->dbforge->add_key('shiftBidID', TRUE);
		$this->dbforge->create_table('shift_bid');
        
        //OVERTIME_REQUEST table
        $this->dbforge->add_field([
            'overtimeRequestID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'userID' => [
                'type' => 'INT'
            ],
            'shiftTypeID' => [
                'type' => 'INT'
            ],
            'date' => [
                'type' => 'DATE'
            ]
            
        ]);
        
        $this->dbforge->add_key('overtimeRequestID', TRUE);
		$this->dbforge->create_table('overtime_request');
        
        //OVERTIME_ACCEPTED table
        $this->dbforge->add_field([
            'overtimeAcceptedID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'overtimeRequestID' => [
                'type' => 'INT'
            ],
            'date' => [
                'type' => 'DATE'
            ]
            
        ]);
        
        $this->dbforge->add_key('overtimeAcceptedID', TRUE);
		$this->dbforge->create_table('overtime_accepted');        
	}

	public function down() {        
		$this->dbforge->drop_table('users', TRUE);
        $thid->dbforge->drop_table('privilege', TRUE);
        
        
        /* Drop tables in order v0.2
        overtime_accepted
        overtime_requested
        shift_bid
        accepted_vacation_bid
        vacation_bid_request
        work_day_override
        time_slot
        user
        privilege
        shift_type
        subcategory
        bid_schedule
        */
	}
}
