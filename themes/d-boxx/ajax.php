<?php
/*
 * AJAX.PHP : AJAX CONTENT HANDLER PAGE
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

require PATH_THEME."lib".DIRECTORY_SEPARATOR."site_def.php";
$handler = T_LIB . "ajax-" . $_CB->url[1] . ".php";
if (!file_exists($handler)) {
	die("INVALID REQUEST");
}
require $handler;
?>