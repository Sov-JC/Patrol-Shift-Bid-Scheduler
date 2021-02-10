<h1>Bid on a time slot</h1>

      <div class = "row">
       <?php foreach($time_slots_info as $info): ?>
       <div class = "col-4 border">
            Start time: <?= $info->startTime ?> <br>
            End time: <?= $info->endTime ?> <br>
            Shift: <?= $info->shiftName ?> <br>
            Days off: [<?= $info->dayOfWeekOne ?>][<?= $info->dayOfWeekTwo ?>] <br>
            <?php echo form_open("user/process_bid"); ?>
              <input type = "hidden" name = "timeSlotID" value = "<?= $info->timeSlotID ?>">
              <input type = "submit" class = "btn btn-success" value = "Bid on this slot">
           <?php echo form_close(); ?>
       </div>
       <?php endforeach; ?>
</div>
  

  
  
  <div class = "row">
   
   <!-- Expected variables: $user_subcategory, $time_slots_info  -->
   
   
   <div class = "col-4 border">
       Start time: 12:23 <br>
       End time: 15:23 <br>
       Shift: B <br>
       Days off: MoTu <br>
       
       <?php echo form_open(); ?>
          <input type = "hidden" name = "timeSlot" value = "-1">
          
          <input type = "submit" class = "btn btn-success" value = "Bid on this slot">
       <?php echo form_close(); ?>
   </div>
   
   <div class = "col-4 border">
       Start time: 02:05 <br>
       End time: 21:23 <br>
       Shift: A <br>
       Days off: MoTu <br>      
       <button class = "btn btn-success">Bid on this slot</button>
   </div>
    
</div>