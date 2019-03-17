<?php
/*
 * PAGE-ACTIVATE.PHP : LE SPARTAN ACCOUNT ACTIVATE & FORGOT PASSWORD PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$status = json_decode($_CB->sysmsg,1); ?>
<!DOCTYPE html>
<html><body>
	<h2><?=$status['cb-status']?"Success":"Opps. An error has occured"?></h2>
	<p><?=$status['cb-msg']?></p>
</body></html>