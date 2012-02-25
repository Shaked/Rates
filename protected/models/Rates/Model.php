<?php 
require_once APP_PATH . '/core/SException.php';
require_once('Storage.php');
/**
 * Rates model (data layer) 
 * @author shaked
 */
class App_Rates_Model { 
	/**
	 * @var App_Rates_Storage
	 */
	private $_storage; 
	
	const USD = 'USD'; 
	
	public function __construct(){
		$this->_storage = new App_Rates_Storage();
	}
	
	/**
	 * Get US currency rate by currency name 
	 * @throws App_Rates_Model_Exception
	 * @param string $currValues
	 * @return double|false
	 */
	private function _convertCurrencyRate($currValues){
		$data = explode(' ',$currValues);
		if (!isset($data[1])){
			throw new App_Rates_Model_Exception('Currency not valid'); 
		}
		$currency = $data[0]; 
		$amount   = (int)$data[1];  
		if (self::USD == $currency){ 
			return $amount; 
		} 
		
		$ratesData = $this->_storage->load();
		foreach ($ratesData as $data){
			if ($data->currency == $currency){
				
				return (double)$data->rate * $amount;
			}
		}
		return false; 
	}
	
	/**
	 * Get US currency foreach of the array values
	 * @throws App_Rates_Model_Exception  
	 * @param array<string> $data 
	 * @return array<string>
	 */
	public function convertToUSCurrencies(array $data){ 
		$retCurrencies = array(); 
		foreach($data as $currValues){
			$currValues = trim($currValues);
			if (isset($retCurrencies[$currValues])){
				continue ; 
			} 
			
			$convertedRate = $this->_convertCurrencyRate($currValues);
			
			if ($convertedRate) { 
				$retCurrencies[$currValues] = self::USD . ' ' . $convertedRate;
				continue ; 
			}  
			
			throw new App_Rates_Model_Exception('Rate ' . $currValues . ' does not exist in our DB'); 
		}
		
		return array_values($retCurrencies); 
	}
} 

class App_Rates_Model_Exception extends SException {}