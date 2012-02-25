<?php
/**
 * Singleton
 * Registery for global variables
 * @author shaked 
 */
class Registry {
	/**
	 * @var Registry 
	 */
	private static $_instance;

	/**
	 * Get self instance - Singleton 
	 * @return Registry
	 */
 	public function getInstance(){
 	 	if (!self::$_instance){
  	 		self::$_instance = new self;
   		}
   		
   		return self::$_instance; 
 	}
 	
 	/**
 	 * Setter - Register global variable 
 	 * @param string $name
 	 * @param mixed $value
 	 */
	public static function set($name,$value){
   		self::getInstance()->_setValue($name,$value);
	}
  
	/**
	 * Register multiple global variables
	 * @param array $values
	 */
  	public static function setValues(array $values){
  		$instance = self::getInstance(); 
	  	foreach($values as $key=>$val){ 
	  		$instance->_setValue($key,$val); 
	  	}
	}
	
	/**
	 * Getter - Use a registered global variable
	 * @param string $name
	 */
	public static function get($name){
		return self::getInstance()->_getValue($name);
  	}
 	
  	/**
  	 * Setter
  	 * @param string $name
  	 * @param mixed $value
  	 */
  	private function _setValue($name,$value){
   		$this->$name = $value;
  	}

	/**
	 * Getter
	 * @param string $name
	 * @return mixed|false
	 */
	private function _getValue($name){
		if (isset($this->$name)){
  			return $this->$name; 
   		}
		return false;
	}

  	/**
  	 * Singleton should block object initiation and clonning  
  	 */
	private function __construct(){}
	private function __clone(){}
}