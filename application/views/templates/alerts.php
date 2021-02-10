<?php 
    //for one msg at a time
    $succ_msg = $this->session->flashdata('succ_msg');
    $err_msg = $this->session->flashdata('err_msg');
    $misc_msg = $this->session->flashdata('misc_msg');
    
    //for multiple msgs at a time
    $succ_msgs = $this->session->flashdata('succ_msgs');
    $err_msgs = $this->session->flashdata('err_msgs');
    $misc_msgs = $this->session->flashdata('misc_msgs');
?>              
<?php if($succ_msg): ?>
   <!-- success message -->
    <div class="alert alert-success" role="alert">
        <?php echo $succ_msg; ?>             
    </div>
<?php endif; ?>   
<?php if($err_msg): ?>
    <!-- error message -->
    <div class="alert alert-danger" role="alert">
        <?php echo $err_msg; ?>             
    </div>
<?php endif; ?>
<?php if($misc_msg): ?>
    <!-- misc message -->
    <div class="alert alert-warning" role="alert">
        <?php echo $misc_msg; ?>             
    </div>
<?php endif; ?>
<?php if($succ_msgs): ?>
    <!-- success messages -->
    <?php foreach($succ_msgs as $msg): ?>
    <div class="alert alert-success" role="alert">
    <?php echo $msg; ?>
    </div>
    <?php endforeach; ?>    
<?php endif; ?>
<?php if($err_msgs): ?>
    <!-- error messages -->
    <?php foreach($err_msgs as $msg): ?>
    <div class="alert alert-danger" role="alert">
    <?php echo $msg; ?>
    </div>
    <?php endforeach; ?>    
<?php endif; ?>
<?php if($misc_msgs): ?>
    <!-- misc messages -->
    <?php foreach($misc_msgs as $msg): ?>
    <div class="alert alert-warning" role="alert">
    <?php echo $msg; ?>
    </div>
    <?php endforeach; ?>    
<?php endif; ?>


     
