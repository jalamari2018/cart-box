<?php
/*
 * API_CATALOG.PHP : CATALOG API
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("Catalog");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"CATALOG","Invalid request","",1);
		break;

	/* [GET ALL CATEGORIES] */
	case "get-all-cat":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getAllCat($_POST['page']),1);
		break;

	/* [GET CATEGORY BY ID] */
	case "get-cat":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getCat($_POST['category_id']),1);
		break;

	/* [GET CATEGORY BY SLUG] */
	case "get-cat-slug":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getCatSlug($_POST['category_slug']),1);
		break;

	/* [COUNT - FOR PAGINATION USE] */
	case "count-pdt":
		$count = $_CB->Catalog->pdtCount($_POST['search']);
		$pages = $_CB->pages($count);
		$_CB->verbose(1,"CATALOG","OK",array(
			"count" => $count,
			"pages" => $pages
		),1);
		break;

	/* [GET ALL PRODUCTS] */
	case "get-all-pdt":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getAllPdt($_POST['search'],$_POST['page'],$_POST['category_id']),1);
		break;
	
	/* [GET PRODUCTS IN CATEGORY] */
	case "get-pdt-cat":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getPdtCat($_POST['category_id']),1);
		break;

	/* [GET PRODUCT] */
	case "get-pdt":
		$_CB->verbose(1,"CATALOG","OK",$_CB->Catalog->getPdt($_POST['product_id']),1);
		break;
}
?>