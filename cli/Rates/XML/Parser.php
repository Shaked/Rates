<?php
/**
 * Parse XML string to different data type 
 * @author shaked
 *
 */
class App_Rates_XML_Parser {
	/**
	 * Parse XML string to array of object values
	 * @param string $xmlString
	 * @return array<stdClass>
	 */
	public static function toArray($xmlString){
		$xmlElement 	 = new SimpleXMLElement($xmlString);
		$currenciesRates = array();
		foreach($xmlElement as $tag=>$value){
			$object = new stdClass();
			$object->currency = (string)$value->currency;
			$object->rate	  = (string)$value->rate; 
			$currenciesRates[] = $object; 
		} 
		
		return $currenciesRates; 
	}
}