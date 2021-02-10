<!-- container -->
<div class="container">
    <div class = "row">
            
            

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            
            
            <h1> Modify user subcategory</h1>
            
            <!-- Messages -->
            <?php $this->load->view('templates/alerts'); ?>
            
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Subcategory</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_subcategory as $user_subcat): ?>
                       <tr>
                            <td>
                                <?php echo $user_subcat->id ?>
                            </td>
                            <td>
                                <?php echo $user_subcat->first_name?>
                            </td>
                            <td>
                                <?php echo $user_subcat->last_name?>
                            </td>
                            <td>
                                <?php echo $user_subcat->title?>                            
                            </td>
                            <td>
                            <a href="<?= site_url('admin/user_subcategory_change/' . $user_subcat->id); ?>" class="btn btn-primary">
                            <span class="far fa-edit"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

    </div>
</div> 
<!-- container/ !-->
