    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?>    
            
            <!-- variables: $subcategories, $shift_types, $bid_schedule_id, $days_of_week -->     
        
            <div class = "row">
                <div class = "col-10">
                    <h1>Add bid slot</h1>                
                </div>
               <div class = "col-2">
                   <a href="">Go Back</a>
               </div>
            </div>  
            
            <div class = "form-group">
                <?php echo form_open("admin/schedule_add_time_slot/$bid_schedule_id"); ?>
                    <!-- start time -->
                    <label for="startTime">Start time:</label>
                    <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                    <input type="text" name="startTime" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                    </div>
                    <small class="form-text text-muted">The time the assigned user will start patrolling </small> 
                    
                    
                    <br>
                    
                    <!-- end time -->
                    <label for="endTime">End time:</label>
                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                    <input type="text" name = "endTime" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                    </div>
                    <small class="form-text text-muted">The time the assigned user will stop patrolling </small> 
                    
                    <br>
                    
                    Days off:<br>
                    <?php foreach($days_of_week as $dow): ?>
                    <input type="checkbox" name="dayOfWeekOff[]" value="<?= $dow->dayOfWeekID ?>"><?= $dow->dayOfWeekName ?><br>
                    <?php endforeach ?>
                    <br>
                    
                    Shift: <br>
                    <?php foreach($shift_types as $shift_type): ?>
                        <input type="radio" name="shiftTypeID" value="<?= $shift_type->shiftTypeID ?>">
                        <?= $shift_type->shiftName ?>
                        <br>
                    <?php endforeach; ?>
                    <br>
                    
                    Subcategory: <br>
                    <?php foreach($subcategories as $subcat): ?>
                        <input type="radio" name="subCategoryID" value="<?= $subcat->subCategoryID ?>">
                        <?= $subcat->title ?>
                        <br>
                    <?php endforeach; ?>
                    <br>
                    
                    <input class = "btn btn-success" type="submit" value="Add">
                    
                    
                <?php echo form_close(); ?>
            </div>
            
            <!-- content footer -->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            <!-- /content footer -->
            

</div> 
<!-- /row !-->

