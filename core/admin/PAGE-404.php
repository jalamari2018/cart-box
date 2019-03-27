<?php
/*
 * PAGE-404.PHP : FILE NOT FOUND
 * Visit https://code-boxx.com/cart-boxx/ for more
 */
?>
<div class="lost">
<img src="<?= URL_ROOT ?>public/img/404-error.png">
<h2>Opps. The file you specified is not found.</h2>
<p>
	You have requested for a file that is not found on this server.
	It may have been abducted by aliens for evil experiments, or maybe, it has been sucked into a black hole.
</p>
<?php if ($_SESSION['user']['user_level']=="ADM") { ?>
<a href="<?=URL_ADMIN?>" class='btn btn-danger'>Back to Home</a>
<?php } ?>
</div>
<style>
.lost{
	max-width:600px;
	text-align:center;
	margin:0 auto;
}
.lost img{
	width:100%;
	height:auto;
	margin-bottom:30px;
}
.lost p{
	font-size:14px;
}
</style>