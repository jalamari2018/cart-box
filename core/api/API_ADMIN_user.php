<?php
/*
 * API_ADMIN_USER.PHP : ADMIN USER
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_CB->extend("User");
switch ($_POST['req']) {
	/* [INVALID REQUEST] */
	default:
		$_CB->verbose(0,"AUSER","Invalid request","",1);
		break;

	/* [COUNT - FOR PAGINATION USE] */
	case "count":
		$count = $_CB->User->count($_POST['search']);
		$pages = $_CB->pages($count);
		$_CB->verbose(1,"AUSER","OK",array(
			"count" => $count,
			"pages" => $pages
		),1);
		break;

	/* [GET ALL USERS] */
	case "get-all":
		$_CB->verbose(1,"AUSER","OK",$_CB->User->getAll($_POST['search'],$_POST['page']),1);
		break;

	/* [GET USER BY ID] */
	case "get":
		$_CB->verbose(1,"AUSER","OK",$_CB->User->getID($_POST['user_id']),1);
		break;

	/* [GET USER BY EMAIL] */
	case "get-email":
		$_CB->verbose(1,"AUSER","OK",$_CB->User->getEmail($_POST['user_email']),1);
		break;

	/* [ADD USER] */
	case "add":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_User_Reg.php")) {
			$_CB->verbose(0,"AUSER","Error loading user registration hook","",1);
		}
		require PATH_HOOK."HOOK_User_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"AUSER","خطأ في المدخلات ",$checks,1);
		}

		// IF CHECKS ARE ALL GREEN - GO FOR ACTUAL DATABASE REGISTRATION
		$regPass = $_CB->User->add(array(
			"user_name" => $_POST['user_name'], 
			"user_email" => $_POST['user_email'], 
			"user_password" => $_POST['user_password'],
			"user_active" => $_POST['user_active'],
			"user_level" => $_POST['user_level']
		), $_POST['redirect']);

		if ($regPass) { $_CB->verbose(1,"AUSER","تم اضافة المستخدم بنجاح",$_CB->DB->lastID,1); }
		else { die($_CB->sysmsg); }
		break;

	/* [UPDATE USER] */
	case "update":
		// CHECK THE INPUT
		if (!file_exists(PATH_HOOK."HOOK_User_Reg.php")) {
			$_CB->verbose(0,"AUSER","Error loading user registration hook","",1);
		}
		require PATH_HOOK."HOOK_User_Reg.php";

		// INPUT CHECK FAIL
		if (!$regPass) {
			$_CB->verbose(0,"AUSER","User update check fail",$checks,1);
		}

		// IF CHECKS ARE ALL GREEN - GO FOR ACTUAL DATABASE UPDATE
		$regPass = $_CB->User->edit(array(
			"user_id" => $_POST['user_id'],
			"user_name" => $_POST['user_name'], 
			"user_email" => $_POST['user_email'],
			"user_level" => $_POST['user_level'],
			"user_active" => $_POST['user_active'],
			"user_password" => $_POST['user_password']
		));

		if ($regPass) { $_CB->verbose(1,"AUSER","تم تحديث البيانات بنجاح","",1); }
		else { die($_CB->sysmsg); }
		break;

	/* [SUSPEND USER] */
	case "suspend":
		if ($_CB->User->togstat($_POST['user_id'],0)) {
			$_CB->verbose(1,"AUSER","User suspended","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [ACTIVATE USER] */
	case "activate":
		if ($_CB->User->togstat($_POST['user_id'],1)) {
			$_CB->verbose(1,"AUSER","تم تنشيط المستخدم","",1);
		} else { die($_CB->sysmsg); }
		break;

	/* [DELETE USER] */
	case "del":
		if ($_CB->User->del($_POST['user_id'],1)) {
			$_CB->verbose(1,"AUSER","User deleted","",1);
		} else { die($_CB->sysmsg); }
		break;
}
?>