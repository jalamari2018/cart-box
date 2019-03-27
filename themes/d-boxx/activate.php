<?php
/*
 * ACTIVATE.PHP : FORGOT PASSWORD & ACCOUNT ACTIVATE PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// THEME PATHS
require PATH_THEME . "lib" . DIRECTORY_SEPARATOR . "site_def.php";

// HTML
$status = json_decode($_CB->sysmsg, 1);
require T_LIB . "site_top.php"; ?>
<div class="lost">
	<img src="<?= T_ASSET ?><?= $status['cb-status'] ? "ok.jpg" : "question-mark.jpg"?>">
	<h2><?= $status['cb-status'] ? "تمت العملية بنجاح" : "عفوا حصل خطأ" ?></h2>
	<p><?= $status['cb-msg'] ?></p>
	<a href="<?= URL_ROOT ?>" class='btn btn-danger'>عودة </a>
</div>
<?php require T_LIB . "site_bottom.php"; ?>