<?php
/**
 * Database configuration should be here
 */
require_once APP_PATH . '/core/Registry.php';

Registry::set('cache', array( 
	'host' 	 => 'localhost',
	'port'	 => 11211 
));

