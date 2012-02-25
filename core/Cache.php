<?php
/**
 * Memcahe Handler 
 * @author shaked
 */
class Cache { 
	/**
	 * @var Memcache 
	 */
	private $_mCache;
	/**
	 * @var Cache
	 */
	private static $_instance; 

	/**
	 * Singleton instance
	 * @return Cache
	 */
	public function getInstance(){
		if (!self::$_instance){
			self::$_instance = new self();
		}
	
		return self::$_instance; 
	}
	
	
	/**
	 * Get Memcache or execute callback function 
	 * @param string $name
	 * @param array $callback
	 * @return stdClass|mixed
	 */
	public function get($name,array $callback = array()){
		if ($cache = $this->_mCache->get($name)){
			return $cache; 
		}
		
		if (empty($callback)){
			return false; 
		}
		
		return call_user_func($callback);
	}
	
	/**
	 * Setter for memcahe
	 * @param string $name
	 * @param mixed $data
	 */
	public function set($name,$data,$compressed=false,$expire=0){ 
		$this->_mCache->set($name,$data,$compressed,$expire); 
	}
	
	/**
	 * Constructor 
	 * Apply memcache init
	 */
	private function __construct(){
		$this->_mCache = new Memcache;
		$config = Registry::get('cache');
		$this->_mCache->addServer($config['host'], $config['port']); 
	}
	
	private function __clone(){}
}