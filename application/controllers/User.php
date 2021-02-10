<?php

class User extends CI_Controller {
	public function login() {
		$this->load->model('user_model');

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if (!$this->form_validation->run()) {
			$this->load->view('templates/header');
			$this->load->view('user/login');
			$this->load->view('templates/footer');
			return;
		}

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user_id = $this->user_model->login($email, $password);

		if ($user_id) {
			$this->session->set_userdata('user_id', $user_id);
			redirect('home');
		}

		alert('Incorrect email/password.', 'danger');
		redirect('user/login');
	}

	public function logout() {
		$this->session->unset_userdata('user_id');
		redirect('user/login');
	}
    
    //page where user can view information on schedules, such as the ones the user belongs to.
    //DEP
    public function manage_schedules(){
        $user_id = $this->session->userdata('user_id');
        
        $this->load->view('templates/header');
        $this->load->view('user/view_manage_schedules');
        $this->load->view('templates/footer');
    }
    
    public function make_a_bid($bid_schedule_id){
        $user_id = $this->session->userdata('user_id');
        
        #find the subcategory the user belongs to in this bid schedule
        $user_subcategory_id = NULL;
        $this->db->select('subcategory.*', FALSE);
        $this->db->from('subcategory_user');
        $this->db->join('subcategory', 'subcategory.subCategoryID=subcategory_user.subCategoryID');
        $this->db->where('userID', $user_id);
        $this->db->where('bidScheduleID', $bid_schedule_id);
        $user_subcategory_id = $this->db->get()->row()->subCategoryID;
        
        #select the time_slots in the bid schedule that belong to the 
        #subcategory the user belongs to. Also, get the shift name that
        #the time slot is for.
        #TODO: make it only select unassigned time slots
        #TODO: change after version 0.5 of DB
        
        $time_slots_info = NULL;
        $this->db->select('time_slot.*, shift_type.shiftName', FALSE);
        $this->db->from('time_slot');
        $this->db->join('shift_type', 'time_slot.shiftTypeID=shift_type.shiftTypeID');
        $this->db->where('subCategoryID', $user_subcategory_id);
        $time_slots_info = $this->db->get()->result();
        
        $data = [
            "user_subcategory_id" => $user_subcategory_id,
            "time_slots_info" => $time_slots_info
        ];
        
        $this->load->view('templates/header');
        $this->load->view('user/view_make_a_bid', $data);
        $this->load->view('templates/footer');
    }
    
    public function process_bid(){
        $user_id = $this->session->userdata('user_id');
        
        $time_slot_id = $this->input->post("timeSlotID");
        
        $update_successful = false;
        
        $update_data = [
            "userID" => $user_id
        ];
        
        $this->db->where("timeSlotID", $time_slot_id);
        $update_successful1 = $this->db->update("time_slot", $update_data);
        
        $update_data = [
            "bidMade" => TRUE
        ];
            
        $this->db->where("userID", $user_id);
        $update_successful2 = $this->db->update("user_turn_notice", $update_data);
            
        $succ_msg = "You've been assigned to this time slot";
        $err_msg = "An error occured when attempting to assign you to this slot";
        
        /*
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata("error_msg", $err_msg);            
            return FALSE;
        }else{
            $this->session->set_flashdata("succ_msg", $succ_msg);
            return TRUE;
        }*/
        $data = ["update_successful1" => $update_successful1,
                "update_successful2" => $update_successful2];
        
        $this->load->view('templates/header');
        $this->load->view('user/view_process_bid', $data);
        $this->load->view('templates/footer');
    }
    
    //Shows a list of schedules that the loged in user belongs to.
    //They can click on the schedule to view more information
    //on that schedule.
    public function my_schedules(){
        $user_id = $this->session->userdata('user_id');
        
        $this->load->model('bid_schedule_model');
        $bs_model = $this->bid_schedule_model;
        $open_schedules = $bs_model->get_all_open_schedules_from_user($user_id); 
        $closed_schedules = $bs_model->get_all_closed_schedules_from_user($user_id);
        
        $data = ['open_schedules' => $open_schedules,
                 'closed_schedules' => $closed_schedules];
        
        $this->load->view('templates/header');
        $this->load->view('user/view_my_schedules', $data);
        $this->load->view('templates/footer');
    }
    
    //View the things the logged in user can do for a closed bid schedule
    //that the user belongs to
    public function view_my_closed_schedule($bid_schedule_id){
        //TODO: check if user has access to the closed schedule
        //TODO: check if bid schedule is in the closed state
        if(!is_numeric($bid_schedule_id))
            show_404();     
        
        $this->load->model('bid_schedule_model');
        $bs_model = $this->bid_schedule_model;
        
        $todays_p_sheet = NULL;         
        $user_belongs_to_schedule;
        
        
        $data = ['bid_schedule_id' => $bid_schedule_id];
            
        $this->load->view('templates/header');
        $this->load->view('user/view_my_closed_schedule', $data);
        $this->load->view('templates/footer');
    }
    
