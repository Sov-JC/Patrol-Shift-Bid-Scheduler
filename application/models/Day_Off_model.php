<?php

class Day_Off_model extends CI_Model {  
    
    /**
    * Get the day_off rows that belong to a bid schedule
    * 
    * @param int $bid_schedule_id the bid schedule you want to get
    *                             the days off for
    * @return object[] returns the day_off rows as an array of objects
    *                 (by calling codeigniter's result() method
    *                 that belong to the bid schedule with bidScheduleID
    *                 equal to $bid_schedule_id
    */
    public function get_days_off_for_a_schedule($bid_schedule_id){
        $sql = 
        "
        SELECT 
            day_off.*
        FROM
            day_off
                NATURAL JOIN
            (time_slot AS time_slot_outer)
        WHERE
            timeSlotID IN (SELECT 
                    timeSlotID
                FROM
                    time_slot
                        NATURAL JOIN
                    shift_type
                WHERE
            bidScheduleID = " . $this->db->escape($bid_schedule_id) . ")
        ";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /**
    * Get the day_off rows that belong to a bid schedule.
    *
    * This function is just like "get_day_off_for_a_schedule"
    * except that it includes a an additional NATURAL JOIN
    * with day_of_week so access the name of the week easily.
    * @param int $bid_schedule_id the bid schedule you want to get
    *                             the days off for
    * @return object[] returns the day_off rows along with the name
    *                  of the day of the week as an array of objects
    *                  that belong to the bid schedule
    */
    public function get_days_off_for_a_schedule_with_name($bid_schedule_id){
        $sql = 
        "
        SELECT 
            day_off.*, dayOfWeekName
        FROM
            day_off
                NATURAL JOIN
            (time_slot AS time_slot_outer)
                NATURAL JOIN
            (day_of_week)
        WHERE
            timeSlotID IN (SELECT 
                    timeSlotID
                FROM
                    time_slot
                        NATURAL JOIN
                    shift_type
                WHERE
            bidScheduleID = " . $this->db->escape($bid_schedule_id) . ")
        ";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
}
