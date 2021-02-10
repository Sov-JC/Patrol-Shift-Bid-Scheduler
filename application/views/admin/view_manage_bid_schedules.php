    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
                                                          
            
            <h1> Manage bid schedules </h1>
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts'); ?> 
            
            
            <!-- redo -->
            <?php /*
                <div class = "form-group"> 
                    <form action= "<?php echo site_url('admin/manage_a_bid_schedule') ?>" ?>
                    <select class = "custom-select col-4" name="scheduleID">                
                    <?php foreach($bid_schedules as $b_sched): ?>                    
                        <option value = "<?= $b_sched->bidScheduleID ?>">
                        <?= $b_sched->name ?>
                        </option>          
                    <?php endforeach; ?>                
                    </select>
                    <input class = "btn btn-success ml-1 btn-sm" type="submit" value = "Submit">
                    </form>
                </div>
            */ ?>
            <!-- /redo -->
            
            <h3> 
                <a href="<?php echo base_url();?>admin/create_bid_schedule">Create a bidding schedule</a>
            </h3>
            
            <!-- recently created schedules -->
            <div>
                <h4> Recently created schedules for bidding: </h4>
                <p>
                    <?php foreach($just_created_schedules as $jcreated_sched): ?>
                    <a href = "<?= site_url("manage_a_schedule/$jcreated_sched->bidScheduleID") ?>">
                        <?= $jcreated_sched->name ?>
                    </a> 
                    <br>
                    <?php endforeach; ?>            
                </p>
            </div>
            
            <!-- open schedules -->
            <div>
                <h4> Open schedules for bidding: </h4>
                <p>
                    <?php foreach($open_schedules as $open_sched): ?>
                    <a href = "<?= site_url("manage_a_schedule/$open_sched->bidScheduleID") ?>">
                            <?= $open_sched->name ?>
                    </a> 
                    <br> 
                    <?php endforeach; ?>
                </p>
            </div>
            
            <!-- closed schedules -->
            <div>
                <h4> Closed schedules: </h4>
                <p>
                    <?php foreach($closed_schedules as $closed_sched): ?>
                    <a href = "<?= site_url("manage_a_schedule/$closed_sched->bidScheduleID") ?>">
                            <?= $closed_sched->name ?>
                    </a> 
                    <br> 
                    <?php endforeach; ?>
                </p>
            </div>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div>
<!-- /row -->
