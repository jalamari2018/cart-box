<?php
/*
 * META-SYSEMAIL.PHP : SYSTEM EMAIL CONFIG
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

$_PAGE = array(
	"title" => "Cart Boxx System Email Config",
	"desc" => "Cart Boxx System Email Config"
);

$_EMAIL = [
	array(
		"khead" => "TITLE_USER_FORGOT",
		"kbody" => "EMAIL_USER_FORGOT",
		"opt" => "[User] Forgotten Password",
		"vars" => ["{user_name}","{user_email}","{link}","{expire}"]
	),
	array(
		"khead" => "TITLE_USER_RESET",
		"kbody" => "EMAIL_USER_RESET",
		"opt" => "[User] Password Reset",
		"vars" => ["{user_name}","{user_email}","{password}"]
	),
	array(
		"khead" => "TITLE_USER_ACTIVATE",
		"kbody" => "EMAIL_USER_ACTIVATE",
		"opt" => "[User] Activation required",
		"vars" => ["{user_name}","{user_email}","{link}","{expire}"]
	),
	array(
		"khead" => "TITLE_USER_REG",
		"kbody" => "EMAIL_USER_REG",
		"opt" => "[User] Successful Registration",
		"vars" => ["{user_name}","{user_email}","{password}"]
	)
];
?>