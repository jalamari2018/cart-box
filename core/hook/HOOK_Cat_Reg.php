<?php
/*
 * HOOK_CAT_REG.PHP : CATEGORY DATA CHECKS
 * Visit https://code-boxx.com/cart-boxx/ for more
 * 
 * $_POST vars to pass in, if you want to use it.
 * req : "add-cat" new category OR "edit-cat" update category
 * category_id (update only)
 * category_name
 * category_description
 * category_image
 * 
 * !! EXTEND CATALOG BEFORE THIS HOOK !!
 */

/*
 * NOTE - THESE 2 VARS ARE IMPORTANT AND USED IN API_USER.PHP
 * DO REMEMBER TO PROCESS THESE PROPERLY... OR THE API WILL FAIL
 */
$regPass = true; // IF THE REGISTRATION HAS PASSED
$checks = array(); // FOR HOLDING THE FORM CHECK RESULTS

// ON UPDATE CATEGORY ONLY - CHECK CAT ID
if ($_POST['req']=="edit-cat" && !is_numeric($_POST['category_id'])) {
	$regPass = false;
	$checks['category_id'] = "Invalid category ID";
}

// CATEGORY NAME
if (strlen($_POST['category_name'])<3) {
	$regPass = false;
	$checks['category_name'] = "Please enter category name (at least 3 characters)";
}

// CATEGORY SLUG
if ($_CB->Catalog->checkCatSlug(
	$_POST['category_slug'],
	($_POST['req']=="edit-cat" ? $_POST['category_id'] : "")
)) {
	$regPass = false;
	$checks['category_slug'] = "Slug is already in use";
}
?>