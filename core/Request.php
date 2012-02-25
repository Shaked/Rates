<?php
/**
 * POST and GET Request handler
 * @author shaked
 */
class Request { 
	const XMLHTTPREQUEST = 'xmlhttprequest';
	/**
	 * Handle $_GET
	 * @param string $name
	 * @return mixed 
	 */
	public function query($name=null){
		if (!$name){
			return $_GET; 
		}
		
		if (!isset($_GET[$name])) {
			return false; 
		}
		
		return $_GET[$name]; 
	}
	
	/**
	 * Handle $_POST
	 * @param string $name
	 * @return mixed 
	 */
	public function post($name){
		if (!$name){
			return $_POST; 
		}
		
		if (!isset($_POST[$name])){
			return false; 
		}
		
		return $_POST[$name];
	}
	
	/**
	 * Check if request was fired
	 * @return boolean  
	 */
	public function isRequest(){ 
		return $this->isPost() || $this->isGet(); 
	}
	
	/**
	 * Check if POST request was fired
	 * @return boolean 
	 */
	public function isPost(){
		return !empty($_POST); 
	}
	
	/**
	 * Check if get request was fired and removing current action on-the-fly 
	 * @return boolean 
	 */
	public function isGet(){
		if (1 == count($_GET) && isset($_GET['r'])){
			return false; 
		}
		return true; 
	}
	
	/**
	 * Getter for current action 
	 * @return string|false
	 */
	public function getAction(){ 
		return (isset($_GET['r']))? $_GET['r']:false;
	}
	
	/**
	 * Setter 
	 * @var string $actionName 
	 */
	public function setAction($actionName){
		$_GET['r'] = $actionName; 
	}
	
	/**
	 * Check if current request is an ajax reqeuest 
	 * @return boolean 
	 */
	public function isAjax(){
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
					&& self::XMLHTTPREQUEST == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']));
	}
}