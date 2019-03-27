<?php
/*
 * API_ADMIN_ORDERS.PHP : ADMIN ORDERS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("Order");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"ORDER","Invalid request","",1);
		break;

	/* [UPDATE ORDER STATUS] */
	case "up-status":
		if ($_CB->Order->update($_POST['order_id'],$_POST['order_status'])) {
			$_CB->verbose(1,"ORDER","Order status updated","",1);
		} else { die($_CB->sysmsg); }
		break;
}
?>