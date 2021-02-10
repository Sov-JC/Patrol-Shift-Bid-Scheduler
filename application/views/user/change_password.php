<div class="row justify-content-center">
	<div class="col-md-4">
		<?= form_open() ?>
			<div class="form-group">
				<!-- <label>Current password</label> -->
				<input type="password" name="current_password" class="form-control" placeholder="Current password" autofocus>
			</div>
			<div class="form-group">
				<!-- <label>New password</label> -->
				<input type="password" name="new_password" class="form-control" placeholder="New password" autofocus>
			</div>
			<div class="form-group">
				<!-- <label>Confirm new password</label> -->
				<input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm new password" autofocus>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Change password</button>
		<?= form_close() ?>
	</div>
</div>
