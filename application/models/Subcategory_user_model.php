<?php

class Subcategory_user_model extends CI_Model {
    
    public function get_subcategory_users(){
        return $this->db->get('subcategory_user')->result();
    }
   
    public function add_subcategory_user($user_id, $subcategory_id){
        $data = [
            "userID" => $user_id,
            "subCategoryID" => $subcategory_id
        ];
            
        return $this->db->insert("subcategory_user", $data);
    }
    
    //delete a subcategory_user row with subCategoryUserID 
    //equal to 'subcategory_user_id'
    public function delete_subcategory_user($subcategory_user_id){
        $row = ["subCategoryUserID" => $subcategory_user_id];
        
        return $this->db->delete('subcategory_user', $row);
    }
    
    
}
