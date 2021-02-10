    <!-- row -->
    <div class = "row">
           
            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <!-- variables: $shift_types -->
            
            <h1 class="mb-3">Manage shifts
            <a href="<?= site_url("admin/jc_add_shift/$bid_schedule_id"); ?>" class="btn btn-success">
                <span class="fas fa-plus"></span>
            </a>
            </h1>
            
            <?php foreach($shifts as $shift): ?>
            Shift name: <?= $shift->shiftName ?>
            <a href="<?= site_url("admin/jc_rename_shift/$bid_schedule_id/$shift->shiftTypeID"); ?>">rename</a>|
            <a href="<?= site_url("admin/jc_delete_shift/$bid_schedule_id/$shift->shiftTypeID"); ?>">delete</a>
            <br>
            
            <?php endforeach; ?>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer'); ?>
            

</div> 
<!-- /row !-->

