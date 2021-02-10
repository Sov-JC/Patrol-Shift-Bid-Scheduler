    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <!-- Variables: $bid_schedule -->
            
            <div class = "row">
                <div class ="col-10">
                    <h1>Manage Open Schedule</h1>
                </div>
                <div class = "col-2">
                    <a href = "">Go Back</a>
                </div>                
            </div>
            
            <!-- Schedule info -->
            <div name = "bid_schedule_info" class = "row no-gutters">
               <div class = "col-5 border rounded border-primary mr-1 px-1">
                    Schedule Name: Schedule Name <br>
<!--                    Schedule Name: <?php //$bid_schedule->name ?> <br>-->
                    Status: <span class="badge badge-success">Open</span>
                </div>
                <div class = "col-5 border rounded border-primary ml-1 px-1">
                    Users bidded: 0/<?= count($users_notification_list) ?> <br>
                    Users left: <?= count($users_notification_list) ?> <br>
                    
                    <button class = "btn btn-sm btn-warning pull-right my-2">Close Bidding</button>
                </div>
            </div>
            <!-- /Schedule info -->
            
            <!-- Table div-->            
            <div name = "table" class = "row mx-1 mt-3">
                <table class="table table-sm">
                    <thead>
                    <tr>
                      <th scope="col">First</th>
                      <th scope="col">Last</th>
                      <th scope="col">Hire date</th>
                      <th scope="col">Subcat</th>
                      <th scope="col">Status</th>
                      <th scope="col">Time Slot</th>
                      <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users_notification_list as $user): ?>
                        <tr>
                            <td scope = "col"><?= $user->first_name ?></td>
                            <td scope = "col"><?= $user->last_name ?></td>
                            <td scope = "col"><?= $user->dateHired ?></td>
                            <td scope = "col">
                                <?php foreach($users_subcategory_info as $u_sub_info): ?>
                                    <?php if($user->userID == $u_sub_info->userID): ?>
                                        <?= $u_sub_info->title ?>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </td>
                            <td scope = "col"><?= $user->bidMade ? "<b class=\"text-success\">Bid Made</b>" : "In queue"?></td>
                            <td scope = "col">
                                <?php $time_slot_taken = false; ?>
                                <?php foreach($users_assigned as $user_assigned): ?>                                    
                                    <?php if($user->userID == $user_assigned->userID): ?>
                                        #<a href=""><?= $user_assigned->timeSlotID ?></a>
                                        <?php $time_slot_taken = true; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                
                                <?php if(!$time_slot_taken): ?>
                                    Unassigned
                                <?php endif; ?>
                            </td>
                            <td scope = "col">
                                <small><a href="">bid for user</a></small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /Table div-->
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div> 
<!-- /row !-->

