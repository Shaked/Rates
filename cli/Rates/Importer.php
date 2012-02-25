<?php 
require_once APP_PATH . '/core/Http.php';
require_once APP_PATH . '/cli/Rates/XML/Parser.php';
require_once APP_PATH . '/protected/models/Rates/Storage.php'; 
/**
 * Import data from URL to DB 
 * @author shaked
 */
class Importer {
	/**
	 * 3rd party URL
 	 */
	const URL = 'https://www.rates.com/cgi-bin/xml?currency=all';
	const CACHE_TTL = 86400; 
	/**
	 * Run Importer 
	 */
	public function run(){ 
		$request = new Http(
			self::URL 
		);
		
		$xmlRatingResponse = $request->exec(true); 
		$parsedXmlData	   = App_Rates_XML_Parser::toArray($xmlRatingResponse);

		$this->store($parsedXmlData); 
	}

	/**
	 * Store data in our local DB
	 * @TODO store to memcache by default 
	 */
	private function store(array $parsedXmlData){ 
		$storage = new App_Rates_Storage();
		foreach($parsedXmlData as $data){ 
			$storage->save((array)$data);
		}
		
		
		if (IS_MEMCACHE){
			Cache::getInstance()->set('rates',$parsedXmlData,false,self::CACHE_TTL);
		}
	}
}