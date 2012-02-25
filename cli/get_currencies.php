<?php
/**
 * Cron job
 * 	Imports all currency rates data from 3rd party service to our DB
 * 	Should run once a day.
 */
require_once('../protected/configs/app.php');
require_once 'Rates/Importer.php';

echo 'Importing currency rates data to db...' . PHP_EOL; 
$import = new Importer();
$import->run(); 
echo 'Done' . PHP_EOL; 