

<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            <h1> Manage bid schedule page </h1> 
            <h3> <a href="<?php echo base_url();?>admin/shift_bid_create">Create a bidding schedule</a></h3><br>
            <h3> <a href="<?php echo base_url();?>admin/shift_bid_delete">Delete a bidding schedule</a></h3><br>
            <h3> <a href="<?php echo base_url();?>admin/shift_bid_update">Update a bidding schedule</a></h3><br>
            
            <p>
                <small>Make sure you've added users to subcategories before you create a schedule. </small><br>
                <small>Click <a href="<?php echo base_url();?>/admin/set_subcategory_order">here</a> to add users to subcategories</small>
            </p>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->

