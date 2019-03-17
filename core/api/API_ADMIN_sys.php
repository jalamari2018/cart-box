<?php
/*
 * API_ADMIN_SYS.PHP : ADMIN SYSTEM
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"ASYS","Invalid request","",1);
		break;

	/* [GET SYSTEM CONFIG GROUP(S)] */
	case "get-cfg":
		$_CB->verbose(1,"ASYS","OK",$_CB->getCFG($_POST['config_group'],0),1);
		break;

	/* [GET CONFIG WITH KEY(S)] */
	case "get-cfg-key":
		$_CB->verbose(1,"ASYS","OK",$_CB->getCFGKey($_POST['config_key']),1);
		break;

	/* [MASS SET SYSTEM CONFIG] */
	case "set-cfg":
		if ($_CB->setCFG($_POST['config'])) {
			$_CB->verbose(1,"ASYS","System config updated","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;
}
?>