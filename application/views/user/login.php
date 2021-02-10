<div class="row justify-content-center">
	<div class="col-4 col-md-2">
		<img src="<?= site_url('assets/images/badge.png') ?>" class="img-fluid mb-4">
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-4">
		<?= form_open() ?>
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email" autofocus>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-primary btn-block">Log in</button>
		<?= form_close() ?>
	</div>
</div>
