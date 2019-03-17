<?php
/*
 * 404.PHP : FILE NOT FOUND
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME . "lib" . DIRECTORY_SEPARATOR . "site_def.php";

// HTML
require T_LIB . "site_top.php"; ?>
<div class="lost">
	<img src="<?= URL_ROOT ?>public/img/404-error.png">
	<h2>الصفحة المطلوبة غير موجودة.</h2>
	<p>
 
	</p>
	<a href="<?= URL_ROOT ?>" class='btn btn-danger'>Back to Home</a>
</div>
<?php require T_LIB . "site_bottom.php"; ?>