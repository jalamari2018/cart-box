<?php
/*
 * API_ADMIN_CATALOG.PHP : ADMIN CATALOG API
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("Catalog");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"CATALOG","Invalid request","",1);
		break;

	/* [ADD NEW CATEGORY] */
	case "add-cat":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_Cat_Reg.php")) {
			$_CB->verbose(0,"ACATALOG","Error loading category check hook","",1);
		}
		require PATH_HOOK."HOOK_Cat_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"ACATALOG","Category data check fail",$checks,1);
		}

		// INSERT CATEGORY
		if ($_CB->Catalog->addCat(array(
			"category_name" => $_POST['category_name'],
			"category_slug" => $_POST['category_slug'],
			"category_description" => $_POST['category_description'],
			"category_image" => $_POST['category_image']
		))) {
			$_CB->verbose(1,"ACATALOG","Category added",$_CB->DB->lastID,1);
		} else { die($_CB->sysmsg); }
		break;

	/* [EDIT CATEGORY] */
	case "edit-cat":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_Cat_Reg.php")) {
			$_CB->verbose(0,"ACATALOG","Error loading category check hook","",1);
		}
		require PATH_HOOK."HOOK_Cat_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"ACATALOG","Category data check fail",$checks,1);
		}

		// UPDATE CATEGORY
		if ($_CB->Catalog->editCat(array(
			"category_id" => $_POST['category_id'],
			"category_name" => $_POST['category_name'],
			"category_slug" => $_POST['category_slug'],
			"category_description" => $_POST['category_description'],
			"category_image" => $_POST['category_image']
		))) {
			$_CB->verbose(1,"ACATALOG","Category updated","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [DELETE CATEGORY] */
	case "del-cat":
		if ($_CB->Catalog->delCat($_POST['category_id'])){
			$_CB->verbose(1,"ACATALOG","Category deleted","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [ADD NEW PRODUCT] */
	case "add-pdt":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_Pdt_Reg.php")) {
			$_CB->verbose(0,"ACATALOG","Error loading product check hook","",1);
		}
		require PATH_HOOK."HOOK_Pdt_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"ACATALOG","Product data check fail",$checks,1);
		}

		// INSERT PRODUCT
		if ($_CB->Catalog->addPdt(array(
			"product_name" => $_POST['product_name'],
			"product_slug" => $_POST['product_slug'],
			"product_description" => $_POST['product_description'],
			"product_image" => $_POST['product_image'],
			"product_price" => $_POST['product_price']
		))) {
			$_CB->verbose(1,"ACATALOG","Product added",$_CB->DB->lastID,1);
		} else { die($_CB->sysmsg); }
		break;

	/* [EDIT PRODUCT] */
	case "edit-pdt":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_Pdt_Reg.php")) {
			$_CB->verbose(0,"ACATALOG","Error loading product check hook","",1);
		}
		require PATH_HOOK."HOOK_Pdt_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"ACATALOG","Product data check fail",$checks,1);
		}

		// INSERT PRODUCT
		if ($_CB->Catalog->editPdt(array(
			"product_id" => $_POST['product_id'],
			"product_name" => $_POST['product_name'],
			"product_slug" => $_POST['product_slug'],
			"product_description" => $_POST['product_description'],
			"product_image" => $_POST['product_image'],
			"product_price" => $_POST['product_price']
		))) {
			$_CB->verbose(1,"ACATALOG","Product updated","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [DELETE PRODUCT] */
	case "del-pdt":
		if ($_CB->Catalog->delPdt($_POST['product_id'])){
			$_CB->verbose(1,"ACATALOG","Product deleted","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [ADD PRODUCT TO CATEGORY] */
	case "add-pdt-to-cat":
		if ($_CB->Catalog->pdtAddCat($_POST['p2c'])){
			$_CB->verbose(1,"ACATALOG","Products assigned to categories","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [DEL PRODUCT TO CATEGORY] */
	case "del-pdt-to-cat":
		if ($_CB->Catalog->pdtDelCat($_POST['p2c'])){
			$_CB->verbose(1,"ACATALOG","Products removed from categories","",1);
		} else { die($_CB->sysmsg); }
		break;
}
?>