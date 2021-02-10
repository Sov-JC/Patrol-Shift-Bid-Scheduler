<?php

class User_Turn_Notice_model extends CI_Model {
    
    //Insert rows for each user involed in a "JustCreated" bid schedule
    //whose settings have been configued. 
    //NOTE: this method should only be used on schedules that are in the
    //"JustCreated" state. You should verify it is in this state before calling
    //the bid schedule.
	public function generate_turn_notices($bid_schedule_id) {
        $bid_schedule_id_esc = $this->db->escape($bid_schedule_id);
        
        $this->db->trans_begin();
        
        //select all the users belonging to the bid schedule,
        //ordered first by the bid order of their subsection,
        //then ordered by their date hired.    
        $sql = "
        SELECT 
            userID,
            bidOrder,
            dateHired
        FROM
            subcategory
                NATURAL JOIN
            subcategory_user
                NATURAL JOIN
            subcategory_bid_order
                JOIN
            users ON userID = id
        WHERE
            bidScheduleID = $bid_schedule_id_esc
        ORDER BY bidOrder, dateHired
        ";
        
        $turn_number = 1;
        
        $users = $this->db->query($sql)->result();
        
        //TS
        // echo "{}Method call: generate_turn_notices<br>";
        // echo "<pre><br>";
        // print_r($users);
        // echo "</pre>";
        //TE
        
        
        foreach($users as $user){
            //user turn notice data
            $utn_data = [
                "userID" => $user->userID,
                "bidMade" => FALSE,
                "bidScheduleID" => $bid_schedule_id,
                "turnNumber" => $turn_number
            ];
            
            $this->db->insert("user_turn_notice", $utn_data);
            
            $turn_number++;
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
	}
    
    /*
    //get the users that have been selected to bid on the bid schedule with
    //bidScheduleID equal to $bid_schedule_id
    public function get_user_turn_notices_given_bs_id($bid_schedule_id){
        return $this->db->get_where('user_turn_notice', ['bidScheduleID' => $bid_schedule_id]);
    }
    */
    
    //DEP
    /**
        Check if it is a users turn to bid on an open schedule
        @param int $bid_schedule_id the ID of a bid schedule that you want to check
        @param int $user_id the user's ID 
        
        @return bool returns TRUE if it is the users turn to bid. False
                     otherwise
    */
    public function user_turn_to_bid_OLD($bid_schedule_id, $user_id){
        /* the turnNumber assigned to users within a schedule is sequential. That is,
        from 1 to however many users were assigned to subcategories within the schedule.
        If we know what the turnNumber of the user of interest is (say it's N and let's say that person's
        name is also Greg) then by looking at the user within the same schedule with turnNumber equal to N-1
        (call her Sally) we can determing if Greg has made a bid.
        
        It is Greg's turn to bid if Sally has made a bid, but Greg has not. It is not Greg's turn to bid otherwise.
        With exceptions if Greg is the first person to bid (turnNumber equal to 1).
        */
        
        //get the user's turn number
        $query = $this->db->get_where('user_turn_notice', ['bidScheduleId' => $bid_schedule_id, 'userID' => $user_id]);
        $user_turn_notice = $query->row();
        
        //check if query search was empty
        if($user_turn_notice == NULL)
            return FALSE; //invalid user/bidschedule param combination.
        
        //if user has already made a bid, then clearly it is not his turn to bid
        if($user_turn_notice->bidMade == TRUE)
            return FALSE;
        
        $turnNumber = $user_turn_notice->turnNumber;
        
        //special case where user was the first person to be able to make a bid.
        if(turnNumber == 1){
            //if the user has not made a bid and is the first person to vote
            return TRUE;
        }            
        
        //from this point on, we know that the user has not made a bid. This is not enough
        //to determine if he is next in line so let's keep checking.
        
        //get the previous user in line
        $query = $this->db->get_where('user_turn_notice', 
                                      ['bidScheduleID' => $bid_schedule_id, 'turnNumber' => turnNumber-1]
                                     );
        $previous_user_turn_notice = $query->row();
        
        //since we know the user has not made a bid, if the previous person has
        //made a bid, then it is the user's turn to bid, false otherwise
        return $previous_user_turn_notice->bid_made;
    }
    
    /**
        Get the userID of the user that is next in line to bid on a time slot
        @param int $bid_schedule_id the ID of bid schedule that you want to check the list
                                    of user turn notices to see who the next person in line is
                                    
        @return int returns the ID of the user that is next in line. Returns NULL if the there were
                            no instance of user turn notices for the bid schedule, or all the users
                            for that schedule have made a bid.
    */
    public function user_next_to_bid($bid_schedule_id){
        /*
        The turnNumber assigned to users within a schedule is sequential. That is,
        from 1 to however many users were assigned to subcategories within the schedule.
        If we know what the turnNumber of the user of interest is (say it's N and let's say that person's
        name is also Greg) then by looking at the user within the same schedule with turnNumber equal to N-1
        (call her Sally) we can determing if Greg has made a bid.
        
        It is Greg's turn to bid if Sally has made a bid, but Greg has not. It is not Greg's turn to bid otherwise.
        With exceptions if Greg is the first person to bid (turnNumber equal to 1).
        */
        
        if($bid_schedule_id == NULL)
            return NULL;
        
        //select the userIDs of the user turn notices that are part of the bid
        //schedule that have not made a bid. Order the user turn notices by turn number
        $this->db->select('userID');
        $this->db->from('user_turn_notice');
        $this->db->where('bidScheduleID', $bid_schedule_id);
        $this->db->where('bidMade', FALSE);
        $this->db->order_by('turnNumber', 'ASC');        
        $query = $this->db->get();
        
        //the first user turn notice is the user who has not made a bid
        //and is next in line to bid because the first person from this query
        //is the one with the samllest turnNumber
        $user_turn_notice = $query->row();
        
        return $user_turn_notice->userID;
    }
    
    /**
        Check if it is a users turn to bid on an open schedule
        @param int $bid_schedule_id the ID of a bid schedule that you want to check
        @param int $user_id the user's ID 
        
        @return bool returns TRUE if it is the users turn to bid. FALSE
                     otherwise
    */             
    public function user_turn_to_bid($bid_schedule_id, $user_id){
        //get the userID of the next user in line
        $next_in_line = $this->user_next_to_bid($bid_schedule_id);
        
        if($next_in_line == NULL)
            return FALSE;
        
        return $next_in_line == $user_id;
    }
    
    /**
        Check if a user had made a bid on a schedule by checking the
        user turn notices
        
        @param int bid_schedule_id the schedule you want to check
        @param int user_id the userID of the user you want to determine
                           has made a bid or not.
        
        @return bool returns TRUE if the user had made a bid. False otherwise.
    */
    public function user_bid_made($bid_schedule_id, $user_id){
        $query = $this->db->get_where('user_turn_notice', 
                             ['bidScheduleID' => $bid_schedule_id, 'userID' => $user_id]
                            );
        $user_turn_notice = $query->row();
        
        if($user_turn_notice == NULL)
            return FALSE;
        
        return $user_turn_notice->bidMade;
    }
    
    /**
    * @return object the user_turn_notice row. NULL if bid schedule
    *                and user combination didn't exist.
    */
    public function get_user_turn_notice_given_bs_id_and_user_id($bid_schedule_id, $user_id){
        $this->db->select('user_turn_notice.*');
        $this->db->from('user_turn_notice');
        $this->db->join('users', 'userID = id');
        $this->db->where('bidScheduleID', $bid_schedule_id);
        $this->db->where('userID', $user_id);
        
        return $this->db->get()->row();
    }
    
    /*
    * 
    * @return bool TRUE on success, FALSE on failure
    */
    public function mark_as_bid_made($user_turn_notice_id){
        $data = ["bidMade" => TRUE];
        $this->db->where("userTurnNoticeID", $user_turn_notice_id);
        return $this->db->update("user_turn_notice", $data);
    }
    
    //TODO: Implement 
    public function subcategory_started_bidding($bid_schedule_id){
        // echo "not implemented yet"; return;
    }
    
}
