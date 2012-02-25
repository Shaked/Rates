<?php
require_once 'configs/app.php'; 
require_once APP_PATH . '/core/Controller.php';
require_once 'models/Rates/Model.php';  
/**
 * Application controller
 * @author shaked
 */
class App_Controller extends Controller {  
	 
	/**
	 * Index action
	 */
	protected function index(){ 	
		$this->_view->currencies = ''; 
		$this->_view->actionName = $this->_request->getAction();
		if ($this->_request->isRequest() && $currencyData = $this->_request->query('currencies')){
			$this->_view->currencies = $currencyData;
			
			$model = new App_Rates_Model();  
			try { 
				$this->_view->results = $model->convertToUSCurrencies(explode(',',$currencyData));
			} catch (App_Rates_Model_Exception $e){ 
				$this->_view->errorMsg = $e->getMessage();
			}
		}
		
	}
	
	/**
	 * Ajax action
	 */
	protected function ajax(){
		if (!$this->_request->isAjax()){
			die(); 
		}
		$currencyData = $this->_request->query('currencies');
			
		$model = new App_Rates_Model();  
		try { 
			$data = $model->convertToUSCurrencies(explode(',',$currencyData));
		} catch (App_Rates_Model_Exception $e){ 
			$data = array('error'=>$e->getMessage());
		}
		
		die(json_encode($data)); 
	}
	
} 