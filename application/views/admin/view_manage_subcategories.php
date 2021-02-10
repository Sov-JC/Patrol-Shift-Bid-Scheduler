<!-- container -->
<div class="container">
    <div class = "row">

            <!-- side bar -->
            <?php $this->load->view('templates/admin_page/sidebar');?>       

            <!-- content header !-->
            <?php $this->load->view('templates/admin_page/content_header');?>
            
            
            
            
            <h1 class="display-4 mb-3">Subcategories <a href="<?= site_url('admin/add_subcategory') ?>" class="btn btn-success">
            <span class="fas fa-plus"></span></a>
            </h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Subcategory ID</th>
                        <th>Title</th>                           
                        <th class="min"></th>
                    </tr>
                </thead>
                <tbody>            
                    <?php foreach ($subcategories as $subcat): ?>
                        <tr>
                            <td class = "text-center"><?= $subcat->subCategoryID ?></td>
                            <td><?= $subcat->title ?></td>
                            <td>
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
</div> 
<!-- container/ !-->

