    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
                               
            
                <h1> Create a schedule for bidding </h1> 
                
                <!-- alerts -->
                <?php $this->load->view('templates/alerts');?>

                <!-- name -->
                <?php echo form_open("create_schedule"); ?>
                    <div class="form-group">
                        <label for="name">Give it a name:</label>
                        <input type="text" class="form-control" id="name" name ="name" placeholder="Name">
                        <small class="form-text text-muted">Example: Spring 2018, Q1 2019, etc.</small>
                    </div>

                    <!-- patrol schedule start -->
                    <div class="form-group">                
                        <label for="patrolScheduleStart">Start date and time:</label>
                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" 
                            data-target="#datetimepicker1" id = "patrolScheduleStart" name = "patrolScheduleStart"/>
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker"> 
                                <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>                            
                                </div> 
                            </div>
                        </div>
                        <small class="form-text text-muted">The start date and time of the patrol schedule (not the bidding process). </small>
                    </div>

                    <!-- patrol schedule end -->
                    <div class="form-group">                
                            <label for="patrolScheduleEnd">End date and time:</label>
                            <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" 
                                data-target="#datetimepicker2" id = "patrolScheduleStart" name = "patrolScheduleEnd"/>
                                <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker"> 
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>                            
                                    </div> 
                                </div>
                            </div>
                            <small class="form-text text-muted">The end date and time of the patrol schedule (not the bidding process).</small>
                    </div>

                    <input class = "btn btn-success" type = "submit" value = "Create">
                <?php echo form_close(); ?>
            
            
            <?php $this->load->view('templates/admin_page/content_footer');?>
            <!-- /content footer !-->
            

</div>
<!-- /row -->
