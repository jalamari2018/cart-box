<?php
/*
 * HOOK_USER_REG.PHP : REGISTRATION CHECKS
 * Visit https://code-boxx.com/cart-boxx/ for more
 * 
 * $_POST vars to pass in, if you want to use it.
 * req : "reg" new registration OR "update" update account - this affects the email check
 * user_id (update only)
 * user_name
 * user_email
 * user_password
 * confirm_password
 * 
 * !! EXTEND USER BEFORE THIS HOOK !!
 */

/*
 * NOTE - THESE 2 VARS ARE IMPORTANT AND USED IN API_USER.PHP
 * DO REMEMBER TO PROCESS THESE PROPERLY... OR THE API WILL FAIL
 */
$regPass = true; // IF THE REGISTRATION HAS PASSED
$checks = array(); // FOR HOLDING THE FORM CHECK RESULTS
$checkPW = true; // CHECK THE EMAIL PASSWORD?
// ON UPDATE USER ONLY - CHECK USER ID
if ($_POST['req']=="update") {
	// CHECK THE PASSWORD IF IT IS SENT OVER
	$checkPW = $_POST['user_password']!="" || $_POST['confirm_password']!="" ;

	// USER ID
	if (!is_numeric($_POST['user_id'])) {
		$regPass = false;
		$checks['user_id'] = "غير صحيح";
	}

	// "HACK" STOPPER - MAKE SURE USERS CAN ONLY UPDATE THEIR OWN ACCOUNT
	if ($_SESSION['user']['user_level']=="USR") { if ($_POST['user_id'] != $_SESSION['user']['user_id']) {
		$regPass = false;
		$checks['user_id'] = "يمكنك تعديل بيانات حسابك فقط";
	}}
}

// NAME
if (strlen($_POST['user_name'])<3) {
	$regPass = false;
	$checks['user_name'] = "يجب ان لا يقل اسم المستخدم عن 3 أحرف";
}

// EMAIL
if (filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)==false) {
	$regPass = false;
	$checks['user_email'] = "الرجاء ادخال بريد الكتروني صحيح";
}

// CHECK IF EMAIL IS ALREADY REGISTERED
// IF UPDATE, EXCLUDE SELF FROM CHECKS
else {
	if ($_CB->User->checkReg(
		$_POST['user_email'],
		($_POST['req']=="update" ? $_POST['user_id'] : "")
	)) {
		$regPass = false;
		$checks['user_email'] = $_POST['user_email']." البريد مستخدم ";
	}
}

// PASSWORD
if ($checkPW) {
	if (strlen($_POST['user_password'])<6) {
		$regPass = false;
		$checks['user_password'] = "يجب ان لاتقل كلمة المرور عن 6 أحرف";
	}
	if (strlen($_POST['confirm_password'])<6) {
		$regPass = false;
		$checks['confirm_password'] = "يجب ان لا تقل كلمة المرور عن 6 أحرف";
	}

	// CHECK IF PASSWORDS MATCH
	if ($regPass && $_POST['user_password']!=$_POST['confirm_password']) {
		$regPass = false;
		$checks['confirm_password'] = "كلمات المرور غير متطابقة";
	}
}
?>