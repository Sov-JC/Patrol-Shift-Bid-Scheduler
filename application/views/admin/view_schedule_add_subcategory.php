
<!-- row -->
<div class = "row">
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            
            
            <h1> Add subcategory</h1>
            
            <!-- Messages -->
            <?php $this->load->view('templates/alerts'); ?>
            
            <div class="form-group mt-4">
                <?php echo form_open("admin/bid_schedule_add_subcategory/$bid_schedule_id"); ?>  
                <div class="col-5">
<!--                <label class="sr-only" for="title">Insert subcategory here</label>-->
               Title: 
                <input type="text" name = "title" class="form-control" id="title" placeholder="Name"><br>
                <input class = "custom-checkbox" type="checkbox" name = "countsTowardStaffing" value="true"> 
                Counts toward staffing<br>                
                <input class = "btn btn-success my-3" type="submit" value="Add">
                </div>
                <?php echo form_close(); ?>
            </div>
            
          

            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div>
<!-- /row -->

