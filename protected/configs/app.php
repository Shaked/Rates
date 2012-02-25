<?php
/**
 * Define global configuration here 
 * Include sub configs (e.g Database) 
 */
define('APP_PATH', dirname(dirname(dirname(__FILE__))));
define('IS_MEMCACHE',class_exists('Memcache')); 
define('ERRORS_EMAIL','errors@shakedos.com');
require_once 'db.php';

if (IS_MEMCACHE){
	require_once 'cache.php';
}

//TODO add autoloader 
