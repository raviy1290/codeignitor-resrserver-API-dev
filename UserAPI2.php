<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/controllers/Base_Controller.php');

/*
 * http://localhost/ci_restserver_scale/CI/index.php/userapi2/121/?action={"name":"get_user_plus_additional_linked_data", "args":{"user_id":123}}
 * http://localhost/ci_restserver_scale/CI/index.php/userapi2/121
 */

class UserAPI2 extends Base_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->_init_model('user_model');
	}
	
	protected function _api_keys($method, $type) {
		$config = array(
				"get" => array(),
				"post" => array(),
				"put" => array(),
				"delete" => array(),
		);
		return $config[$method][$type];
	}
	
	protected function __custom_actions() {
		$config = array(
				"get" => array(
						"get_user_plus_additional_linked_data" => array(
								"method" => "get_user_plus_additional_linked_data",
								"required" => array(
										"user_id",
								),
						),
						
						/*
						 * can have many items which can server diff diff GET API endpoints for USER entity 
						 */
				),
	
				"post" => array(
						/*
						 * same as GET this can be used
						 */
				),
	
				"put" => array(						/*
						 * same as GET this can be used
						 */),
				"delete" => array(						/*
						 * same as GET this can be used
						 */),
	
		);
		return $config;
	}
	
	public function get_user_plus_additional_linked_data($args){
		try{
			/*
			 * sample response preparation 
			 * But this can be served from MODEL calls and preparing desired response
			 */
			$data = array ('user'=> array('user_id'=>'121', 'user_name'=>'121name'), 'additional'=>array());
			return array(
					"data" => $data,
					"status" => $this::HTTP_OK,
			);
		} catch (Exception $ex){
			return array(
					"data" => $ex->getMessage(),
					"status" => $this::HTTP_BAD_REQUEST,
			);
		}
	}

}
