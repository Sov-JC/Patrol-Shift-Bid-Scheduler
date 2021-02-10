    <!-- row -->
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?> 
            
            <!-- alerts -->
            <?php $this->load->view('templates/alerts');?> 
            
            <!-- variables: bid_schedule, subcategories -->
            
            <h1 class="display-4 mb-3">Subcategories 
            <a href="<?= site_url("admin/bid_schedule_add_subcategory/$bid_schedule_id"); ?>" class="btn btn-success">
                <span class="fas fa-plus"></span>
            </a>
            </h1>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Subcategory ID</th>
                        <th>Title</th>
                        <th>Counts Toward Staffing</th>                           
                        <th class="min"></th>
                    </tr>
                </thead>
                <tbody>            
                    <?php foreach ($subcategories as $subcat): ?>
                        <tr>
                            <td class = "text-center"><?= $subcat->subCategoryID ?></td>
                            <td><?= $subcat->title ?></td>
                            <td> <?php echo $subcat->countsTowardStaffing ? "Yes" : "No"; ?> <td>                               
                                <form action = "<?= site_url('admin/subcategory_edit') ?>" method = "POST">
                                    <input type = "hidden" name = "subCategoryID" value = "<?= $subcat->subCategoryID ?>">
                                    <button type="submit" class="btn btn-info">
                                    <i class="far fa-edit "></i>
                                    </button>
                                </form>
                            </td>
                            
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- content footer !-->
            <?php $this->load->view('templates/admin_page/content_footer');?>
            

</div> 
<!-- /row !-->

