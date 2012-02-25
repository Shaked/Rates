<?php
require_once 'SException.php'; 
/**
 * Handle server to server calls by usinc CURL 
 * @author shaked
 */
class Http {
	/**
	 * @var string
	 */
	private $_url;
	/**
	 * @var array
	 */
	private $_defaultOpt = array(
			CURLOPT_HTTPAUTH 	   => CURLAUTH_ANY,
			CURLOPT_HEADER		   => 0, 
			CURLOPT_RETURNTRANSFER => 1, 
		); 
		
	/**
	 * Constructor
	 * @param string $url
	 */
	public function __construct($url){
		$this->_url = $url; 
	}
	/**
	 * Executes HTTP request by using CURL 
	 * @throws HTTP_Request_Exception
	 * @param boolean $isSSL
	 * @param array $opts 
	 * @return string 
	 */
	public function exec($isSSL=false,array $opts = array()){ 
		$ch = curl_init();
		
		if (empty($opts)){
			$opts = $this->_defaultOpt; 
		}
		
		//attach url 
		$opts[CURLOPT_URL] = $this->_url;
		
		//support SSL mode 
		if ($isSSL){
			$opts[CURLOPT_SSL_VERIFYPEER] = false;
			$opts[CURLOPT_SSL_VERIFYHOST] = false;
		}
		
		curl_setopt_array(
			$ch,
			$opts
		); 
		
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		if (!$data){
			$exp = new HTTP_Request_Exception('response is empty, please verify that the URL ' . $this->_url . ' is working.');
			$exp->notify(); 
			throw $exp;  
		}
		
		return $data; 
	}
}

class HTTP_Request_Exception extends SException {}