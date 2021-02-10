    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <!-- variables: $bid_schedule_id, $subcategory_id, $unassigned_users -->
            
            <h1> Assign user to subcategory</h1>
            
            <?php echo form_open("bid_schedule_add_subcategory_users/$bid_schedule_id/$subcategory_id"); ?>
                <select name = "users_selected[]" class="custom-select" multiple size = 16>
                    <?php foreach($unassigned_users as $user): ?>
                    <option value="<?php echo html_escape($user->id); ?>">
                        <?php echo html_escape($user->first_name) .
                            ", " .
                            html_escape($user->last_name); 
                        ?>
                    <?php endforeach; ?>
                </select>
                <p><small>Hold down the Ctrl (windows) / Command (Mac) button to select multiple users.</small></p>
                <input type="submit" class = "btn btn-success" value = "Assign user(s)">
                
                
            <?php echo form_close(); ?>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer'); ?>
            

</div> 
<!-- /row !-->

