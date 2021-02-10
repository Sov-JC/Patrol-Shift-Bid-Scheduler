    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>  
            <!-- /side bar -->     

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
                                                          
            
            <h1> Bid Schedule Setup </h1>
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            <!-- /alerts -->
                
            <!-- schedule info -->        
            <div class = "row">
               
                <div class="col-6">
                    <ul class="list-group">
                        <li class="list-group-item">

                              <div>
                              <p>
                              <b>Schedule Info:</b><br>
                                  ID: <?= $bid_schedule->bidScheduleID ?><br>
                                  Name: <?= $bid_schedule->name ?><br>
                                  Start Date &#38; Time: <?= $bid_schedule->scheduleStart ?><br>
                                  End Date &#38; Time: <?= $bid_schedule->scheduleEnd ?><br>
                              </p>
                              </div>

                              <div class = "text-center">
                                  <a href="#" >Click here to edit this info</a>
                              </div>


                        </li>
                    </ul>
                </div>
                <!--
                
                <!-- status -->
                <div class = "col-6">
                  <ul class="list-group">
                       <li class="list-group-item">
                            <p>
                                Shift Bid Schedule Status: <span class="badge badge-warning">Just Created</span><br>
                                <small> Meaning it  has just been created and additional information 
                                is needed before users can start bidding.</small>
                            </p>

                        </li>
                    </ul>
                </div>
                <!-- /status -->
            </div>
            <!-- /schedule info -->
            
            <br>
            
            
            
            <!-- instructions -->
            <div>
                
                
                <div class="my-3 p-3 rounded box-shadow"  style="background-color:#e0ecff;">
                    <h3>Instructions</h3>
                    <p class = "pb-3 border-bottom border-gray">
                        You've successfully created a bid schedule! But we have to set up the bid schedule
                        because it can be open for bidding. Follow the steps below, click on the checkbox, and then press the button
                        to open the schedule for bidding.
                    </p>
                    <div class="media text-muted">
                      <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">Step 1</strong>
                        Create the subcategories that will be bidding. 
                        <a href="<?php echo site_url("admin/manage_schedule_subcategories/$bid_schedule->bidScheduleID"); ?>">Click here</a>
                      </p>
                    </div>
                    <div class="media text-muted pt-3">
                      <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">Step 2</strong>
                        Add users to the created subcategories from step 1. 
                        <a href="<?php echo site_url("admin/manage_subcategory_users_for_schedule/$bid_schedule->bidScheduleID"); ?>">Click here</a>
                      </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="media text-muted pt-3">
                      <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">Step 3</strong>
                        Select the bidding order between subsections. Ex Seargents first, then CSI, then regular users, etc. 
                        <a href="<?php echo site_url("admin/bid_schedule_manage_bid_order/$bid_schedule->bidScheduleID"); ?>">Click here</a>                        
                      </p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="media text-muted pt-3">
                      <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">Step 4</strong>
                        Create shifts for the schedule.
                        <a href="<?php echo site_url("admin/jc_manage_shifts/$bid_schedule->bidScheduleID"); ?>">Click here</a>                        
                      </p>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="media text-muted pt-3">
                      <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
                      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">Step 5</strong>
                        Create the subsection-restricted bid slots that users will bid on.
                        <a href="<?php echo site_url("admin/manage_bid_slots/$bid_schedule->bidScheduleID"); ?>">Click here</a>                        
                      </p>
                    </div>
                    
                    <!-- checkbox & confirm button -->
                    <div class = "row mt-3 pl-3 ">
                        <div class = "col-12 form-check">
                            <?php echo form_open("admin/open_jc_schedule_for_bidding") ?>
                                <input type = "hidden" name = "bidScheduleID" value = "<?= $bid_schedule->bidScheduleID ?>">
                                <input class = "btn btn-info" type="checkbox" name="confirmationBox" value="confirmed">
                                I've completed all the steps above
                                <input class="btn btn-info" type = "submit" value = "Open Schedule For Bidding">
                            <?php echo form_close() ?>
                        </div>
                    </div>  
                    <!-- /checkbox & confirm button -->
                               
                </div>
            </div>
            <!-- /instructions -->
            
            
            
            
            <!-- content footer -->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div>
<!-- /row -->
