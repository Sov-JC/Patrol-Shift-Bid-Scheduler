<?php

class Migration_version_0_5 extends CI_Migration {
	public function up() {
		$this->load->dbforge();
        
        //DAY_OF_WEEK table
        $this->dbforge->add_field([
            'dayOfWeekID' => [
                'type' => 'INT'
            ],
            'dayOfWeekName' => [
                'type' => 'VARCHAR',
                'constraint' => '9'
            ]
        ]);
        
       
        $this->dbforge->add_key('dayOfWeekID', TRUE);
		$this->dbforge->create_table('day_of_week');
        
        //DAY_OFF table
        $this->dbforge->add_field([
            'dayOffID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'timeSlotID' => [
                'type' => 'INT',
            ],
            'dayOfWeekID' => [
                'type' => 'INT'
            ]
        ]);
        
        $this->dbforge->add_key('dayOffID', TRUE);
		$this->dbforge->create_table('day_off');
        
        //WORK_DAY_OVERRIDE table
        $fields = [
            'dayOfWeekID' => [
                'type' => 'TEXT'
                ]   
        ];
        
        $this->dbforge->add_column('work_day_override', $fields);
        
        
        $this->dbforge->drop_column('work_day_override', 'dayOfWeekStart');
        $this->dbforge->drop_column('work_day_override', 'dayOfWeekEnd');
        
        
        
        
        //TIME_SLOT table
        $this->dbforge->drop_column('time_slot', 'dayOfWeekOne');
        $this->dbforge->drop_column('time_slot', 'dayOfWeekTwo');
        $this->dbforge->drop_column('time_slot', 'isDayOffTimeSlot');
        
	$modified_atts = [
            'userID' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'startTime' => [
                'type' => 'TIME',
                'null' => TRUE
            ],
            'endTime' => [
                'type' => 'TIME',
                'null' => TRUE
            ]            
        ];
        
        $this->dbforge->modify_column('time_slot', $modified_atts);
         
        
        //VACTION_BID_REQUEST table
        $this->dbforge->drop_table('vacation_bid_request');
        
        //ACCEPTED_VACATION_BID table
        $this->dbforge->drop_table('accepted_vacation_bid');
        
