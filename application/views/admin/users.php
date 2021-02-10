<div class="container">
    <div class = "row">
		<?php $this->load->view('templates/admin_page/sidebar');?>       
		<?php $this->load->view('templates/admin_page/content_header');?>

		<h1 class="display-4 mb-3">
			Users
			<a href="<?= site_url('admin/add_user') ?>" class="btn btn-success"><span class="fas fa-user-plus"></span></a>
		</h1>
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Email</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th class="min"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?= $user->id ?></td>
						<td><?= $user->email ?></td>
						<td><?= $user->first_name ?></td>
						<td><?= $user->last_name ?></td>
						<td><a href="<?= site_url('admin/edit_user/' . $user->id) ?>" class="btn btn-primary"><span class="fas fa-user-edit"></span></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php $this->load->view('templates/admin_page/content_footer');?>
	</div>
</div>
