<?php
/**
 * View handler - handle presentation layer
 * @author shaked 
 */
class View { 
	/**
	 * @var string
	 */
	private $_viewPath;
	/**
	 * @var array
	 */  
	private $_classProperties; 
	/**
	 * @var array 
	 */
	private $_values = array(); 
	
	/**
	 * Constructor 
	 * @param string $action
	 */
	public function __construct($action){
		$this->_classProperties = get_object_vars($this);  
		$this->_viewPath 		= $this->_buildViewPath($action); 
	}
	
	/**
	 * Render view and expose HTML  
	 */
	public function render(){ 
		require_once($this->_viewPath); 
	}
	
	/**
	 * Magic set for undefined variables 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name,$value){
		if (isset($this->_classProperties[$name])){ 
			$this->$name = $value;
		} else {
			$this->_values[$name] = $value; 
		}
	}
	
	/**
	 * Views file should be able to get all view's data by using magic get
	 * @param string $name
	 * @return string|false 
	 */
	public function __get($name){
		if (isset($this->_values[$name])){
			return $this->_values[$name];
		}
		return false; 
	}
	/**
	 * Build view's path by action name
	 * @param string $action
	 * @return string 
	 */
	private function _buildViewPath($action){ 
		return  APP_PATH . '/protected/views/' . $action . '.php';
	}
	
}