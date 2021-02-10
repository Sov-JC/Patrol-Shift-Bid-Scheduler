    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <?php /*variables: 
                    var bid_schedule_id           
                    var manage_subcategory_users_view
                        ->
                    var subcategories
                        -> * all attributes from 'subcategory' table belonging to the bid schedule
                        */ ?>
            
            <?php foreach($subcategories as $sub_cat): ?>
                <h3><?= $sub_cat->title ?></h3>
                <?php $site = "/admin/bid_schedule_add_subcategory_users/" .
                    "$bid_schedule_id/" .
                    "$sub_cat->subCategoryID";                        
                ?>
                
                Counts toward staffing: 
                <span class="badge badge-warning">                    
                    <?php
                        echo html_escape($sub_cat->countsTowardStaffing == 1 ? "Yes" : "No");
                    ?>
                </span>
                <br>                
                
                <a href="<?php echo site_url($site); ?>">add users to this subcategory</a>
                
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th><!-- row operation --></th>                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach($manage_subcategory_users_view as $row): ?>
                            <?php if($row->subCategoryID === $sub_cat->subCategoryID): ?>
                            <tr>    
                                <td><?= $row->userID ?></td>
                                <td><?= $row->first_name ?></td>
                                <td><?= $row->last_name ?></td>                                
                                <td>
                                <?php echo form_open("admin/bid_schedule_delete_subcategory_user/$bid_schedule_id"); ?>
                                    <input type = "hidden" name = "bidScheduleID"
                                    value = "<?php echo html_escape("$bid_schedule_id"); ?>">
                                    <input type = "hidden" name = "subCategoryUserID" 
                                    value = "<?php echo html_escape("$row->subCategoryUserID"); ?>">
                                    
                                    <input type = "submit" class = "btn btn-danger btn-sm" value = "remove">
                                <?php echo form_close(); ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            <?php endforeach; ?>
           
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div> 
<!-- /row !-->

