<?php
require_once 'Registry.php';
/**
 *	Database connection Singleton
 *	@author shaked 
 */
class Database {
	/**
	 * @var Resource 
	 */ 
	public $db;  
	/**
	 * @var Array 
	 */ 
	private $_res;
	/**
	 * @var Database 
	 */
	private static $_instance;
	/**
	 * @var array 
	 */
	private $_config; 
	/**
	 * @var integer
	 */
	private $_affectedRows; 
	
	/**
	 * Get database instance (Singelton design pattern) 
	 * @return Database 
	 */
	public function getInstance(){ 
		if (!self::$_instance){
			self::$_instance = new self; 
		}
		return self::$_instance; 
	}
	
	/**
	 *	Constructor must be private  
	 */
	private function __construct(){
		$this->_config = Registry::get('database'); 
		$this->_connect();  
	}
	/**
	 * 	Clone must be private
	 */ 
	private function __clone(){} 
	
	/**
	 * Setup connection to db 
	 * @throws PDOException
	 */
	private function _connect(){
		$this->_db = new PDO($this->_config['dsn'], $this->_config['dbuser'], $this->_config['dbpass']);
	} 
	
	/**
	 * Query your DB 
	 * @param string $statement
	 * @param array $data Optional
	 * @return PDOStatement|False 
	 */
	public function query($statement,array $data = array()){ 
		$pstmt = $this->_db->prepare($statement);
		$this->_affectedRows = $pstmt->execute($data); 
		return $pstmt; 	
	}
	
	/**
	 * Getter
	 * @return integer 
	 */
	public function getAffectedRows(){ 
		return $this->_affectedRows; 
	}
}