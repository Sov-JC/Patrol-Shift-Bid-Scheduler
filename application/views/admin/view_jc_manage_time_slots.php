    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?>             
        
            <div class = "row">
               <div class = "col-12">
                <h1> Manage Bid Slots <a href="<?php echo site_url("/admin/schedule_add_time_slot/$bid_schedule_id"); ?>" class="btn btn-success">
                    <span class="fas fa-plus"></span></a></h1>                
                </div>
            </div>  
            
            <div name = "data">               
                <?php foreach($subcategories as $subcat): ?> 
                <h2><b><?=$subcat->title?></b></h2>                   
                <div class = "subcategory ml-2">
                    <?php foreach($shift_types as $shift_type): ?>
                    <h4>Shift: <?=$shift_type->shiftName?></h4>
                    <div class = "row ml-2 mb-3 no-gutters" name = "bid-slot">
                      
                       <?php foreach($time_slots as $time_slot): ?>
                            <?php foreach($manage_bid_slots_view as $row): ?>
                                <?php if(($row->subCategoryID == $subcat->subCategoryID) && ($row->shiftTypeID == $shift_type->shiftTypeID) && ($row->timeSlotID == $time_slot->timeSlotID)): ?>
                                    <div class = "border border-success col-4 py-1 px-2">
                                        Slot ID: #<?=$time_slot->timeSlotID?>
                                        <small><a href="" >delete</a> | <a href = "">update</a></small><br>
                                        Start Time: <?=$time_slot->startTime?><br>
                                        End Time: <?=$time_slot->endTime?><br>
                                        
                                        <!-- print the days off available for the time slot -->
                                        Days off: <br>
                                        <?php foreach($days_off as $day_off): ?>
                                            <?php if($day_off->timeSlotID == $time_slot->timeSlotID): ?>
                                                <?php foreach($days_of_week as $day_of_week): ?>
                                                    <?php if($day_of_week->dayOfWeekID == $day_off->dayOfWeekID): ?>
                                                        &nbsp
                                                        <span class = "badge badge-light">
                                                            <?= $day_of_week->dayOfWeekName ?>
                                                        </span>
                                                        <br>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>                                        
                                    </div> 
                                <?php break; ?>                                   
                                <?php endif; ?>
                            <?php endforeach; ?>
                       <?php endforeach; ?>
                        
                    </div>
                    <?php endforeach; ?>                    
                </div> <!-- /subcategory div -->
                <?php endforeach; ?>                              
            </div> <!-- /data div -->         
            
            <!--
            <h1>-- Data --</h1>
            
            <div class = "data border">
                <h1>CSI</h1>
                <div class = "subcategory border">                    
                    <h4>A-shift</h4>
                    <div class = "shift-type border">
                        
                        <div class = "row time-slot-set border no-gutters">
                            <div class = "col-4 bid-slot border">
                                <b>Bid slot #1101</b><br>
                                id: 42<br>
                                start-time: 00:00<br>
                                end-time: 00:00<br>
                                type (dayOff/workDay): workDay<br>
                                Day1:Sunday<br>
                                Day2:Monday<br>                                
                            </div>                            
                        </div>
                    </div>
                    
                    <h4>B-shift</h4>
                    <div class = "shift-type border">                        
                    </div>
                    
                    <h4>C-shift</h4>
                    <div class = "shift-type border">                        
                    </div>
                </div>  
                <h1>Patrol Officer (k-9)</h1>
                <div class = "subcategory border">                    
                    <h4>A-shift</h4>
                    <div class = "shift-type border">
                        
                    </div>
                    <h4>B-shift</h4>
                    <div class = "shift-type border">
                        
                    </div>
                    
                    <h4>C-shift</h4>
                    <div class = "shift-type border">
                        
                    </div>
                </div>                
            </div>
            -->
            
            <!--
            <div class = "row border" name = "data">
                <div class = "col-md-12 border" name = "subcategory name">
                    <h2>CSI</h2>
                </div>
                
                <div class = "col-md-12 border">
                    <div class = "row border">
                        
                    </div>
                </div>                              
            </div>
            -->
            
            <!--
            <div class = "border row">
              <h1> Hello this makes sense</h1>
            </div>
            <div class = "row border">
                <h1>Hannah Brown</h1>
            </div>
            <div class = "row border">
                <div class = "col-12"><h1>this is ok?</h1></div>
            </div>
            -->
            
            <?php /*
            <div class = "row border" name = "data">
               <h3>CSI</h3>
               <div class = "row border" style = "height:200px" name = "subcategory">                  
                   <h4>A-Shift</h4>
                   <div class = "row" name = "shift-type"> 
                       <div class = "row" name = "shift-type row">
                           <div class = "col-3" name = "shift-type col">
                               
                           </div>
                           <div class = "col-3" name = "shift-type col">
                               
                           </div>
                           <div class = "col-3" name = "shift-type col">
                               
                           </div>
                       </div>
                       
                       <div class = "row" name = "shift-type row">
                           
                       </div>
                       
                       <div class = "row" name = "shift-type row">
                           
                       </div>
                    </div> <!-- /shift-type -->     
                   
                    <h4>B-Shift</h4>                    
                   <div class = "row" name = "shift-type">
                   </div> <!-- /shift-type -->               
               </div> <!-- /subcategory -->
            </div>
            */ ?>
            
            
            
            
            
            
            
            
            
            
            
            <?php /*variables: 
                    $schedule_subcategories //subcategories that are part of the bid schedule
                    $subcategory_shifts //shifts that belong to the subcategories that are part of the bid schedules
                    $shift_timeSlots //time slots ... shifts .. subcategories ... that are part of the bid schedules
                    $timeSlot_workDayOverrides // workDayOverrides ... time slots ... shifts... subcategories ... that are part of the bid schedule
                    
                    $schedule_content = join of the following tables:
                        bid_schedule
                        subcategory
                        shift_type
                        time_slot                        
                    */ 
        
            ?>
                        
            
            <?php //foreach($bid_schedule as $key => $ value) ?>
                <?php //if($key == "data"): echo "data and breaking!"; break; ?>                
                <?php //endif; ?>
                
                
            
            <?php //endforeach; ?>
           
           
           
            <!-- content footer -->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            <!-- /content footer -->
            

</div> 
<!-- /row !-->

