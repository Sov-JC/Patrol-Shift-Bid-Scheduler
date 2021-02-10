<?php

class Subcategory_bid_order_model extends CI_Model { 
    
    //Update a set of subcategory_bid_order tuples given an associative array in the
    //following format $new_data = ["subCategoryBidOrderID" => "newBidOrder", ...]
    //where the key is a subCategoryBidOrderID and newBidOrder
    //is the new bidOrder  that the row with subCategoryBidOrderID should be updated with
    //returns true if all the updates successed, false otherwise. 
    public function update_subcategory_bid_order_given_assoc_array($new_data){
        $this->db->trans_begin();
        
        foreach($new_data as $subcategory_bid_order_id => $new_bid_order){
            $data = ["bidOrder" => $new_bid_order];
            $this->db->where('subcategoryBidOrderId', $subcategory_bid_order_id);
            $this->db->update('subcategory_bid_order', $data);
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
}
