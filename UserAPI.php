<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

class UserAPI extends REST_Controller {

    function user_get($id=null)
    {
    	if(!$id){
    		$this->response(array(
					"data" => 'may be limited all users data!!!',
					"status" => $this::HTTP_OK,
			));
    	} else {
    		$this->response(array(
					"data" => 'user data for user ID '.$id,
					"status" => $this::HTTP_OK,
			));
    	}
    }
    
    function user_plus_additional_info_get($id=null){
    	$this->response(array(
    			"data" => 'user data + additional data for user ID '.$id,
    			"status" => $this::HTTP_OK,
    	));
    }
     
    function user_post()
    {
		$this->response(array('status' => 'success'));   
    }
}
