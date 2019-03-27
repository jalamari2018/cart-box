<?php
/*
 * SITE_TOP.PHP : TOP HALF
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?=$_PAGE['desc']?>">
		<meta name="author" content="<?=$_PAGE['author']?>">
		<link rel="icon" href="<?=T_ASSET?>favicon.ico">
		<title><?=$_PAGE['title']?></title>
		<link href="https://cdn.rtlcss.com/bootstrap/v4.1.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
		<link href="<?=T_ASSET?>d-boxx.css" rel="stylesheet">
	</head>

	<body>
		<!-- [AJAX LOAD BLOCK SPINNER] -->
		<div id="page-loader">
			<img id="page-loader-spin" src="<?= URL_ROOT ?>public/img/cube-loader.svg">
		</div>

		<!-- [MODAL BOX] -->
		<div class="modal" id="page-modal"><div class="modal-dialog"><div class="modal-content" dir="rtl">
			<div id="modal-header" class="modal-header" dir="rtl">
				<h5 id="modal-title" class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div id="modal-body" class="modal-body"></div>
			<div id="modal-footer" class="modal-footer"></div>
		</div></div></div>


		

		<!-- [HEADER] -->
		<nav id="page-head" class="navbar" dir="rtl">
			<a href="<?=URL_ROOT?>">
				<img src="<?=URL_ROOT?>public/img/ettejar.png">
			</a>

			<div id="page-nav" class="navbar-text">
				<div class="page-nav-item">
					<a href="<?=URL_ROOT?>"><i class="fa fa-lg fa-home"></i></a>
				</div>
				<div class="page-nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="user-drop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-lg fa-user<?=is_array($_SESSION['user'])?"-check":""?>"></i>
					</a>
					<div id="page-user" class="dropdown-menu" aria-labelledby="user-drop">
						<?php if (is_array($_SESSION['user'])) { ?>
						<div style="padding:10px;">
							<img src="<?=URL_ROOT?>public/img/box.jpg">
							<div id="page-user-name"><?=$_SESSION['user']['user_name']?></div>
							<div id="page-user-email"><?=$_SESSION['user']['user_email']?></div>
						</div>
						<div class="dropdown-divider"></div>
						<a href="<?=URL_ROOT?>account" class="btn btn-primary btn-sm">
							 حسابي
						</a>
						<span class="btn btn-danger btn-sm" onclick="cb.bye()">
							 تسجيل خروج
						</span>
						<?php } else { ?>
						<form onsubmit="return cb.hi();">
							<div style="padding:10px 10px 0 10px">
								<div class="form-group">
									<div class="input-group mb-3">
										<input type="text" class="form-control form-control-sm" id="signin-email" placeholder="البريد " required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-at"></i></span>
										</div>
									</div>
									<div class="input-group mb-3">
										<input type="password" class="form-control form-control-sm" id="signin-password" placeholder="كلمة المرور" required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-key"></i></span>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary btn-sm">
								 تسجل دخول
							</button>
							<a href="<?=URL_ROOT?>account" class="btn btn-primary btn-sm">
								 حساب جديد
							</a>
							<button type="button" class="btn btn-danger btn-sm" onclick="cb.forgot();">
								 نسيت كلمة المرور
							</button>
						</form>
						<?php } ?>
					</div>
				</div>
				<div class="page-nav-item" onclick="cart.toggle()">
					<i class="fa fa-lg fa-shopping-cart"></i>
					<span id="cart-count" class="badge badge-danger">0</span>
				</div>
			</div>
		</nav>

		<!-- [MAIN CONTENTS] -->
		<main id="page-main" role="main">
			<div class="container">
				<div id="page-A">