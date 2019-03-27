<?php
/*
 * SITE-TOP.PHP : TOP HALF HTML
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?= $_PAGE['desc'] ?>">
	<meta name="robots" content="noindex">
	<title><?= $_PAGE['title'] ?></title>
	<link href="<?= URL_ROOT ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= URL_ROOT ?>public/admin/cart-boxx.css" rel="stylesheet">
	<script src="<?= URL_ROOT ?>public/jquery/jquery.min.js"></script>
	<script src="<?= URL_ROOT ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= URL_ROOT ?>public/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="<?= URL_ROOT ?>public/fontawesome/svg-with-js/js/fa-solid.min.js"></script>
	<script src="<?= URL_ROOT ?>public/fontawesome/svg-with-js/js/fontawesome.min.js"></script>
	<script src="<?= URL_ROOT ?>public/admin/cart-boxx.js"></script>
	<script>
	cb.apiurl = "<?=URL_API?>";
	cb.admurl = "<?=URL_ADMIN?>";
	cb.upurl = "<?=URL_UPLOADS?>";
	cb.rooturl = "<?=URL_ROOT?>";
	</script>
</head>
<body>
	<!-- [AJAX LOAD BLOCK SPINNER] -->
	<div id="page-loader">
		<img id="page-loader-spin" src="<?= URL_ROOT ?>public/img/cube-loader.svg">
	</div>

	<!-- [MODAL BOX] -->
	<div class="modal" id="page-modal"><div class="modal-dialog"><div class="modal-content">
		<div id="modal-header" class="modal-header">
			<h5 id="modal-title" class="modal-title"></h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div id="modal-body" class="modal-body"></div>
		<div id="modal-footer" class="modal-footer"></div>
	</div></div></div>

	<!-- [PAGE] -->
	<div id="page-wrapper">
		<?php if ($_PAGE['adm']) { ?>
		<!-- [SIDE BAR] -->
		<nav id="page-sidebar">
			<div id="sidebar-user">
				<img src="<?=URL_ROOT?>public/img/box.jpg">
				<div id="sidebar-site-name"><?=SITE_NAME?></div>
				<div id="sidebar-user-name"><?=$_SESSION['user']['user_name']?></div>
				<div id="sidebar-user-email"><?=$_SESSION['user']['user_email']?></div>
			</div>

			<ul class="list-unstyled components">
				<li>
					<a href="<?=URL_ADMIN?>">
						<span class="page-sidebar-ico"><i class="fa fa-tachometer-alt"></i></span> Dashboard
					</a>
				</li>
				<li>
					<a href="<?=URL_ADMIN?>users">
						<span class="page-sidebar-ico"><i class="fa fa-users"></i></span> Users
					</a>
				</li>
				<li>
					<a href="<?=URL_ADMIN?>orders">
						<span class="page-sidebar-ico"><i class="fa fa-sticky-note"></i></span> Orders
					</a>
				</li>
				<li>
					<a href="<?=URL_ADMIN?>media">
						<span class="page-sidebar-ico"><i class="fa fa-images"></i></span> Media
					</a>
				</li>
				<li>
					<a href="#menu-catalog" data-toggle="collapse" aria-expanded="false">
						<span class="page-sidebar-ico"><i class="fa fa-newspaper"></i></span> Catalog
					</a>
					<ul class="collapse list-unstyled" id="menu-catalog">
						<li><a href="<?=URL_ADMIN?>categories">Categories</a></li>
						<li><a href="<?=URL_ADMIN?>products">Products</a></li>
					</ul>
				</li>
				<li>
					<a href="#menu-settings" data-toggle="collapse" aria-expanded="false">
						<span class="page-sidebar-ico"><i class="fa fa-server"></i></span> Settings
					</a>
					<ul class="collapse list-unstyled" id="menu-settings">
						<li><a href="<?=URL_ADMIN?>sysconfig">System</a></li>
						<li><a href="<?=URL_ADMIN?>sysemail">Email</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php } ?>

		<!-- [PAGE CONTENT] -->
		<div id="page-content">
			<?php if ($_PAGE['adm']) { ?>
			<nav id="page-nav" class="navbar">
				<u>
					<i class="fa fa-lg fa-bars" onclick="cb.togside();"></i>
				</u>

				<span class="navbar-text">
					<u>
						<i class="fa fa-lg fa-sign-out-alt" onclick="cb.bye();"></i>
					</u>
				</span>
			</nav>
			<div id="page-A">
			<?php } ?>