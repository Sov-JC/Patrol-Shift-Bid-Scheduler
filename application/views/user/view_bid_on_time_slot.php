<h1>Make a bid</h1>

<?php $this->load->view('templates/alerts');?>    

<?php foreach($shift_types as $shift_type): ?>
    <div id = "shift">
       <h3>
           <span class = "badge badge-primary">
               Shift:<?= $shift_type->shiftName ?>    
           </span>
       </h3>
       
        <div class = "row no-gutters">
           <?php foreach($subcategory_time_slots as $subcat_ts): ?>
               <?php if($subcat_ts->shiftTypeID == $shift_type->shiftTypeID): ?>
                    <div id = "time_slot" class = "col-4 border px-2">
                        <p>
                            Start time: <?= $subcat_ts->startTime ?> <br>
                            End time: <?= $subcat_ts->endTime ?> <br>
                        </p>
                        <p>
                            Days off: <br>
                            <?php foreach($days_off as $day_off): ?>
                                <?php if($day_off->timeSlotID == $subcat_ts->timeSlotID): ?>
                                    &nbsp<?= $day_off->dayOfWeekName ?> <br>
                                <?php endif ?>
                            <?php endforeach ?>
                        </p>
                                                
                        <div id = "button" class = "text-center">
                            <?php if($subcat_ts->userID == NULL): ?>
                                <?php echo form_open("user/bid_on_time_slot/$bid_schedule_id"); ?>
                                    <input type = "hidden" name = "timeSlotID" value = "<?= $subcat_ts->timeSlotID ?>">         
                                    <button type = "submit" class = "btn btn-success">
                                       Choose this slot
                                    </button>
                                <?php echo form_close(); ?>
                            <?php else: ?>
                                <button class = "btn btn-danger">
                                       Slot taken
                                </button>
                            <?php endif; ?>
                        </div>                        
                    </div> <!-- /time_slot -->
               <?php endif; ?>
           <?php endforeach; ?>
       </div>
       
       
    </div><!-- /shift -->
<?php endforeach; ?>