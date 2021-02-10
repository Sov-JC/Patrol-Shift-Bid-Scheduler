<!-- container -->
<div class="container">
    <div class = "row">
            
            

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>


            <h1> Add Users to Subcategories</h1><br>
            <!-- Variables: $subcategories (obj), $users(obj), $subcategories_size -->
            <table class="table">
                <thead>
                    <tr>                       
                       
                        <th>User id</th>
                        <th>First Name</th>
                        <th>Last Name </th>
                            
                            <?php /*
                            <?php //foreach($subcategories as $subcategory): ?>
<!--                         <th><?php $subcategory->title ?></th>                  -->
                           <?php //endforeach; ?>-->
                           */ ?>
                           
                        <th colspan = "<?php echo $subcategory_size ?>">Subcategory</th>
                        
                        
                                                
                        <th class="min">Confirm</th>
                    </tr>
                </thead>
                <tbody>                   
                    <?php foreach ($users as $user): ?>                       
                    <tr>
                       <td>
                           <?php echo $user->id ?>
                       </td>
                       <td>
                           <?php echo $user->first_name ?>
                       </td>
                       <td>
                           <?php echo $user->last_name ?>
                       </td>

                        <form action = "#">
                           <?php foreach($subcategories as $subcategory): ?>
                                
                               <td colspan = "<?php echo $subcategory_size ?>"> 
                                   
                                    <input type = "radio" name = "userSubcatPair" value = "<?php echo $user->id . "---" . $subcategory->subCategoryID ?>"> 
                                       <?php echo $subcategory->title . "|" ?>
                                    

                               </td>
                              
                           <?php endforeach; ?>
                        <input type="submit" value = "Update User">
                        </form>

<!--                                <td><a href="<?= site_url('admin/edit_user/' . $user->id) ?>" class="btn btn-primary"><span class="fas fa-user-edit"></span></a></td>-->
                    </tr>
                        
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->
