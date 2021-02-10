    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <!-- variables -->
            
            <h1 class="mb-3">Add shift
            </h1>
            
            <?php echo form_open("admin/jc_add_shift/$bid_schedule_id") ?>                
              <div class="form-group">
                <label for="addShift">Shift name: </label>
                <input type="text" name = "shift">
                <input type="submit" class = "btn btn-success" id="addShift" value = "Add"  placeholder="shift name">                    
              </div>
            <?php echo form_close() ?>
            
            
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer'); ?>
            

</div> 
<!-- /row !-->

