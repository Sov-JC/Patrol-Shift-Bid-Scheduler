<?php

class Admin extends CI_Controller {    
    
	public function users() {        
		$this->load->model('user_model');
		$this->load->view('templates/header');
	    $this->load->view('admin/users', ['users' => $this->user_model->get_users()]);
		$this->load->view('templates/footer');        
	}

	private function _user_form($view, $user = NULL) {
		$this->load->model('user_model');

		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if (!$user) $this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header');
			$this->load->view($view, ['user' => $user]);
			$this->load->view('templates/footer');
			return;
		}

		$new_user = [
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'is_admin' => $user ? $user->is_admin : FALSE
		];

		if ($user) {
			$new_user['id'] = $user->id;
			$new_user['password'] = $user->password;
		}

		if ($this->input->post('password')) {
			$new_user['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		}

		$this->user_model->edit_user($new_user);
		redirect('admin/users');
	}

	public function add_user() {
		$this->_user_form('admin/add_user', NULL);
	}

	public function edit_user($id) {
		$this->load->model('user_model');
		$this->_user_form('admin/edit_user', $this->user_model->get_user($id));
	}
    
    //main page for admin. displays all options available to the admin
    public function main_page(){
        $this->load->view('templates/header');
		$this->load->view('admin/view_main_page');
		$this->load->view('templates/footer');
    }
    
  
    //page to manage open, closed, or recently created bid schedules.
    public function manage_schedules(){
        $this->load->model("bid_schedule_model");
        $bid_schedules = $this->bid_schedule_model->get_bid_schedules();
        $open_schedules = $this->bid_schedule_model->get_open_schedules();
        $closed_schedules = $this->bid_schedule_model->get_closed_schedules();
        $just_created_schedules = $this->bid_schedule_model->get_just_created_schedules();
        
        $data = [];
        $data["bid_schedules"] = $bid_schedules;
        $data["open_schedules"] = $open_schedules;
        $data["closed_schedules"] = $closed_schedules;
        $data["just_created_schedules"] = $just_created_schedules;
        
        $this->load->view('templates/header');
		$this->load->view('admin/view_manage_bid_schedules', $data);
		$this->load->view('templates/footer');
    }
    
    public function manage_a_bid_schedule($bid_schedule_id){
        $this->load->model("bid_schedule_model"); 
        $bsm = $this->bid_schedule_model; //bid schedule model alias
        
        $bid_schedule = $bsm->get_bid_schedule($bid_schedule_id);
        
        $OPEN_STATE = "open"; //open state
        $CLOSED_STATE = "closed"; //closed state
        $JCREATED_STATE = "justCreated";//just created state
        $state_name = $bsm->get_state_name_of_bid_schedule($bid_schedule_id);
        
        $data = ["bid_schedule"=>$bid_schedule];
        
        //check the state of the bid schedule. Show 
        //a different view depending on the state.
        switch($state_name){
            case $OPEN_STATE:
                //expected 
                $this->load->model("user_turn_notice_model");
                
                //select the userID, first_name, last_name, and dateHired of users
                //on the notification list for the bid schedule
                $users_notification_list = NULL;
                $this->db->select('userID, first_name, last_name, dateHired, bidMade');
                $this->db->from('user_turn_notice');
                $this->db->join('users', 'userID = id');
                $this->db->where('bidScheduleID', $bid_schedule_id);
                $users_notification_list = $this->db->get()->result();
                
                //select the userID, subCategoryID, and title
                //of the users that have been assigned a subcategory
                //for the bid schedule
                $users_subcategory_info = NULL;
                $this->db->select('userID, subcategory.subCategoryID, title');
                $this->db->from('subcategory');
                $this->db->join('subcategory_user', 'subcategory.subCategoryID = subcategory_user.subCategoryID');
                $this->db->join('users', 'userID = id');
                $this->db->where('bidScheduleID', $bid_schedule_id);
                $users_subcategory_info = $this->db->get()->result();
                
                //select the userID and the timeSlotID 
                //of the time slots that have been assigned a user for the bid schedule
                $users_assigned = NULL;
                $this->db->select('userID, timeSlotID');
                $this->db->from('time_slot');
                $this->db->join('subcategory', 'time_slot.subCategoryID = subcategory.subCategoryID');
                $this->db->join('users', 'userID = id');
                $this->db->where('bidScheduleID', $bid_schedule_id);
                $this->db->where('userID is NOT NULL', NULL, FALSE); //produces 'where userID is NOT NULL'
                $users_assigned = $this->db->get()->result();
                
                $data = [
                    'users_notification_list' => $users_notification_list,
                    'users_subcategory_info' => $users_subcategory_info,
                    'users_assigned' => $users_assigned
                ];
                
                //TS
                /*
                $this->load->view("templates/header");
                // echo "before we display the actual view, let's print out the content of our queries<br>";
                // echo "users_notification_list: <br>";
                // echo "<pre>";
                print_r($users_notification_list);
                // echo "</pre><br>";
                // echo "users_subcategory_info: <br>";
                // echo "<pre>";
                print_r($users_subcategory_info);
                // echo "</pre><br>";
                // echo "users_assigned: <br>";
                // echo "<pre>";
                print_r($users_assigned);
                // echo "</pre><br>";
                $this->load->view("templates/footer");
                */
                //TE
                
                $this->load->view("templates/header");
                $this->load->view("admin/view_manage_open_sched", $data);
                $this->load->view("templates/footer");
                break;
            case $CLOSED_STATE:
                $this->load->view("templates/header");
                $this->load->view("admin/view_manage_just_created",$data); //for now! Change later
                $this->load->view("templates/footer"); 
                break;
            case $JCREATED_STATE:
                $this->load->view("templates/header");
                $this->load->view("admin/view_manage_just_created",$data);
                $this->load->view("templates/footer");
                break;
            default:
                break;
        }
    }
    
    //processing page to transform a bid schedule from the "justCreated" state
    //to an "open" state so users can start bidding.
    public function open_jc_schedule_for_bidding(){
        $this->load->model("bid_schedule_model");
        $this->load->model("bid_schedule_state_model");
        $this->load->model("user_turn_notice_model");
        
        //Expected form variables: bidScheduleID
        $bid_schedule_id = $this->input->post("bidScheduleID");
        
        //TODO: check if bid schedule contains:
        //subcategories
        //users assigned to subcategories
        //time slots
        //shifts
        $this->form_validation->set_rules('confirmationBox', 'Confirmation checkbox', 'required');
        $this->form_validation->set_rules('bidScheduleID', 'Hidden field: bidScheduleID', 'required|integer');
        
        if($this->form_validation->run() == FALSE){
            //TODO: Just create a page instead of displaying only the header
            //and footer for the form validation, this looks odd.
            $this->load->view("templates/header");
            $this->load->view("templates/footer");
            return;
        }
        
        // change the state to "open" and create the "user turn notices" that are
        // required to keeping track of who has and has not made a bid during
        // the bidding phase.   
        $state_change_successful = FALSE;
        $user_turn_notices_generated = FALSE;
        
        $old_state_id = $this->bid_schedule_state_model->get_just_created_state_id();
        $new_state_id = $this->bid_schedule_state_model->get_open_state_id();
        $state_change_successful = $this->bid_schedule_model->change_bid_schedule_state($bid_schedule_id, $new_state_id);                
        
        if($state_change_successful)
             $user_turn_notices_generated = $this->user_turn_notice_model->generate_turn_notices($bid_schedule_id);
          
            //@ 
        $succ_msg = "Schedule is now open for bidding!";
        $error_msg = "Schedule could not be open. <br>An error occurred when transitioning states!";
        
        if($state_change_successful && $user_turn_notices_generated){
            $this->load->model("user_turn_notice_model");
            $next_user_id = $this->user_turn_notice_model->user_next_to_bid($bid_schedule_id);
            
            $next_user = $this->user_model->get_user($next_user_id);
            $this->session->set_flashdata("succ_msg", $succ_msg);

            $this->load->library('email');
            $this->email->from('sfscbids@gmail.com', 'SFSC Bids');
            $this->email->to('jcost043@fiu.edu');
            $this->email->subject('Bid notification');
            $this->email->message("Next user to bid's email: <b>$next_user->email</b>");
            $this->email->send();
        }else{
            //revert the state of the schedule back to what it was
            $this->bid_schedule_model->change_bid_schedule_state($bid_schedule_id, $old_state_id);                
            $this->session->set_flashdata("error_msg", $error_msg);
        }
        
        redirect("admin/manage_schedules");
    }
    
    //manage the subcategories of a bid schedule    
    public function manage_schedule_subcategories($bid_schedule_id){
        $this->load->model("bid_schedule_model"); 
        $bsm = $this->bid_schedule_model; //bid schedule model alias
        
        //all the subsections that belong to the bid schedule with id 'bid_schedule_id'
        $subcategories = $bsm->get_all_subcategories($bid_schedule_id); 
        $bid_schedule = $bsm->get_bid_schedule($bid_schedule_id);
        
        $OPEN_STATE = "open"; //open state
        $CLOSED_STATE = "closed"; //closed state
        $JCREATED_STATE = "justCreated";//just created state
        $state_name = $bsm->get_state_name_of_bid_schedule($bid_schedule_id);
        
        $data = ["bid_schedule_id"=>$bid_schedule->bidScheduleID, "subcategories" => $subcategories];
        
        //check the state of the bid schedule. Show 
        //a different view depending on the state.
        switch($state_name){
            case $OPEN_STATE:
                $this->load->view("templates/header");
                // echo "open state -- not yet implemented";
                $this->load->view("templates/footer");
                break;
            case $CLOSED_STATE:
                $this->load->view("templates/header");
                // echo "closed state -- not yet implemented";
                $this->load->view("templates/footer");                
            case $JCREATED_STATE:
                $this->load->view("templates/header");
                $this->load->view("admin/view_jc_manage_subcategories",$data);
                $this->load->view("templates/footer");
                break;
            default:
                break;
        }
        
        
    }
    
    //page to create a new schedule for bidding
    public function create_bid_schedule(){  
        $this->load->model("bid_schedule_model");
        $this->load->model("bid_schedule_state_model");
        
        //form data
        $name = $this->input->post("name");
        $start = $this->input->post("patrolScheduleStart");
        $end = $this->input->post("patrolScheduleEnd");        
                
        $rules = "trim|required";
        $this->form_validation->set_rules('name', 'Name', $rules);
        $this->form_validation->set_rules('patrolScheduleStart', "Start date & time", $rules);
        $this->form_validation->set_rules('patrolScheduleEnd', "End date & time", $rules);
        
        if ($this->form_validation->run() == FALSE)
        {            
            $this->load->view('templates/header');
            $this->load->view('admin/view_create_bid_schedule');
            $this->load->view('templates/footer');
            return;
        }
        else
        {
            //TODO: Make use of the MY_date_helper function:
            //td_date_time_picker_default_to_my_sql_date_time $date_time
            
            // add EST since that time is actually interpreted by php's
            // date_create_from_format as UTC if a timezone is not specified.
            $start = $start . " EST"; //add EST
            $end = $end . " EST";
            
            $form_format = "m/d/Y h:i A T"; //based off php format documentation
            $mysql_format = "Y-m-d H:i:s"; //based off php format documentation
            
            // transform the datetime of our form into a format that mysql's datetime type
            // accepts
            $start_date_time = date_create_from_format($form_format, $start);
            $start_date_time = date_format($start_date_time, $mysql_format);
            
            $end_date_time = date_create_from_format($form_format, $end);
            $end_date_time = date_format($end_date_time, $mysql_format);
            //// echo date_format($start_date_time, "Y-m-d H:i:s");
            
            // echo "Name received is: " . $name . "<br>"; 
            
            // $ATT_NAME = "name";
            // $value = $name;
            // $name_exists = $this->bid_schedule_model->attribute_value_exists($ATT_NAME, $name);
            
            // if($name_exists){                
            //     // echo "name exists!<br>";
            //     $error_message = "A bid schedule with this name already exists. Please try again.";
            //     $this->session->set_flashdata("err_msg", $error_message);
            //     redirect('manage_schedules');
            // }
            
            
                
            $schedule_created = $this->bid_schedule_model->create_bid_schedule($name,
                                                                                $start_date_time, 
                                                                                $end_date_time);
            if($schedule_created === FALSE){
                // echo "schedule creation failed<br>";  
                $error_message = "Bid schedule could not be created, something went wrong!";
                $this->session->set_flashdata("erro_msg", $success_message);
            }else{
                // echo "Rows inserted: " . $schedule_created . "<br>";
                $success_message = "Bid schedule created successfully.";
                $this->session->set_flashdata("succ_msg", $success_message);
                redirect('manage_schedules');
            }
                
            return;
            //redirect('manage_schedules');
            /*
            $this->load->view('templates/header');
            $this->load->view('admin/view_manage_bid_schedule');
            $this->load->view('templates/footer');
            */
            
            //return;
            /*
            $success_message = "Bid schedule successfully created";
            $this->session->set_flashdata("succ_msg", $success_message);
            redirect('manage_schedules');
            */
        }
        
        //$start = $start . "EST"; //add EST
        
        // m/d/Y h:i A --- Example: 02/23/2000 08:11 PM        
        
        
        //date_create_from_format("");
        
        //$date = date_create_from_format('j-M-Y', '15-Feb-2009');
        //// echo date_format($date, 'Y-m-d');
        
        //// echo date_format($start_date_time, "Y-m-d H:i:s");
        //YYYY-MM-DD HH:MM:SS
        
        //// echo date_format($date, 'Y-m-d H:i:s');
        
        //$this->form_validation->set_rules('title', 'Title', $rules);
        /*
        $this->load->view('templates/header');
        $this->load->view('admin/view_create_bid_schedule');
        $this->load->view('templates/footer');
        */
    }
    
    //add a subcategory to a bid schedule
    public function bid_schedule_add_subcategory($bid_schedule_id){
        if(!is_numeric($bid_schedule_id))
            show_404();
        
        $title = $this->input->post("title", TRUE);
        $this->input->post("countsTowardStaffing", TRUE);
        $this->load->model("subcategory_model");
      
        //TODO: add max length requirement
        $this->form_validation->set_rules("title", "Title", "required");
        
        if($this->form_validation->run() == FALSE){
            $data = ["bid_schedule_id" => $bid_schedule_id];
            $this->load->view('templates/header');
            $this->load->view('admin/view_schedule_add_subcategory', $data);
            $this->load->view('templates/footer');
            return;
        }
        
        $countsTowardStaffing = $this->input->post("countsTowardStaffing", TRUE);
        $countsTowardStaffing = empty($countsTowardStaffing) ? FALSE : TRUE;
        
        //// echo "Counts toward staffing is: $countsTowardStaffing<br>";
        
        $db_result = $this->subcategory_model->add_subcategory($bid_schedule_id,$title,$countsTowardStaffing);
        
        if($db_result === FALSE){
            $err_msg = "DB insertion of subcategory failed!";
            $this->session->set_flashdata("err_msg", $err_msg);
        }else{
            $succ_msg = "Subcategory \"$title\" inserted successfully.";
            $this->session->set_flashdata("succ_msg", $succ_msg);
        }
        
        //TS
        //$this->load->view("templates/header");
        //// echo "[db_result:$db_result]<br>";
        //$this->load->view("templates/footer");
        //TE
        
        redirect("admin/manage_schedule_subcategories/$bid_schedule_id");        
    }

    /**
    * delete a subcategory from a bid schedule
    */
    public function bid_schedule_delete_subcategory(){
        //@
        $this->load->model('bid_schedule_model');
        $this->load->model('subcategory_model');
        $bs_model = $this->bid_schedule_model;
        
        $this->form_validation->set_rules('subCategoryID', 'Subcategory', "required|integer");
        
        if($this->form_validation->run() == FALSE)
            show_404();
        
        $bid_schedule_id = $this->input->post("bidScheduleID");
        $subcategory_id = $this->input->post("subCategoryID");
        
        //schedule open for bidding can't have their subcategories deleted
        //in this state
        if($bs_model->is_schedule_open($bid_schedule_id))
            show404();
        
        $del_response = $this->db->delete('subcategory', ['subCategoryID' => $subcategory_id]);
        
        $succ_msg = "Subcategory deleted successfully";
        $error_msg = "Failed to delete subcategory. Database delete operation failed.";
        
        if($del_response === TRUE)
            $this->session->set_flashdata("succ_msg", $succ_msg);
        else
            $this->session->set_flashdata("err_msg", $error_msg);
        
        //echo "would redirect from here"; return;
            
        redirect("admin/manage_schedule_subcategories/$bid_schedule_id");
    }
    
    //page to manage what users belong in what subcategory for a bid schedule
    //with bidScheduleID equal to $bid_schedule_id
    public function manage_subcategory_users_for_schedule($bid_schedule_id){
        if(!is_numeric($bid_schedule_id))
            show_404();
        
        $this->load->model("bid_schedule_model"); 
        $bsm = $this->bid_schedule_model; //bid schedule model alias
        
        //all the subcategories that belong to the bid schedule with id 'bid_schedule_id'
        $subcategories = $bsm->get_all_subcategories($bid_schedule_id); 

        
        //select the subCategoryUserID, userID, title, first_name, last_name, countsTowardStaffing
        //from subsection_user rows that belong to bid schedule id $bid_schedule_id        
        $sql = "
            select subCategoryUserID, userID, title, first_name, last_name, subCategoryID, countsTowardStaffing
            from (subcategory_user 	natural join subcategory)
            natural join
            bid_schedule
            join users on userID = id
            where bidScheduleID = " . $this->db->escape($bid_schedule_id);
        
        // manage_subcategory_users_view attributes:
        // subCategoryUserID
        // userID
        // title
        // first_name
        // last_name
        $manage_subcategory_users_view = $this->db->query($sql)->result();
        
        $OPEN_STATE = "open"; //open state
        $CLOSED_STATE = "closed"; //closed state
        $JCREATED_STATE = "justCreated";//just created state
        $state_name = $bsm->get_state_name_of_bid_schedule($bid_schedule_id);
        
        $data = ["bid_schedule_id"=>$bid_schedule_id, 
                 "manage_subcategory_users_view" => $manage_subcategory_users_view,
                 "subcategories" => $subcategories];
        
        // Show a different view depending on the state.
        
        switch($state_name){
            case $OPEN_STATE:
                $this->load->view("templates/header");
                // echo "<h1>Currently unsupported!</h1>";
                //The only supported states are CLOSED_STATE and JCREATED_STATE.
                //if an administrator wants to assign a user to a subsection
                //when the schedule is open for bidding, they have to wait until the
                //bidding stage is over (that is, in the CLOSED_STATE) to add users to subcategories.
                $this->load->view("templates/footer");
                break;
            case $CLOSED_STATE:
                $this->load->view("templates/header");
                // echo "closed state -- not yet implemented";
                $this->load->view("templates/footer");                
            case $JCREATED_STATE:
                $this->load->view("templates/header");
                $this->load->view("admin/view_jc_manage_subcategory_users",$data);
                $this->load->view("templates/footer");
                break;
            default:
                show_404();
                break;
        }
    }
    
    //page to assign a subcategory to a user
    public function bid_schedule_add_subcategory_users($bid_schedule_id, $subcategory_id){
        if(!is_numeric($bid_schedule_id) || !is_numeric($subcategory_id)){
            show_404();
            return;
        }
        
        $this->load->model("user_model");
        $this->load->model("subcategory_user_model");
        $u_mod = $this->user_model;
        $su_mod = $this->subcategory_user_model;
                
        $unassigned_users = $u_mod->users_not_assigned_subcategory_in_bid_schedule($bid_schedule_id);
                
                                      
        $data = ["bid_schedule_id" => $bid_schedule_id, 
              "subcategory_id" => $subcategory_id,
              "unassigned_users" => $unassigned_users
             ];
                
        $this->form_validation->set_rules('users_selected', 
                                          'Users selected: ', 
                                          'callback_users_selected_check');
                                          
        
        if($this->form_validation->run() == FALSE){
            $this->load->view("templates/header");
            $this->load->view("admin/view_jc_add_subcategory_user", $data);
            $this->load->view("templates/footer");
            return;
        }
        
        /*
        //validation to protect against tampered POST data
        foreach($this->input->post("users_selected") as $user){
            if($u_mod->user_exists_in_a_schedule_subcategory($user->id,$bid_schedule_id)){
                $error_message = "Attempted to assign a user to a subcategory when
                he/she already exists in one";
                
                $this->session->flashdata_set("err_msg"=>$error_message);
                
                redirect("admin/bid_schedule_add_subcategory_users/$bid_schedule_id/$subcategory_id");
            }               
        }
        */
        
        $users_selected = $this->input->post("users_selected", TRUE);
        
        $success_message = "Selected user(s) have been assigned to the subsection successfully";
        $this->session->set_flashdata("succ_msg", $success_message);
        
        foreach($users_selected as $user){
            $insert_ok = $su_mod->add_subcategory_user($user, $subcategory_id);
            if($insert_ok === FALSE){
                $error_message = 'Database insertion failed when assigning at least one user ' .
                'to the subsection';                    
                $this->session->unmark_flash($success_message);
                $this->session->set_flashdata("err_msg", $error_message);
                break;
            }
        }
        
        $segments = "$bid_schedule_id/$subcategory_id";
        redirect("admin/manage_subcategory_users_for_schedule/" . $segments);
    }
    
    //deletes a subcategory_user row given the subCategoryUserID and bidScheduleID from POST request
    public function bid_schedule_delete_subcategory_user(){
        $this->load->model('subcategory_user_model');
        $su_model = $this->subcategory_user_model;
        
        $bid_schedule_id = $this->input->post("bidScheduleID");
        $subcategory_user_id = $this->input->post("subCategoryUserID");
        
        
        $this->form_validation->set_rules('bidScheduleID', 'Bid schedule id', "trim|required");
        $this->form_validation->set_rules('subCategoryUserID', 'subcategory_user_id', "trim|required");
        
        if($this->form_validation->run() == FALSE){
            $this->load->view('templates/header');
            
            $this->load->view('templates/footer');
            return;
        }
        
        
        $succ_msg = "User unassigned successfully";
        $error_msg = "Attempted to remove user-subsection assignment but the database unassignment failed.";
        
        if($su_model->delete_subcategory_user($subcategory_user_id))
            $this->session->set_flashdata("succ_msg", $succ_msg);
        else
            $this->session->set_flashdata("error_msg", $error_msg);
        
        //// echo "redirect to: admin/manage_subcategory_users_for_schedule/$bid_schedule_id";
            
        redirect("admin/manage_subcategory_users_for_schedule/$bid_schedule_id");
    }
    
    //page to set up the bid order between subsections    
    public function bid_schedule_manage_bid_order($bid_schedule_id){
        if(!is_numeric($bid_schedule_id)){
            show_404();     
        }
        
        $this->load->model("bid_schedule_model");
        $this->load->model("subcategory_model");
        $this->load->model("subcategory_bid_order_model");
        $s_model = $this->subcategory_model;
        $bs_model = $this->bid_schedule_model;
        $sbo_model = $this->subcategory_bid_order_model;
        
        //get the subcategories, along with additional information from subcategory_bid_order,
        //for the subcategories belonging to the $bid_schedule_id bid schedule.
        $sql = "
        SELECT 
            *
        FROM
            subcategory
                NATURAL JOIN
            subcategory_bid_order
        WHERE
            bidScheduleID = " . $this->db->escape($bid_schedule_id);        
        
        $subcategories_info = $this->db->query($sql)->result();
        
        //get the bid orders
        //$bid_order_values = $sbo_model->get_distinguished_bid_order_given_bid_schedule_id($bid_schedule_id);
        
        //set the validation for each of the text input forms that will be generated
        //out input name will have this prefix. Example: name = "SubcategoryID-52"
        $NAME_PREFIX = "SubcategoryID-"; 
        foreach($subcategories_info as $subcategory){
            $this->form_validation->set_rules("$NAME_PREFIX" . "$subcategory->subCategoryID", "$subcategory->title", "trim|required|integer");
        }
        
        $data = ["subcategories_info" => $subcategories_info,                
                "bid_schedule_id" => $bid_schedule_id];
        
        if($this->form_validation->run() == FALSE){
            
            $OPEN_STATE = "open"; //open state
            $CLOSED_STATE = "closed"; //closed state
            $JCREATED_STATE = "justCreated";//just created state
            $state_name = $bs_model->get_state_name_of_bid_schedule($bid_schedule_id);

            //check the state of the bid schedule. Show 
            //a different view depending on the state.
            switch($state_name){                   
                case $OPEN_STATE: //TODO: Remove when bid process user story is complete. If not this page doesn't make sense for bid schedule in this state
                    $this->load->view("templates/header");
                    $this->load->view("admin/view_jc_manage_order",$data);
                    $this->load->view("templates/footer");                
                    break;
                case $CLOSED_STATE: //TODO: Remove when bid process user story is complete. If not this page doesn't make sense for bid schedule in this state
                    $this->load->view("templates/header");
                    $this->load->view("admin/view_jc_manage_order",$data);
                    $this->load->view("templates/footer");                
                    break;
                case $JCREATED_STATE:
                    $this->load->view("templates/header");
                    $this->load->view("admin/view_jc_manage_order",$data);
                    $this->load->view("templates/footer");                
                    break;
                default:
                    show_404();
                    break;
            }
            
            return;
        }
        
        // echo "form validation was success";
        
        $succ_msg = "Updated successfully";
        $error_msg = "An error occurred when updating";
        
        //get the key and value pairs from the post request of the updated bid orders
        $form_data = $this->input->post(NULL, TRUE);
        // echo "<pre>";
        // print_r($form_data);
        // echo "</pre>";
                        
        //$update_data will contain subcategory_bid_order pk's as keys, and their new
        //bid order as values for the corresponding subcategory_bid_order pk.
        $update_data = [];
        $prefix_length = strlen($NAME_PREFIX);
        
        foreach($form_data as $key => $value){ 
            //key is in the format: SubcategoryID-[number], example: SubcategoryID-52
            if(strlen($key) < $prefix_length){
                //
                // echo "detected for variable we don't care about <br>"; //TEST, REMOVE
                continue;
            }
            
            if(substr($key, 0, $prefix_length) != $NAME_PREFIX){
                // echo "detected key we don't care about because invalid prefix, it is: $key<br>"; //TEST, REMOVE
               continue;
            }
               
            $subcategory_bid_order_id = substr($key, $prefix_length, strlen($key));
            $subcategory_bid_order_new_bid_order = $value;
            
            // echo "adding [key:$subcategory_bid_order_id|value:$value]<br>";
               
            $update_data["$subcategory_bid_order_id"] = $subcategory_bid_order_new_bid_order;
        }
               
        // echo "<pre>";
        // print_r($update_data);
        // echo "</pre>";
        
        $update_response = $sbo_model->update_subcategory_bid_order_given_assoc_array($update_data);
        
        // echo "update response is: $update_response<br>";
        
        if($update_response == TRUE){
            $this->session->set_flashdata("succ_msg", $succ_msg);
        }else{
            $this->session->set_flashdata("error_msg", $error_msg);
        }
            
        redirect("bs_manage_bid_order/$bid_schedule_id");
    }
    
    //function  to manage the time slots (also called bid slots) that users will bid on
    public function manage_bid_slots($bid_schedule_id){
        $this->load->model("work_day_override_model");
        $this->load->model("subcategory_model");
        $this->load->model("bid_schedule_model");
        $this->load->model("shift_type_model");
        $this->load->model("time_slot_model");
        $this->load->model("day_off_model");
        $this->load->model("day_of_week_model");
        
        $s_model = $this->subcategory_model;
        $bs_model = $this->bid_schedule_model;
        $st_model = $this->shift_type_model;
        $ts_model = $this->time_slot_model;
        $wdo_model = $this->work_day_override_model;
        $do_model = $this->day_off_model;
        $dow_model = $this->day_of_week_model;
                
        $sql = "
            SELECT 
                *
            FROM
                bid_schedule
                    NATURAL JOIN
                subcategory
                    NATURAL JOIN
                time_slot
                    JOIN
                shift_type ON time_slot.shiftTypeID = shift_type.shiftTypeID
            WHERE
                bid_schedule.bidScheduleID = " . $this->db->escape($bid_schedule_id);
        
        $manage_bid_slots_view = $this->db->query($sql)->result();
        
        //the subcategories in the bid schedule
        $subcategories = $s_model->get_subcategories_given_bid_schedule_id($bid_schedule_id);
        
        //all the days off belonging to the bid schedule
        $days_off = $do_model->get_days_off_for_a_schedule($bid_schedule_id);
        
        $time_slots = [];  
        
        //get the days of the week
        $days_of_week = $dow_model->get_days_of_the_week();
        
        //TODO: this for loop can probably be simplified to instantiate
        //time_slots with a call to something like this:
        //$time_slots = $ts_model->get_time_slots_for_a_schedule($bid_schedule_id);
                
        foreach($subcategories as $sub_cat){
            $ts = $ts_model->get_time_slots_given_subcategory_id($sub_cat->subCategoryID);            
            foreach($ts as $time_slot)
                array_push($time_slots, $time_slot);     
        }
        
        $shift_types = $st_model->get_shift_types_for_a_schedule($bid_schedule_id); 
        
        $data = [
            "bid_schedule_id" => $bid_schedule_id,
            "manage_bid_slots_view" => $manage_bid_slots_view,
            "subcategories" => $subcategories,
            "time_slots" => $time_slots,
            "shift_types" => $shift_types,
            "days_off" => $days_off,
            "days_of_week" => $days_of_week
        ];
                
        $this->load->view("templates/header");
        $this->load->view("admin/view_jc_manage_time_slots", $data);
        $this->load->view("templates/footer");        
    }

    public function jc_manage_shifts($bid_schedule_id){
        if(!is_numeric($bid_schedule_id)){
            show_404();            
        }
        
        $this->load->model("shift_type_model");
        $s_model = $this->shift_type_model;
        
        $shifts = $s_model->get_shifts_given_bid_schedule($bid_schedule_id);
        
        $data = ['bid_schedule_id' => $bid_schedule_id,
                'shifts' => $shifts];
        
        $this->load->view("templates/header");
        $this->load->view("admin/view_jc_manage_shifts", $data);
        $this->load->view("templates/footer");   
    }
    
    public function jc_add_shift($bid_schedule_id){
        if(!is_numeric($bid_schedule_id))
            show_404();            
        
        $this->load->model('shift_type_model');
        $s_model = $this->shift_type_model;
        
        $data = ['bid_schedule_id' => $bid_schedule_id];
        
        $this->form_validation->set_rules('shift', 'Shift', "trim|required|max_length[32]");
        
        if($this->form_validation->run() == FALSE){
            $this->load->view("templates/header");
            $this->load->view("admin/view_jc_add_shift", $data);
            $this->load->view("templates/footer"); 
            return;
        }
        
        $shift_name = $this->input->post("shift");
        $succ_msg = "Shift inserted successfully.";
        $error_msg = "Failed to insert shift into the database.";
        
        if($s_model->add_shift($shift_name, $bid_schedule_id))
            $this->session->set_flashdata("succ_msg", $succ_msg);
        else
            $this->session->set_flashdata("error_msg", $error_msg);
            
        redirect("admin/jc_manage_shifts/$bid_schedule_id");
    }
    
    
    //adds a time slot to a schedule
    public function schedule_add_time_slot($bid_schedule_id){
        //@
        if(!is_numeric($bid_schedule_id))
            show_404();   
        
        //TODO: Make sure when inserting WDO, WDO days aren't picked
        //for days off.
        //Example: there should been no WDO for a Friday if Friday is chosen
        //as a day off since this doesn't make since
        
        //make use of td_time_picker_LT_to_mysql_time($date_time);
        $this->load->helper("date"); 
        
        $this->load->model('subcategory_model');
        $this->load->model('shift_type_model');
        $this->load->model('day_of_week_model');
        $st_model = $this->shift_type_model;
        $s_model = $this->subcategory_model;
        $dow_model = $this->day_of_week_model;
        
        $shift_types = $st_model->get_shifts_given_bid_schedule($bid_schedule_id);
        $subcategories = $s_model->get_subcategories_given_bid_schedule_id($bid_schedule_id);
        $days_of_week = $dow_model->get_days_of_the_week(); 
        
        $data = [
            "shift_types" => $shift_types,
            "subcategories" => $subcategories,
            "bid_schedule_id" => $bid_schedule_id,
            "days_of_week" => $days_of_week
        ];
        
        //Form variables: startTime, endTime, shiftTypeID, subCategoryID, 
        $this->form_validation->set_rules('startTime', 'Start Time', "required");
        $this->form_validation->set_rules('endTime', 'End Time', "required");
        $this->form_validation->set_rules('shiftTypeID', 'Shift', "required");
        $this->form_validation->set_rules('subCategoryID', 'Subcategory', "required");
        
        //TODO: Show view only for non-open schedules!
        if($this->form_validation->run() == FALSE){
            $this->load->view("templates/header");
            $this->load->view("admin/view_add_time_slot", $data);
            $this->load->view("templates/footer"); 
            return;
        }
        
        $start_time = $this->input->post("startTime", TRUE);
        $end_time = $this->input->post("endTime", TRUE);
        $days_off = []; //the day_of_week IDs of the days off
        
        foreach($this->input->post("dayOfWeekOff") as $dayOfWeekID){
            array_push($days_off, $dayOfWeekID);
        }
        
        // Start time and end time are given in a format that mysql will not accept.
        // Let's change the format of the start and end time form data using a helper function
        // Example of a time data from the form: 9:23 PM
        $start_time = td_time_picker_LT_to_mysql_time($start_time);
        $end_time = td_time_picker_LT_to_mysql_time($end_time);
        $shiftTypeID = $this->input->post("shiftTypeID");
        $subCategoryID = $this->input->post("subCategoryID");
        
        //at this point, we've gathered all the information we need to create a time slot
        
        //BEGIN TRANSACTION
        $this->db->trans_begin();
        
        $time_slot_data = [
            "startTime" => $start_time,
            "endTime" => $end_time,
            "shiftTypeID" => $shiftTypeID,
            "userID" => NULL, 
            "subCategoryID" => $subCategoryID,
        ];
        $time_slot = $this->db->insert('time_slot', $time_slot_data);
        $time_slot_id = $this->db->insert_id();
        
        //create several day_off rows, one for each day off, and store
        //the dayOffIDs into $day_off_ids
        $day_off_ids = [];
        foreach($days_off as $day_of_week_id){
            $day_off_data = [
                "timeSlotID" => $time_slot_id,
                "dayOfWeekID" => $day_of_week_id
            ];
                
            $this->db->insert('day_off', $day_off_data);
            $day_off_id = $this->db->insert_id();
            
            array_push($day_off_ids, $day_off_id);
        }
        
        $succ_msg = "Time slot added successfully.";
        $error_msg = "An error occurred when creating the time slot.";
        
        if($this->db->trans_status() === FALSE){
            // echo "Transaction failed! Rolling back!";     
            $this->session->set_flashdata("succ_msg", $succ_msg);
            $this->db->trans_rollback();
        }else{
            // echo "Transaction successful! Commiting.";
            $this->session->set_flashdata("error_msg", $error_msg);
            $this->db->trans_commit();
        }
        //END TRANSACTION
        
        redirect("admin/manage_bid_slots/$bid_schedule_id");
    }
    
    public function jc_shift_rename($bid_schedule_id, $shift_id){
        // echo "not implemented yet";    
    }
    
    public function jc_shift_delete($bid_schedule_id, $shift_id){
        // echo "not implemented yet";    
    }
    
    //DEP
    //function  to manage the time slots that users will bid on
    public function manage_bid_slots_OLD($bid_schedule_id){
        $this->load->model("work_day_override_model");
        $this->load->model("subcategory_model");
        $this->load->model("bid_schedule_model");
        $this->load->model("shift_type_model");
        $this->load->model("time_slot_model");
        
        //$bid_schedule = $this->bid_schedule_model->get_bid_schedule($bid_schedule_id);
        $s_model = $this->subcategory_model;
        $bs_model = $this->bid_schedule_model;
        $st_model = $this->shift_type_model;
        $ts_model = $this->time_slot_model;
        $wdo_model = $this->work_day_override_model;
        
        //this array will hold all the data we need in our template
        $bid_schedule_content = []; 
        
        //for each subcategory that $bid_schedule_id contains
        foreach($s_model->get_subcategories_given_bid_schedule_id($bid_schedule_id) as $subcategory){	
            $subcategory_id = $subcategory->subCategoryID; 
            $subcategory_content = [];            
            
            
            foreach($st_model->get_shift_types_given_subcategory_id($subCategoryID) as $shift_type){
                $shift_type_id = $shiftType->shiftTypeID;
                $shift_types_content = [];
                                    
                foreach($ts_model->get_time_slots_given_shift_type_id($shift_type_id) as $time_slot){
                    $time_slot_id = $time_slot->timeSlotID;
                    $time_slot_content = [];

                    foreach($wdo_model->get_work_day_overrides_given_time_slots($time_slot_id) as $work_day_override){
                        $work_day_override_id = $work_day_override->workDayOverrideID;
                        $time_slot_content["$work_day_override_id"] = $work_day_override;
                    }			

                    $time_slot_content["data"] = $time_slot;
                    $shift_types_content["$time_slot_id"] = $time_slot_content;
                }

                $shift_types_content["data"] = $shift_type;
                $subcategory_content["$shift_type_id"] = $shift_types_content;
            }

            $subcategory_content["data"] = $subcategory;
            $bid_schedule_content["$subcategory_id"] = $subcategory_content;
        }
        
        $bid_schedule_content["data"] = $get_bid_schedule($bid_schedule_id);
        
        $data = ["bid_schedule_content" => $bid_schedule_content];
                
        $this->load->view("templates/header");
        $this->load->view("admin/view_jc_manage_time_slots", $data);
        $this->load->view("templates/footer");        
    }
    
    public function manage_global_subcategory_users(){
        // echo "not implemented yet";
    }   
    
    public function assign_user_to_schedule_subcategory(){
        // echo "not implemented yet";
    }
    
    //add a subcategory to the subcategories in the global settings
    public function global_settings_add_subcategory(){
        // echo "not implemented yet";
    }
  
    
    //DEP
    public function subcategories_manage(){
        $this->load->view('templates/header');        
        $this->load->model('subcategory_model');
        $subcategories = $this->subcategory_model->getSubcategories();
        $this->load->view('admin/view_manage_subcategories', ['subcategories' => $subcategories]);                
        $this->load->view('templates/footer');
    }
    
    public function subcategory_edit($subCategoryID){      
        $this->load->model("subcategory_model");
        
        $subcategory = $this->subcategory_model->get_subcategory($subCategoryID);
        if(!$subcategory){
            // echo "subCategoryID does not exist";
            return;
        }
           
       
        //// echo print_r($subcategory);
        $title = $subcategory->title;
        //// echo print_r($title);
        
        
        
        $this->load->view("templates/header");
        $this->load->view("admin/view_edit_subcategory", ['title' => $title]);
        $this->load->view("templates/footer");        
        
    }
    
    //DEP
    public function process_subcategory_edit(){
        // echo "not implemented yet"; return;
        
        
        
        // if(true)
            // echo "everything went ok";
        // else
            // echo "not ok!";
    }
    
    //DEP
    //page to set what order subcategories will bid in
    public function set_subcategory_bidding_order(){
        // echo "not implemented yet";
    }
    
    //view a table of users and what subcategories they belong to
    public function user_subcategory(){                
        $this->db->select('id, first_name, last_name, title');
        $this->db->from('users');
        $this->db->join('subcategory','users.subCategoryID=subcategory.subCategoryID', 'left');//left outer join
        $query = $this->db->get();        
        $rows = $query->result();
        
        //replace null or empty string with "Not assigned yet"
        for($i=0; $i<sizeof($rows); $i++){
            $row = $rows[$i];            
            if(empty($row->title)){                
                $rows[$i]->title = "Not assigned yet";
            }
        }
        
        $this->load->view("templates/header");
        $this->load->view("admin/view_users_subcategory", ["user_subcategory"=>$rows]);
        $this->load->view("templates/footer");
        
    }
    
    //page to change the subcategory of a user
    public function user_subcategory_change($userID){
        
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('subcategory','users.subCategoryID=subcategory.subCategoryID', 'left');//left outer join
        $this->db->where("users.ID", $userID);
        
        $query = $this->db->get();
        $user_subcategory = $query->result()[0];
        
        $this->load->model("subcategory_model");
        
        $subcategories = $this->subcategory_model->getSubcategories();
   
        $data = ["user_subcategory" => $user_subcategory, "subcategories" => $subcategories];
        
        $this->load->view("templates/header");
        $this->load->view("admin/view_user_subcategory_change", $data);
        $this->load->view("templates/footer");
    }
    
    public function user_subcategory_change_process(){
        $this->load->model("user_model");
        $this->load->model("subcategory_model");
        
        $subCatID = $this->input->post('subCategoryID', true);
        $userID = $this->input->post('userID', true);
        
        if(!$subCatID || !$userID){
            show_404();
        }else{
            // echo "[subCatID:$subCatID][userID:$userID]";  //TEST          
        }
        
        if(!$this->user_model->update_subCategoryID($userID, $subCatID)){
            $err_msg = "Could not update user info. The DB update failed.";
            $this->session->set_flashdata("err_msg", $err_msg);
            redirect('user_subcategory');
        }      
        
        $success_message = "User subcategory changed successfully";
        $this->session->set_flashdata("succ_msg", $success_message);
        
        redirect('user_subcategory');
    }
    
    //DEP
    //page to add a subcategory
    public function add_subcategory($bid_schedule_id){
        
        //TODO: REDO!
        //TODO: REDO!
        //TODO: REDO!
        //TODO: REDO!
        
        /*
        $this->load->model("subcategory_model");
        
        $rules = "required";
        $rules = $rules . "|max_length[" . $this->subcategory_model->get_title_constraint() . "]";
        
        
        $this->form_validation->set_rules('title', 'Title', $rules);
        
        $title = $this->input->post('title');
        
        if($this->form_validation->run() == FALSE){              
            $this->load->view('templates/header');
			$this->load->view('admin/view_subcategory_add');
			$this->load->view('templates/footer');
            return;           
        }
        
        //form loaded with post data to be processed
        
        $succ_msg = "$title was added to the list of subcategories successfully.";
        $err_msg = "$title could not be added to list of subcategories.";        
        
        $insert_success = $this->subcategory_model->add_subcategory($title);
        if(!insert_success)            
            $this->session->set_flashdata("err_msg", $err_msg);
        else
            $this->session->set_flashdata("succ_msg", $succ_msg);
            
        
        
        redirect("add_subcategory");
        */
        // echo "[add_subcategory controller: need to redo]<br>";
    }
    
    //DEP
    //process the request to add a subcategory
    public function add_subcategory_process(){
        $title = $this->input->post("title", TRUE);

        if(!$this->subcategory_model->add_subcategory($title)){
            $err_msg = "$title could not be added to list of subcategories";
            redirect("subcategory_add_process");
        }else{}
    }
    
    //CALLBACK FUNCTIONS FOR VALIDATION
    public function users_selected_check()
	 {        
		if(empty($this->input->post("users_selected"))){
			$this->form_validation->set_message('users_selected_check', '{field} - No users selected when \'Add user\' button was clicked.');
			return false;
		}
		else
		{
			return true; 
		}
	}
    
    //DEP
    private function users_already_assigned_check(){
        //Assumes: 'User_model' model already loaded
        
        $unassigned_users = $this->input->post("users_selected");
        $bid_schedule_id = $this->input->post("bid_schedule_id");
        
        //check if a user is 
        foreach($unassigned_users as $user){
            if($user_exists_in_a_schedule_subcategory($user->id,$bid_schedule_id))
                ;//
        }
    }
    
    //template to copy and paste to save time
    public function template($a){
        // echo "just a template"; return;
        
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
        $error_msg = "err";
        
        if($s_model->a($a))
            $this->session->set_flashdata("succ_msg", $succ_msg);
        else
            $this->session->set_flashdata("error_msg", $error_msg);
            
        redirect("admin/a/$bid_schedule_id");
    }
    
    
}
