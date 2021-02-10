<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?= site_url('assets/css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/css/fontawesome.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/css/tempusdominus-bootstrap-4.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/css/style.css') ?>">
	</head>
	<body>
		<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark mb-3">
			<a class="navbar-brand" href="<?= site_url() ?>">SFSC</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav mr-auto">
					<?php if (isset($this->session_user)): ?>
						<li class="nav-item <?= $this->router->class == 'schedule' ? 'active' : '' ?>">
							<a class="nav-link" href="<?= site_url('home') ?>"><span class="fas fa-home"></span> Home</a>
						</li>
						<?php if ($this->session_user->is_admin): ?>
							<li class="nav-item <?= $this->router->class == 'admin' ? 'active' : '' ?>">
								<a class="nav-link" href="<?= site_url('admin/main_page') ?>"><span class="fas fa-unlock-alt"></span> Admin</a>
							</li>
						<?php endif; ?>
						<li class="nav-item <?= $this->router->class == 'user' && $this->router->method == 'my_schedules' ? 'active' : '' ?>">
							<a class="nav-link" href="<?= site_url('user/my_schedules') ?>"><span class="far fa-calendar-alt"></span> My Schedules</a>
						</li>
					<?php endif; ?>
				</ul>
				<ul class="navbar-nav ml-auto">
					<?php if (isset($this->session_user)): ?>
						<li class="nav-item">
							<a class="nav-link" href="<?= site_url('user/change_password') ?>"><span class="fas fa-user"></span> <?= $this->session_user->email ?></a>
						</li>
						<li class="nav-item"><a class="nav-link" href="<?= site_url('user/logout') ?>">
							<span class="fas fa-sign-out-alt"></span> Log out</a>
						</li>
					<?php else: ?>
						<li class="nav-item <?= $this->router->class == 'user' && $this->router->method == 'login' ? 'active' : '' ?>">
							<a class="nav-link" href="<?= site_url('user/login') ?>"><span class="fas fa-sign-in-alt"></span> Log in</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
		<!-- container -->
		<div class="container">
			<?php if ($this->session->flashdata('alerts')): ?>
				<?php foreach ($this->session->flashdata('alerts') as $alert): ?>
					<div class="alert alert-<?= $alert['type'] ?> alert-dismissible">
						<?= $alert['message'] ?>
						<button class="close" data-dismiss="alert"><span class="fas fa-times"></span></button>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if (validation_errors()): ?>
				<div class="alert alert-danger alert-dismissible">
					<?= validation_errors('<p class="mb-0">', '</p>') ?>
					<button class="close" data-dismiss="alert"><span class="fas fa-times"></span></button>
				</div>
			<?php endif; ?>
