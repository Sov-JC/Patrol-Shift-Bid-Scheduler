<?php

class Subcategory_model extends CI_Model {
    const T_NAME = "subcategory";
    
    //TODO: make all references to this method use get_subcategories() instead 
    //and then delete this method
	public function getSubcategories() {            
		return $this->db->get('subcategory')->result();
	}
    
    public function get_subcategories(){
        return $this->db->get('subcategory')->result();
    }
    
    //TODO: make all references to this method use get_subcategories_arr() instead 
    // and then delete this method
    public function getSubcategoriesArr() {
        return $this->db->get('subcategory')->result_array();
    }
    
    public function get_subcategory($subCategoryID){
        $query = $this->db->get_where('subcategory', ['subCategoryID' => $subCategoryID]);
        return $query->row(); //returns obj not assoc array
    }
    
    //Add a subcategory to the database. Also, automatically creates a subcategory_bid_order
    //tuple that references this new subcategory.
    //returns false if the 
    public function add_subcategory($bid_schedule_id, $title, $countsTowardStaffing){
        $this->db->trans_begin();
        
        $subcategory_data = ['title' => $title,
                   'bidScheduleID' => $bid_schedule_id,
                   'countsTowardStaffing' => $countsTowardStaffing];        
        $this->db->insert('subcategory', $subcategory_data);
        
        //get the last inserted id
        $subcategory_id = $this->db->insert_id(); 
        
        //also, create a subcategory_bid_order with a default bid order of 0
        $bid_order_data = ['subCategoryID' => $subcategory_id,
                          'bidOrder' => 0];
                
        $this->db->insert('subcategory_bid_order', $bid_order_data); 
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }    
    
    public function change_subcategory_title($subCategoryID, $newTitle){
        $data = array(
            'title' => $newTitle,
        );

        $this->db->where('subCategoryID', $subCategoryID);
        
        #udpate statements escape automatically
        
        return $this->db->update(T_NAME, $data);
    }
    
    public function get_subcategories_given_bid_schedule_id($bid_schedule_id){
        $query = $this->db->get_where('subcategory', ["bidScheduleID" => $bid_schedule_id]);
        return $query->result();
    }
    
    /**
    * get the subcategory that a user belongs to for a particular schedule
    * 
    * @param int $bid_schedule_id the bidScheduleID of the bid schedule 
    *                             that the user belongs to
    * @param int $user_id the userID of the user that you want to find out
    *                         what subcategory he longs to
    * @return obj the subcategory that the user belongs to. NULL if user
    *             doesn't belong to a subcategory for the bid schedule
    *             that was searched for.
    */
    public function get_subcategory_of_user($bid_schedule_id, $user_id){
        $this->db->select('subcategory.*');
        $this->db->from('subcategory_user');
        $this->db->join('subcategory', "subcategory_user.subCategoryID = 
                                        subcategory.subCategoryID");
        $this->db->join('users', 'userID = id');
        $this->db->where("bidScheduleID", $bid_schedule_id);
        $this->db->where("userID", $user_id);
        
        return $this->db->get()->row();
    }
    
    //max length of the 'title' attribute -- TEST
    public function get_title_constraint(){
        return 64;
    }
    
}
