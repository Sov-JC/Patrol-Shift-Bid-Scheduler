<div class="container">
    <div class = "row">
		<?php $this->load->view('templates/admin_page/sidebar');?>       
		<?php $this->load->view('templates/admin_page/content_header');?>
		<h1 class="display-4 mb-3 offset-md-2">Edit user <span class="h6 text-muted">ID <?= $user->id ?></span></h1>
		<?= form_open() ?>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<?php $this->load->view('templates/user_form'); ?>
					<div class="form-group float-right">
						<button type="submit" class="btn btn-primary"><span class="fas fa-user-edit"></span> Edit user</button>
						<a href="<?= site_url('admin/users') ?>" class="btn btn-danger"><span class="fas fa-ban"></span> Cancel</a>
					</div>
				</div>
			</div>
		<?= form_close() ?>
		<?php $this->load->view('templates/admin_page/content_footer');?>
	</div>
</div>
