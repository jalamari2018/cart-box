<?php
/*
 * PRE-CATEGORY.PHP : CATEGORY PAGE META
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

/* [GET CATEGORY] */
$_CB->extend("Catalog");
$cat = $_CB->Catalog->getCatSlug($_CB->url[1]);

// INVALID CATEGORY
if (!is_array($cat)) {
	header("HTTP/1.0 404 Not Found");
	require PATH_THEME . "404.php";
	die();
}

/* [PAGE INFO] */
$_CB->udepth = 2;
$_PAGE = array(
	"title" => "معرض اتجار - ".$cat['category_name'],
	"desc" => "",
	"author" => ""
);

// PRODUCTS
$pdt = $_CB->Catalog->getPdtCat($cat['category_id']);
?>