<?php
/*
 * PRE_REGSUCCESS.PHP : REG OK PAGE META
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

/* [ALREADY SIGNED IN...] */
if (is_array($_SESSION['user'])) {
	header('Location: ' . URL_ROOT);
	die();
}

/* [PAGE INFO] */
$_PAGE = array(
	"title" => "معرض اتجار",
	"desc" => "",
	"author" => ""
);
?>