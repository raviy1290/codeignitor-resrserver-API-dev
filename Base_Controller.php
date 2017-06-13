<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');

abstract class Base_Controller extends REST_Controller {
	
	protected $model=null;

	public function __construct($args = array()) {
		parent::__construct();
	}

	final protected function _init_model($model) {
		$this->model = $model;
		$this->load->model($model, '', true);
	}

	abstract protected function _api_keys($method, $type);

	protected function __custom_actions() {
		$config = array(
			"get" => array(),
			"post" => array(),
			"put" => array(),
			"delete" => array(),
		);
		return $config;
	}
	
	final protected function _custom_actions($method, $action) {
		$config = $this->__custom_actions();
		$action_config = (!empty($config[$method][$action]))? $config[$method][$action] : null;
		if (
			!empty($action_config)
			&& (!empty($action_config['method']) && !empty($action_config['required']))
		) {
			$action_config['required'] = (!empty($action_config['required']))? $action_config['required'] : array();
		}
		return $action_config;
	}

	final protected function _invoke_custom_actions($method, $item_id = null) {
		
		$action_call = json_decode(call_user_func( array( $this, $method ), 'action'), true) ;
		
		if ( !empty($action_call) ) {
			if ( !empty($action_call['name']) && !empty($action_call['args'])) {
				$action_config = $this->_custom_actions($method, $action_call['name']);
				
				if ( !empty($action_config) ) {
					$action_args = (!empty($action_call['args']))? $action_call['args'] : array();

					if ( empty(array_diff(array_keys($action_args), $action_config['required'])) ) {
						
						$response = call_user_func( array( $this, $action_config['method'] ), $action_args, $item_id);
						$this->response($response['data'], $response['status']);

					} else {
						$this->response("Invalid action call parameters: {$action_call['name']} ", $this::HTTP_BAD_REQUEST);
					}

				} else {
					$this->response("Invalid action call: {$action_call['name']}", $this::HTTP_BAD_REQUEST);
				}
			}
		}
	}

	final protected function _items_get($item_id){
		if ( $item_id ) {
			/*
			 * sample response preparation 
			 * But this can be served from single MODEL GET CALL
			 * 
			 * Ex
			 * $item_vo = $this->model->get($item_id);
			 */
			$item_vo = array('user_id'=>$item_id, 'user_name'=>'test user');
			(!empty($item_vo)) ? $this->response($item_vo, $this::HTTP_OK) : $this->response("Item not found", $this::HTTP_NOT_FOUND);

		} else {
			$this->response("Invalid query for items", $this::HTTP_BAD_REQUEST);
		}
	}

	final protected function _items_post($item_id) {
	}

	final protected function _items_put($item_id){
	}
	
	final protected function _items_delete($item_id){
	}

	protected function index_get($item_id = null){
		$this->_invoke_custom_actions('get', $item_id);
		$this->_items_get($item_id);
		$this->response("Invalid get parameters", $this::HTTP_BAD_REQUEST);
	}

	protected function index_post($item_id = null){
		$this->_invoke_custom_actions('post', $item_id);
		$this->_items_post($item_id);
		$this->response("Invalid post parameters", $this::HTTP_BAD_REQUEST);
	}

	protected function index_put($item_id = null){
		$this->_invoke_custom_actions('put', $item_id);
		$this->_items_put($item_id);
		$this->response("Invalid update parameters", $this::HTTP_BAD_REQUEST);
	}

	protected function index_delete($item_id = null){
		$this->_invoke_custom_actions('delete', $item_id);
		$this->_items_delete($item_id);
		$this->response("Invalid delete parameters", $this::HTTP_BAD_REQUEST);
	}
}
