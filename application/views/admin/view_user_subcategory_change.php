<!-- container -->
<div class="container">
    <div class = "row">
            
            

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>


            <h1> Modify user subcategory</h1><br>
            
            <?php 
                /*
                Variables used: 
                user_subcategory (cls obj):
                    -id
                    -first_name
                    -last_name
                    -title
                    -subCategoryID
                
                subcategories (cls obj):
                    -id
                    -title                    
                */            
            ?>
                
        
            
            <h3> Current User info </h3>
            <ul class="list-group">
              <li class="list-group-item">
              ID: 
              <?php echo $user_subcategory->id ?>
             </li>
              <li class="list-group-item">
              First:
              <?php echo $user_subcategory->first_name ?>
              
              </li>
              <li class="list-group-item">
              Last:
              <?php echo $user_subcategory->last_name ?>
              </li>
              <li class="list-group-item">
              Title:
              <?php echo $user_subcategory->title ?>
              </li>
            </ul>
    

            <h3>Change user subsection to: </h3>
            <form action=" <?php echo base_url() . "admin/user_subcategory_change_process";?>" method="POST">
              <select name = "subCategoryID">
               
               <?php foreach($subcategories as $subcategory): ?>
               <option value="<?php echo $subcategory->subCategoryID;?>">
                    <?php echo $subcategory->title; ?>
                </option>
               <?php endforeach; ?>       
                        
                </select>
                <br><br>
                <input type="hidden" name="userID" value="<?php echo $user_subcategory->id; ?>">
                <input class="btn btn-success" type="submit">
            </form>
            
            
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->