    //View things the logged in user can do for a closed bid schedule
    //that the user belongs to
    public function view_my_open_schedule($bid_schedule_id){
        $user_id = $this->session->userdata('user_id');
        
        if(!is_numeric($bid_schedule_id))
            show_404();    
        
        //TODO: create function to check if user has access to the open schedule
        //TODO: create function to check if bid schedule is in the open state
        $user_belongs_to_schedule = TRUE;
        $schedule_is_open = TRUE;
        
        if(!$user_belongs_to_schedule || !$schedule_is_open)
            show_404();
        
        $this->load->model('bid_schedule_model');
        $this->load->model('user_turn_notice_model');
        $this->load->model("user_model");
        $this->load->model("subcategory_model");
        $bs_model = $this->bid_schedule_model;
        $utn_model = $this->user_turn_notice_model;
        $u_model = $this->user_model;
        $s_model = $this->subcategory_model;
        $bs_model = $this->bid_schedule_model;
        
        $bid_schedule = $bs_model->get_bid_schedule($bid_schedule_id);
        
        //if it is the user's turn to bid
        $turn_to_bid = $utn_model->user_turn_to_bid($bid_schedule_id, $user_id);
        
        //if the user has made a bid yet
        $bid_made = $utn_model->user_bid_made($bid_schedule_id, $user_id);
        
        //get the subcategory the user belongs to
        $user_subcategory = $s_model->get_subcategory_of_user($bid_schedule_id, $user_id);
        
        //get the users that belong to the user's subcategory
        $users_in_subcategory = $u_model->get_users_in_subcategory($user_subcategory->subCategoryID);
        
        //select all the attributes by joining user turn notice and users
        //for user_turn_notice rows belonging to this schedule
        //this table is used to get information on whether or not a user
        //has made a bid or not and to display their seniority
        $this->db->select('*');
        $this->db->from('user_turn_notice');
        $this->db->join('users', 'userID = id');
        $this->db->where('bidScheduleID', $bid_schedule_id);  
        //$this->db->order_by('dateHired', "ASC");
        //$this->db->order_by('turnNumber', "ASC");
        $utn_join_users = $this->db->get()->result();
        
        $data = ['bid_schedule' => $bid_schedule,
                'turn_to_bid' => $turn_to_bid,
                'bid_made' => $bid_made,
                'user_subcategory' => $user_subcategory,
                'users_in_subcategory' => $users_in_subcategory,
                'utn_join_users' => $utn_join_users];
                                                     
        $this->load->view('templates/header');                                                     
        $this->load->view('user/view_my_open_schedule', $data);
        $this->load->view('templates/footer');
    }
    
    /**
    *
    */
    public function bid_on_time_slot($bid_schedule_id){
        if(!is_numeric($bid_schedule_id))
            show_404();     
        
        $user_id = $this->session->userdata('user_id');
        
        //TODO: check if it is the user's turn to bid, if it's not show a 404()
        //TODO: create function to check if user has access to the open schedule
        //TODO: create function to check if bid schedule is in the open state
        $user_belongs_to_schedule = TRUE;
        $schedule_is_open = TRUE;
        
        if(!$user_belongs_to_schedule || !$schedule_is_open)
            show_404();
        
        $this->load->model("shift_type_model");
        $this->load->model("subcategory_model");
        $this->load->model("day_off_model");
        $this->load->model("user_turn_notice_model");
        $this->load->model("time_slot_model");
        $this->load->model("user_model");
        
        $shift_types = $this->shift_type_model->get_shift_types_for_a_schedule($bid_schedule_id);
        
        //the subcategory the user belongs to in this bid schedule
        $user_subcategory = $this->subcategory_model->get_subcategory_of_user($bid_schedule_id, $user_id);
        
        //get all the days off for the schedule. The name of the day off
        //is included as well.
        $days_off = $this->day_off_model->get_days_off_for_a_schedule_with_name($bid_schedule_id);
        
        //all the time slots that belong
        //to the subcategory the user belongs to
        $subcategory_time_slots;
        $this->db->select('*');
        $this->db->from('time_slot');
        $this->db->join('subcategory', 'time_slot.subCategoryID = subcategory.subCategoryID');
        $this->db->where('subcategory.subCategoryID', $user_subcategory->subCategoryID);
        $subcategory_time_slots = $this->db->get()->result();
                
        $data = ['bid_schedule_id' => $bid_schedule_id,
                 'shift_types' => $shift_types,
                 'user_subcategory' => $user_subcategory,
                 'subcategory_time_slots' => $subcategory_time_slots,
                 'days_off' => $days_off];
        
        $this->form_validation->set_rules('timeSlotID', 'Time Slot', "trim|required");
        
        if($this->form_validation->run() == FALSE){
            $this->load->view("templates/header");
            $this->load->view("user/view_bid_on_time_slot", $data);
            $this->load->view("templates/footer"); 
            return;
        }
        
        //TODO: make sure time slot picked is part of the subcategory
        
        $time_slot_id_picked = $this->input->post("timeSlotID");
        $time_slot_taken = $this->time_slot_model->is_time_slot_taken($time_slot_id_picked);
        
        //check if time slot is already taken        
        if($time_slot_taken == TRUE){
            //this should probably never happen, but just incase form tampering.
            $err_msg = "Sorry, this time slot is already taken!";
            $this->session->set_flashdata("err_msg", $err_msg);
            $this->session->set_flashdata("misc_msg", $misc_msg);
            redirect("user/bid_on_time_slot/$bid_schedule_id");
        }else if($time_slot_taken === NULL){
            //this will probably never happen, but just incase
            show_404(); //time_slot_id was invalid 
        }
        
        $this->db->trans_begin();
        
        $data = ['userID' => $user_id];
        $this->db->where('timeSlotID', $time_slot_id_picked);
        $this->db->update('time_slot', $data);
        
        //check if the insertion failed
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $err_msg = "Sorry, an error occured when assigning you the time slot! <br>Please try again.";
            $this->session->set_flashdata("err_msg", $err_msg);
            redirect("user/bid_on_time_slot/$bid_schedule_id");
        }
        
