<?php

class User_model extends CI_Model {
	public function login($email, $password) {
		$user = $this->db->get_where('users', ['email' => $email])->row();

		if (password_verify($password, $user->password)) {
			return $user->id;
		}

		return false;
	}

	public function get_users() {
		return $this->db->get('users')->result();
	}
    

	public function get_user($id) {
		return $this->db->get_where('users', ['id' => $id])->row();
	}

	public function edit_user($user) {
		return $this->db->replace('users', $user);
	}
    
    public function update_subCategoryID($userID, $new_subCategoryID){
        $this->db->set('subCategoryID', $new_subCategoryID);
        $this->db->where('id', $userID);
        $result = $this->db->update('users');        
        
        return $result; //return type: bool
    }
    
    //DEP
    //selects the users that are not apart of subcategory '$subcategory_id'
    public function bid_schedule_users_not_in_subcategory($subcategory_id){
        $sql = 
            "select *
            from users as u
            where u.id not in (
                select su.userID
                from subcategory_user as su
                where su.subCategoryID = ". sql_escape($subcategory_id) . 
            ")";
        
        return;
    }
    
    //DEP
    //return true if user with $user_id is part of the subcategory with $subcategory_id 
    public function user_exists_in_subcategory($user_id, $subcategory_id){
        $this->db->select("*");
        $this->db->from("user_subsection");
        $this->db->where("userID", $user_id);
        $this->db->where("subCategoryID", $subategory_ID);
        $query = $this->db->get();
                
        return count($query->result()) > 0 ? TRUE : FALSE;
    }
    
    //returns true if a user belongs to any subcategory in a particular bid schedule.
    public function user_exists_in_a_schedule_subcategory($user_id, $bid_schedule_id){
        $this->db->select("*");
        $this->db->from("subcategory_user");
        $this->db->join("bid_schedule", "subcategory_user.bidScheduleID = bid_schedule.bidScheduleID", "natural");
        $this->db->where("bidScheduleID", $bid_schedule_id);
        $this->db->where("userID", $user_id);
        $query = $this->db->get();
        
        echo "user_exist_in_a_subcategory returned: <br>";
        print_r($query->result());
        
        return count($query->result()) > 0 ? TRUE : FALSE;
        
    }
    
    //selects the users not assigned to a subcategory in bid schedule with id $bid_scheudle_id
    public function users_not_assigned_subcategory_in_bid_schedule($bid_schedule_id){        
        $sql = "
            select *
            from users
            where id not in(
            select userID
            from subcategory_user natural join
                subcategory natural join
                bid_schedule
            where bidScheduleID = " . $this->db->escape($bid_schedule_id) . "
            )";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /**
    * get the users belonging to a subcategory
    *
    * @param string $subscategory_id the subCategoryID of the subcategory
    *
    * @return array the users belonging to the subcategory
    */
    public function get_users_in_subcategory($subcategory_id){
        $this->db->select("users.*");
        $this->db->from("subcategory");
        $this->db->join("subcategory_user", "subcategory.subCategoryID = subcategory_user.subCategoryID");
        $this->db->join("users", "userID = id");
        $this->db->where("subcategory.subCategoryID", $subcategory_id);
        
        return $this->db->get()->result();
    }
    
    
}
