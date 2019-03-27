<?php
/*
 * API_CART.PHP : SHOPPING CART
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("Cart");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"CART","خطأ في الطلب","",1);
		break;

	/* [COUNT CART] */
	case "count":
		$_CB->verbose(1,"CART","OK",$_CB->Cart->count(),1);
		break;

	/* [ADD TO CART] */
	case "add":
		if ($_CB->Cart->add($_POST['product_id'],$_POST['qty'])) {
			$_CB->verbose(1,"CART","تمت الإضافة لعربة التسوق","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;

	/* [CHANGE QTY] */
	case "change":
		if ($_CB->Cart->change($_POST['product_id'],$_POST['qty'])) {
			$_CB->verbose(1,"CART","تم تحديث الكمية","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;

	/* [REMOVE FROM CART] */
	case "remove":
		if ($_CB->Cart->remove($_POST['product_id'],$_POST['qty'])) {
			$_CB->verbose(1,"CART","تم الحذف من عربة التسوق","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;

	/* [NUKE] */
	case "nuke":
		if ($_CB->Cart->nuke()) {
			$_CB->verbose(1,"CART","تم افراغ سلة التسوق","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;

	/* [SHOW CART : SPARTAN] */
	case "show":
		$_CB->verbose(1,"CART","OK",$_SESSION['cart'],1);
		break;

	/* [SHOW CART : MORE] */
	case "showall":
		$_CB->verbose(1,"CART","OK",$_CB->Cart->show(),1);
		break;

	/* [CHECKOUT] */
	case "checkout":
		if ($_CB->Cart->checkout()) {
			$_CB->verbose(1,"CART","تم التنفيذ بنجاح",$_CB->DB->lastID,1);
		} else { die($_CB->sysmsg); }
		break;
}
?>