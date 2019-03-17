<?php
/*
 * API_USER.PHP : USER ACCOUNT API
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("User");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"USER","خطأ في الطلب","",1);
		break;

	/* [LOG IN] */
	case "login":
		// ALREADY IN
		if (is_array($_SESSION['user'])) {
			$_CB->verbose(1,"USER","المستخدم مسجل ","",1);
		}

		// CHECK IN
		if ($_CB->User->signin($_POST['user_email'], $_POST['user_password'])) {
			$_CB->verbose(1,"USER","تم تسجيل الدخول بنجاح","",1);
		} else { 
			die($_CB->sysmsg);
		}
		break;

	/* [LOG OFF] */
	case "logoff":
		// NOT IN
		if (!is_array($_SESSION['user'])) {
			$_CB->verbose(1,"USER","المستخدم غير مسجل دخول","",1);
		}

		// CHECK OUT
		unset($_SESSION['user']);
		$_CB->verbose(1,"USER","تم تسجيل الخروج بنجاح","",1);
		break;

	/* [REGISTER NEW USER] */
	case "reg":
		// ALREADY SIGNED IN
		if (is_array($_SESSION['user'])) {
			$_CB->verbose(0,"USER","الرجاء تسجيل الخروج اولا","",1);
		}

		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_User_Reg.php")) {
			$_CB->verbose(0,"USER","Error loading user registration hook","",1);
		}
		require PATH_HOOK."HOOK_User_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"USER","خطأ في التسجيل ",$checks,1);
		}

		// IF CHECKS ARE ALL GREEN - GO FOR ACTUAL DATABASE REGISTRATION
		$regPass = $_CB->User->add(array(
			"user_name" => $_POST['user_name'], 
			"user_email" => $_POST['user_email'], 
			"user_password" => $_POST['user_password'],
			"user_level" => "USR",
			"user_active" => 2
		), $_POST['redirect']);

		if ($regPass) { $_CB->verbose(1,"USER","تم التسجيل بنجاح",$_CB->DB->lastID,1); }
		else { die($_CB->sysmsg); }
		break;

	/* [UPDATE] */
	case "update":
		// NOT IN
		if (!is_array($_SESSION['user'])) {
			$_CB->verbose(0,"USER","Not signed in","",1);
		}

		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_User_Reg.php")) {
			$_CB->verbose(0,"USER","Error loading user registration hook","",1);
		}
		require PATH_HOOK."HOOK_User_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"USER","فشلت عملية تحديث البياتات",$checks,1);
		}

		// IF CHECKS ARE ALL GREEN - GO FOR ACTUAL DATABASE UPDATE
		$regPass = $_CB->User->edit(array(
			"user_id" => $_SESSION['user']['user_id'],
			"user_name" => $_POST['user_name'], 
			"user_email" => $_POST['user_email'],
			"user_password" => $_POST['user_password']
		));

		if ($regPass) {
			// UPDATE SESSION 
			$_SESSION['user'] = $_CB->User->getEmail($_POST['user_email']);
			$_CB->verbose(1,"USER","تم التحديث بنجاح","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;

	/* [FORGOT PASSWORD REQUEST] */
	case "forgot":
		// ALREADY SIGNED IN
		if (is_array($_SESSION['user'])) {
			$_CB->verbose(0,"USER","المستخدم مسجل في النظام","",1);
		}

		// SEND MAIL
		if ($_CB->User->forgotA($_POST['user_email'], $_POST['redirect'])) {
			$_CB->verbose(1,"USER","تم الارسال على بريدك الالكتروني","",1);
		} else {
			die($_CB->sysmsg);
		}
		break;
}
?>