        //the user_turn_notice for this bid schedule's user
        $utn = $this->user_turn_notice_model->get_user_turn_notice_given_bs_id_and_user_id(
            $bid_schedule_id, $user_id);
        
        //update the user_turn_notice's bidMade field to reflect that the user
        //made a bid
        $bid_made_field_updated = $this->user_turn_notice_model->mark_as_bid_made($utn->userTurnNoticeID);
        
        if(!$bid_made_field_updated){
            $this->db->trans_rollback();
            $error_msg = "En error occured when recording your bid. 
                          Specifically, attempts to update our system
                          that you made a bid failed. <br>
                          Please try again.";
            $this->session->set_flashdata("err_msg", $err_msg);
            redirect("user/bid_on_time_slot/$bid_schedule_id");
        }
        
        //get the userID of the next user
        $next_user_id = $this->user_turn_notice_model->user_next_to_bid($bid_schedule_id);
        
        $next_user = $this->user_model->get_user($next_user_id);
        
        //TODO: make the recipient the email of the next person in line.
        //time_slot row and user_turn_notice's was successful, now send the email to the next user
        $this->load->library('email');
        $this->email->from('sfscbids@gmail.com', 'SFSC Bids');
        $this->email->to('jcost043@fiu.edu');
        $this->email->subject('Bid notification');
        $this->email->message("Next user to bid's email: <b>$next_user->email</b>");
        $this->email->send();
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $error_msg = "An error occured when processing your bid selection";
            $this->session->set_flashdata("err_msg", $err_msg);
            redirect("user/view_my_open_schedule/$bid_schedule_id");
        }else{
            $this->db->trans_commit();
            //$this->db->trans_rollback();//test just always to a rollback to test email
            
            $succ_msg = "Your bid was processed successfuly. Thanks for bidding.";
            $this->session->set_flashdata("succ_msg", $succ_msg);
            redirect("user/view_my_open_schedule/$bid_schedule_id");
        }
    }
    
    //template to copy and paste to save time
    private function template($a){
        echo "just a template"; return;
        
        if(!is_numeric($a))
            show_404();            
        
        $this->load->model('a_model');
        $a_model = $this->a_model;
        
        $data = ['bid_schedule_id' => $bid_schedule_id];
        
        $this->form_validation->set_rules('a', 'A', "trim|required|max_length[32]");
        
        if($this->form_validation->run() == FALSE){
            $this->load->view("templates/header");
            $this->load->view("admin/a", $data);
            $this->load->view("templates/footer"); 
            return;
        }
        
        $shift_name = $this->input->post("a");
        $succ_msg = "succ";
        $err_msg = "err";
        
        if($s_model->a($a))
            $this->session->set_flashdata("succ_msg", $succ_msg);
        else
            $this->session->set_flashdata("err_msg", $err_msg);
            
        redirect("admin/a/$bid_schedule_id");
    }

    public function change_password() {
		$this->load->model('user_model');

		$this->form_validation->set_rules('current_password', 'Current password', 'required');
		$this->form_validation->set_rules('new_password', 'New password', 'required');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new password', 'required|matches[new_password]');

		if (!$this->form_validation->run()) {
			$this->load->view('templates/header');
			$this->load->view('user/change_password');
			$this->load->view('templates/footer');
			return;
		}

		$current_password = $this->input->post('current_password');
		$new_password = $this->input->post('new_password');
		$confirm_new_password = $this->input->post('confirm_new_password');

		if (!$this->user_model->login($this->session_user->email, $current_password)) {
			alert('Incorrect current password.', 'danger');
			redirect('user/change_password');
			return;
		}

		$this->session_user->password = password_hash($new_password, PASSWORD_DEFAULT);
		$this->user_model->edit_user($this->session_user);
		alert('Password changed successfully.', 'success');
		redirect('user/change_password');
	}
}
