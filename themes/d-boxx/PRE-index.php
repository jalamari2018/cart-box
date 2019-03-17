<?php
/*
 * PRE-INDEX.PHP : HOME PAGE META
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

/* [PAGE INFO] */
$_PAGE = array(
	"title" => "معرض اتجار",
	"desc" => "",
	"author" => ""
);

/* [GET CATEGORIES] */
$_CB->extend("Catalog");
$cat = $_CB->Catalog->getAllCat();
?>