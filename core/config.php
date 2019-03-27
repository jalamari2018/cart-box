<?php
/*
 * CONFIG.PHP : CONFIGURATIONS
 * Visit https://code-boxx.com/cart-boxx/ for more
 */

// ERROR REPORTING
error_reporting(E_ALL & ~E_NOTICE);

// DATABASE SETTINGS
define('DB_HOST', 'localhost');
define('DB_NAME', 'mynewdatabase');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '1234');

// CRYPTO
define('SECRET_KEY', '2m*SMz5*s#`W');

// BASE URL
define('URL_ROOT', 'http://localhost/cart-boxx/');
?>