        //SCHEDULE_VEHICLE table
        $this->dbforge->add_field([
            'scheduleVehicleID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'bidScheduleID' => [
                'type' => 'INT',
            ],
            'make' => [
                'type' => 'VARCHAR',
                'constraint' => '32'
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => '32'
            ],
            'year' => [
                'type' => 'INT'
            ],
            'vehicleNumber' => [
                'type' => 'INT'
            ]
        ]);
                
        $this->dbforge->add_key('scheduleVehicleID', TRUE);
		$this->dbforge->create_table('schedule_vehicle');
        
        
        
        //P_SHEET table
        $this->dbforge->add_field([
            'pSheetID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'pSheetDate' => [
                'type' => 'DATE'
            ],
            'bidScheduleID' => [
                'type' => 'INT'
            ]
        ]);
        
        $this->dbforge->add_key('pSheetID', TRUE);
		$this->dbforge->create_table('p_sheet');
        
        //PS_TIME_SLOT table
        $this->dbforge->add_field([
            'psTimeSlotID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'timeSlotID' => [
                'type' => 'INT'
            ],
            'pSheetID' => [
                'type' => 'INT'
            ],
            'scheduleVehicleID' => [
                'type' => 'INT',
                'null' => 'TRUE'
            ],
        ]);
        
        $this->dbforge->add_key('psTimeSlotID', TRUE);
		$this->dbforge->create_table('ps_time_slot');
        
        //DAY_OFF_REQUEST table
        $this->dbforge->add_field([
            'dayOffRequestID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'psTimeSlotID' => [
                'type' => 'INT'
            ],
            'reasonForRequest' => [
                'type' => ''
            ],
            'dateTimeRequested' => [
                'type' => 'DATETIME'
            ]
        ]);
        
        $this->dbforge->add_key('dayOffRequestID', TRUE);
		$this->dbforge->create_table('day_off_request');
        
        //OVERTIME_NOTICE table
        $this->dbforge->add_field([
            'overTimeNoticeID' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'dayOffRequestID' => [
                'type' => 'INT'
            ]
        ]);
        
        
        $this->dbforge->add_key('overTimeNoticeID', TRUE);
		$this->dbforge->create_table('overtime_notice');
        
        //OVERTIME_REQUEST
        $fields = [
            'overtimeNoticeID' => [
                'type' => 'INT'
            ],
            'requestAccepted' => [
                'type' => 'BOOL'
            ]   
        ];
        
        $this->dbforge->add_column('overtime_request', $fields);
        $this->dbforge->drop_column('overtime_request', 'date');
        $this->dbforge->drop_column('overtime_request', 'timeSlotID');
        
        //OVERTIME_ACCEPTED table
        $this->dbforge->drop_table('overtime_accepted');
        
        //keys and constraints
        /* foreign keys and constraints such on CASCADEs on deletes were never defined since
        they weren't necessary but they will be for this database version and future versions
        so let's define them now. Additionally, several tables require a unique constraint
        for multiple attributes at the same time (example. unique(userId, subCategoryID) for
        the subcategory_user table) that were missing in other database versions, so we will 
        do those as well.*/
        
        //default table type (MyISAM) does not support foreign keys or cascading deletes.
        //change table types to InnoDB to support foreign keys and cascading deletes.
        $this->db->query("ALTER TABLE users ENGINE = InnoDB");
        $this->db->query("ALTER TABLE bid_schedule_state ENGINE = InnoDB");
        $this->db->query("ALTER TABLE bid_schedule ENGINE = InnoDB");
        $this->db->query("ALTER TABLE day_of_week ENGINE = InnoDB");
        $this->db->query("ALTER TABLE day_off_request ENGINE = InnoDB");
        $this->db->query("ALTER TABLE day_off ENGINE = InnoDB");
        $this->db->query("ALTER TABLE overtime_notice ENGINE = InnoDB");
        $this->db->query("ALTER TABLE overtime_request ENGINE = InnoDB");
        $this->db->query("ALTER TABLE p_sheet ENGINE = InnoDB");
        $this->db->query("ALTER TABLE privilege ENGINE = InnoDB");
        $this->db->query("ALTER TABLE ps_time_slot ENGINE = InnoDB");
        $this->db->query("ALTER TABLE schedule_vehicle ENGINE = InnoDB");
        $this->db->query("ALTER TABLE shift_type ENGINE = InnoDB");
        $this->db->query("ALTER TABLE subcategory_bid_order ENGINE = InnoDB");
        $this->db->query("ALTER TABLE subcategory_user ENGINE = InnoDB");
        $this->db->query("ALTER TABLE subcategory ENGINE = InnoDB");
        $this->db->query("ALTER TABLE time_slot ENGINE = InnoDB");
        $this->db->query("ALTER TABLE user_turn_notice ENGINE = InnoDB");
        $this->db->query("ALTER TABLE work_day_override ENGINE = InnoDB");
        
        //$this->db->query("ALTER TABLE users ADD FOREIGN KEY (privilegeID) REFERENCES privilege(privilegeID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE users ADD FOREIGN KEY (privilegeID) REFERENCES privilege(privilegeID)");
        
        $this->db->query("ALTER TABLE bid_schedule ADD FOREIGN KEY (bidScheduleStateID) REFERENCES bid_schedule_state(bidScheduleStateID)");
        $this->db->query("ALTER TABLE bid_schedule ADD FOREIGN KEY (bidScheduleStateID) REFERENCES bid_schedule_state(bidScheduleStateID)");
        $this->db->query("ALTER TABLE day_off_request ADD FOREIGN KEY (psTimeSlotID) REFERENCES p_sheet(pSheetID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE day_off ADD FOREIGN KEY (timeSlotID) REFERENCES time_slot(timeSlotID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE day_off ADD FOREIGN KEY (dayOfWeekID) REFERENCES day_of_week(dayOfWeekID)");
        $this->db->query("ALTER TABLE overtime_notice ADD FOREIGN KEY (overtimeNoticeID) REFERENCES day_off_request(dayOffRequestID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE overtime_request ADD FOREIGN KEY (overtimeNoticeID) REFERENCES overtime_notice(overtimeNoticeID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE overtime_request ADD FOREIGN KEY (userID) REFERENCES users(id)");
        $this->db->query("ALTER TABLE p_sheet ADD FOREIGN KEY (bidScheduleID) REFERENCES bid_schedule(bidScheduleID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE ps_time_slot ADD FOREIGN KEY (timeSlotID) REFERENCES time_slot(timeSlotID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE ps_time_slot ADD FOREIGN KEY (pSheetID) REFERENCES p_sheet(pSheetID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE ps_time_slot ADD FOREIGN KEY (scheduleVehicleID) REFERENCES schedule_vehicle(scheduleVehicleID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE schedule_vehicle ADD FOREIGN KEY (bidScheduleID) REFERENCES bid_schedule(bidScheduleID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE shift_type ADD FOREIGN KEY (bidScheduleID) REFERENCES bid_schedule(bidScheduleID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE subcategory_bid_order ADD FOREIGN KEY (subCategoryID) REFERENCES subcategory(subCategoryID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE subcategory_user ADD FOREIGN KEY (userID) REFERENCES users(id)");
        $this->db->query("ALTER TABLE subcategory_user ADD FOREIGN KEY (subCategoryID) REFERENCES subcategory(subCategoryID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE time_slot ADD FOREIGN KEY (userID) REFERENCES users(id)");
        $this->db->query("ALTER TABLE time_slot ADD FOREIGN KEY (shiftTypeID) REFERENCES shift_type(shiftTypeID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE time_slot ADD FOREIGN KEY (subCategoryID) REFERENCES subcategory(subCategoryID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE user_turn_notice ADD FOREIGN KEY (userID) REFERENCES users(id)");
        $this->db->query("ALTER TABLE user_turn_notice ADD FOREIGN KEY (bidScheduleID) REFERENCES bid_schedule(bidScheduleID) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE work_day_override ADD FOREIGN KEY (timeSlotID) REFERENCES time_slot(timeSlotID) ON DELETE CASCADE");    

        $this->db->query("ALTER TABLE subcategory ADD CONSTRAINT uniq_1 UNIQUE (title, bidScheduleID)");
        $this->db->query("ALTER TABLE bid_schedule ADD CONSTRAINT uniq UNIQUE (name)"); 
        $this->db->query("ALTER TABLE day_off ADD CONSTRAINT uniq_1 UNIQUE (timeSlotID, dayOfWeekID)");
        $this->db->query("ALTER TABLE day_off_request ADD CONSTRAINT uniq UNIQUE (psTimeSlotID)");
        $this->db->query("ALTER TABLE overtime_notice ADD CONSTRAINT uniq UNIQUE (dayOffRequestID)");
        $this->db->query("ALTER TABLE overtime_request ADD CONSTRAINT uniq_1 UNIQUE (overtimeNoticeID, userID)");
        $this->db->query("ALTER TABLE ps_time_slot ADD CONSTRAINT uniq_1 UNIQUE (timeSlotID, pSheetID)");
        $this->db->query("ALTER TABLE p_sheet ADD CONSTRAINT uniq_1 UNIQUE (bidScheduleID, pSheetDate)");
        $this->db->query("ALTER TABLE schedule_vehicle ADD CONSTRAINT uniq_1 UNIQUE (bidScheduleID, vehicleNumber)");
        $this->db->query("ALTER TABLE shift_type ADD CONSTRAINT uniq_1 UNIQUE (shiftName, bidScheduleID)");
        $this->db->query("ALTER TABLE subcategory_user ADD CONSTRAINT uniq_1 UNIQUE (userID, subCategoryID)");
        $this->db->query("ALTER TABLE user_turn_notice ADD CONSTRAINT uniq_1 UNIQUE (userID, bidScheduleID)");
        $this->db->query("ALTER TABLE user_turn_notice ADD CONSTRAINT uniq_2 UNIQUE (bidScheduleID, turnNumber)");
        
        //Uniq L.O Shift_Type
        
        
        //SUBCATEGORY table
        //TODO: Make bidScheduleID not null
        
        //BID_SCHEDULE_STATE table
        //TODO: Make name not null
    }
    
    
	public function down() { 
        
	}
}
