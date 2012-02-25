<?php
require_once 'SException.php';
require_once 'Request.php';
require_once 'View.php';
/**
 * Abstract controller 
 * @author shaked
 *
 */
abstract class Controller {
	/**
	 * @var View 
	 */
	protected $_view; 
	/**
	 * @var Request
	 */
	protected $_request;
	/**
	 * @var string 
	 */
	private $_actionMethod;

	const D_ACTION_NAME = 'index'; 
	
	public function __construct(Request $request){
		$this->_request 	= $request; 
		$this->_actionMethod= $this->_getValidAction();
		$this->_view 		= new View($this->_actionMethod);
		
		$this->init(); 
	}
	
	/**
	 * Controller's childs should use init() method as a constructor  
	 */
	protected function init(){} 
	 
	/**
	 * Execute's action validation and extract's all data to the view
	 * @return View
	 */
	final public function execute(){ 
		$actionMethod = $this->_actionMethod; 
		$this->$actionMethod(); 
		return $this->_view;  
	}
	
	
	/**
	 * Check if current action is valid
	 * @throws Controller_Exception
	 * @return string 
	 */
	public function _getValidAction(){
		$classMethods = get_class_methods($this);
		$actionName = $this->_request->getAction(); 
		
		if (!$actionName){ 
			$actionName = static::D_ACTION_NAME; 
		} 
		
		foreach($classMethods as $method){
			if ($actionName != $method){
				continue; 
			} 
			return $method; 
		} 
		throw new Controller_Exception('Method ' . $this->_request->getAction() . ' does not exist.'); 
	}
	
	/**
	 * Default page error handler 
	 */
	protected function error(){ 
		$this->_view->title = 'Error Occured';
	}
}

class Controller_Exception extends SException {} 