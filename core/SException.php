<?php
/**
 * Exception handler 
 * @author shaked
 *
 */
class SException extends Exception { 
	/**
	 * Notify errors by mail
	 */
	public function notify(){ 
		if (defined('ERRORS_EMAIL')){
			mail(ERRORS_EMAIL,$this->getMessage(),$this->getMessage());
		} 
	}
}