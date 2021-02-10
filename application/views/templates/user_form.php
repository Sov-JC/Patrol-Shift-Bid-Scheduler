<div class="row">
	<div class="form-group col-md">
		<label>First name</label>
		<input type="text" name="first_name" class="form-control" placeholder="First name" value="<?php if (isset($user)) echo($user->first_name); ?>">
	</div>
	<div class="form-group col-md">
		<label>Last name</label>
		<input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?php if (isset($user)) echo($user->last_name); ?>">
	</div>
</div>
<div class="row">
	<div class="form-group col-md">
		<label>Email</label>
		<input type="email" name="email" class="form-control" placeholder="Email" value="<?php if (isset($user)) echo($user->email); ?>">
	</div>
	<div class="form-group col-md">
		<label>Password</label>
		<input type="password" name="password" class="form-control" placeholder="<?= isset($user) ? 'Keep current password' : 'Password' ?>">
	</div>
</div>
