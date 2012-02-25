<?php
/**
 * Database configuration should be here
 */
require_once APP_PATH . '/core/Registry.php';

Registry::set('database', array( 
	'dsn' 	 => 'mysql:dbname=DemoApp;host=localhost',
	'dbpass' => '123123123', 
	'dbuser' => 'rates' 
));

