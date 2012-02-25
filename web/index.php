<?php
require_once('../protected/Controller.php');
$request = new Request();  

//Catch action which does not exist
try {
	$controller = new App_Controller($request);
} catch (Controller_Exception $e){
	$request ->setAction('error');
	$controller = new App_Controller($request);
}

echo $controller->execute()
				->render();