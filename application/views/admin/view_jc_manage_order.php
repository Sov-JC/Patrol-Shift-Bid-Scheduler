    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <div class = "row">
               <div class = "col-10">
                   <h1>Manage bid order between subsections</h1>                
                   <div name = "instruction" class = "border px-1">
                       <small class="">Pick the order that users will bid on based on subsection<br>
                       by assigning each section a number. Subsections with a smaller number will <br>
                       vote <b>before</b> subsections with a higher number. You can pick any number.<br>
                       &nbsp&nbsp Example: 1 for Sergeant, 2 for CSI, and 3 for Patrol Officers.<br>
                       Number assignments don't have to be increments of 1, they can by increments of <br>
                       any size. <br>
                       &nbsp&nbsp Example: 1 for Sergeant, 4 for CSI, ad 32 for Patrol Officers <br>
                       When you're done, press the "Update" button to save your changes.
                       </small>
                       
                   </div>
                   <!-- /instruction div -->
               </div>
               <div class = "col-2">
                   <a href="<?= site_url("manage_a_schedule/$bid_schedule_id") ?>">go back</a>
               </div>
            </div>
            
            <?php echo form_open("admin/bid_schedule_manage_bid_order/$bid_schedule_id"); ?>
                <?php foreach($subcategories_info as $subcat_info): ?>
                <div class = "my-2">                    
                    <input type = "text" name="SubcategoryID-<?= $subcat_info->subCategoryID ?>" value = "<?= $subcat_info->bidOrder ?>">
                    <?= $subcat_info->title ?>
                    <br>
                </div>
                <?php endforeach; ?>  
                
                <input type = "submit" class = "btn btn-info" value="Update">          
            <?php echo form_close(); ?>
            
            
            <?php 
            /*   
            <?php echo form_open("admin/bid_schedule_manage_bid_order"); ?>

                <?php foreach($subcategories_info as $subcat_info): ?>
                    <div class = "my-2">
                        <select name="<?= $subcat->title ?>" class ="">
                            
                            <?php //for each subcategory, show a range of bid order values they can input for convenience ?>
                            <?php foreach(range(1, count($subcategories)) as $order): ?>                                                            
                            <option 
                                value = "<?= $order ?>"
                                
                                <?php 
                                //make this the default selected value for the subcategory
                                //if the order matches the bid order
                                if($order == $subcat_info->bidOrder):
                                ?>
                                selected = "<?= $order ?>"                                
                                <?php endif; ?>
                            >
                                <?= $order ?>
                            </option>  
                            <?php endforeach ?> 
                        </select>
                    <?= $subcat->title ?> 
                    <br>    
                    </div>
                <?php endforeach; ?>


                <input type = "submit" class = "btn btn-info" value="Update">
            <?php echo form_close(); ?>
            */ 
            ?>
                    
             
            
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div> 
<!-- /row !-->

