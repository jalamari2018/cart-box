<?php
/*
 * REGSUCCESS.PHP : REG OK PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
// THEME PATHS
require PATH_THEME."lib".DIRECTORY_SEPARATOR."site_def.php";

// HTML
require T_LIB."site_top.php"; ?>
<div class="lost">
	<img src="<?=T_ASSET?>welcome.jpg"/>
	<h2> تم التسجيل بنجاح...</h2>
	<p>
	تم ارسال رابط التنشيط لحسابك على بريدك الالكتروني. الرجاء التنشيط خلال 72 ساعة القادمة
	</p>
	<a href="<?= URL_ROOT ?>" class='btn btn-danger'>عودة </a>
</div>
<?php require T_LIB."site_bottom.php"; ?>