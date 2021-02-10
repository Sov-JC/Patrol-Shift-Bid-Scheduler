<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            <!-- vars: subcategoryID, title -->
            
            <h1> Edit Subcategory</h1>
            
            <p> Choose a new title for the '<?php echo $title; ?>' title.</p>
            
            
            <!-- form -->
            <?php echo form_open('process_subcategory_change'); ?>
            <?php echo form_label('subCategory'); ?>
            <?php $attributes = array(
                'class' => 'form-control',
                'name' => 'subCategory',
                'placeholder' => 'Enter subcategory'
               );
            ?>
            
            <?php echo form_input($attributes); ?>  
            
            <?php echo form_submit($data, ['class' => 'btn btn-primary'
                                          ,'name' => 'submit'
                                          ,'value' => 'Change']); ?>    
                
            
            <?php echo form_close(); ?>
            <!-- /form -->
            
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->

