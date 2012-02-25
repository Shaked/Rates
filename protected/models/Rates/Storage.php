<?php
require_once APP_PATH . '/core/SException.php'; 
require_once APP_PATH . '/core/Database.php'; 
require_once APP_PATH . '/core/Cache.php';
/**
 * Storage object handles database functions (load,save)
 * @author shaked
 */
class App_Rates_Storage {
	/**
	 * @var Database
	 */
	private $_db; 

	const DB_TABLE = 'exchange_rates'; 
	
	public function __construct(){
		$this->_db = Database::getInstance(); 
	}
	
	/**
	 * Load rates data from DB
	 * @return stdClass
	 */
	public function load(){ 
		if (IS_MEMCACHE){
			return $this->_loadFromCache();
		} 
		return $this->_loadFromDb();  
	}
	
	/**
	 * Load data from cache with callback to load from db 
	 * @return stdClass
	 */
	public function _loadFromCache(){
		return Cache::getInstance()->get('rates',array($this,'_loadFromDb'));
	}
	
	/**
	 * Load data from DB 
	 * @return stdClass
	 */
	public function _loadFromDb(){
		$statement = 'SELECT currency,rate FROM ' . self::DB_TABLE; 
		$query = $this->_db->query($statement);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	
	/**
	 * Save rates data to DB 
	 * @param array $data
	 * @throws App_Rates_Storage_Exception
	 */
	public function save(array $data){
		$statement = 'REPLACE INTO ' . self::DB_TABLE . ' (currency,rate) VALUES (?,?) ';
		if (!$this->_db->query($statement,array_values($data))){
			throw new App_Rates_Storage_Exception('query was not saved: ' . implode('|',$data));  
		}
		return $this->_db->getAffectedRows(); 
	}
}

class App_Rates_Storage_Exception extends SException {} 