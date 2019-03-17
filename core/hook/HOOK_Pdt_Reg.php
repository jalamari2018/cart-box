<?php
/*
 * HOOK_PDT_REG.PHP : PRODUCT DATA CHECKS
 * Visit https://code-boxx.com/cart-boxx/ for more
 * 
 * $_POST vars to pass in, if you want to use it.
 * req : "add-cat" new category OR "edit-cat" update category
 * product_id (update only)
 * product_name
 * product_description
 * product_image
 * product_price
 * 
 * !! EXTEND CATALOG BEFORE THIS HOOK !!
 */

/*
 * NOTE - THESE 2 VARS ARE IMPORTANT AND USED IN API_USER.PHP
 * DO REMEMBER TO PROCESS THESE PROPERLY... OR THE API WILL FAIL
 */
$regPass = true; // IF THE REGISTRATION HAS PASSED
$checks = array(); // FOR HOLDING THE FORM CHECK RESULTS

// ON UPDATE USER ONLY - CHECK CAT ID
if ($_POST['req']=="edit-pdt" && !is_numeric($_POST['product_id'])) {
	$regPass = false;
	$checks['product_id'] = "Invalid product ID";
}

// PRODUCT NAME
if (strlen($_POST['product_name'])<3) {
	$regPass = false;
	$checks['product_name'] = "Please enter product name (at least 3 characters)";
}

// PRODUCT PRICE
if (filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT)==false) {
	$regPass = false;
	$checks['product_price'] = "Please enter a valid product price";
}
?>