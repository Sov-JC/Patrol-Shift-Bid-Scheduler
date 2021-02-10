

<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            <?php $this->load->view('templates/alerts'); ?>
            
            <h1> Create Bid Schedule </h1>
            
            <!-- Vars: bidProcessStartDate, bidProcessEndDate, patrolScheduleStartDate, patrolScheduleEndDate -->
            
            
            <!-- form -->
            <form action="<?php echo base_url();?>admin/process_bid_create">
               
                <!-- Bidding schedule length -->
                <div class = "bidding-period border-top border-right">
                    <h3>Length of the bidding process</h3>
                    <small>This is how long the bidding process will last. <br>
<!--                    Click <a href="">here</a> if you'd like to get an estimate on how long <br>-->
<!--                    it should be and on what days it's recommended that you start and end it.-->
                    </small>         
                        <!-- Bid schedule name -->
                        <div class="col-sm-6"> Give it a name
                               
                            <div class="form-group">
                                 
                            <input type="text" class="form-control">
                            <small id="emailHelp" class="form-text text-muted">For example: "Fall 2020" or "Q1 2020"</small>
                                    
                            </div>
                        </div> 
                        <!-- /Bid schedule name -->           
                        
                        <!-- Bid schedule start input -->
                        <div class="col-sm-6">Start date
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name = "bidProcessStart"/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker"> 
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Bid schedule start input -->
                        
                        <!-- Bid schedule end input -->
                        <div class="col-sm-6">End Date
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" name = "bidProcessEnd"/>
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div> 
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <!-- Bid schedule end input -->
                </div>
                <!-- /Bidding schedule length -->
                
                <!-- Patrol schedule length-->
                <div class = "schedule-period border-top border-right">
                    <h3>Length of the patrolling schedule</h3>
                    <small> This is how long the patrolling schedule will last. Usually several months long.</small>
                    
                    
                    
                    <!-- Patrol schedule start input -->
                    <div class="col-sm-6">Start date and time:
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name = "patrolSchedStart"/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker"> 
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div> 
                                    </div>
                                </div>
                            </div>
                    </div>   
                    <!-- /Patrol schedule start input -->
                    
                    
                    <!-- /Patrol schedule end input -->
                    <div class="col-sm-6">End date and time:
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name = "patrolSchedEnd"/>
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker"> 
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div> 
                                    </div>
                                </div>
                            </div>
                    </div>     
                    <!-- /Patrol schedule end input -->          
                </div>
                <!-- Patrol schedule length -->

            <button type="submit" class="btn btn-success">Create</button>
            <!-- /form -->  
            
                
            <script type="text/javascript">
            $('#datetimepicker1').datetimepicker();
            $(function () { 
               $.extend($.fn.datetimepicker.Constructor.Default, {
                icons: {
                    time: "far fa-clock",
                    date: "far fa-calendar",
                    up: "fas fa-arrow-up",
                    down: "fas fa-arrow-down",
                    previous: "fas fa-chevron-left",
                    next: "fas fa-chevron-right",
                    today: "far fa-calendar-check-o",
                    clear: "far fa-trash",
                    close: "far fa-times"
                } 

                });


            });
            </script>
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            
    </div>
</div> 
<!-- container/ !-->

