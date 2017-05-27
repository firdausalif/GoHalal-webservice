<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Register extends REST_Controller {
	

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
		$this->load->model('User');
    }

	public function index_post()
    {
        $data['username']	= $this->post('username');
        $data['email']      = $this->post('email');
        $data['password']	= $this->post('password');
		$data['telp']		= $this->post('telp');

        if (isset($data['username']) && !empty($data['username']) && isset($data['email']) && !empty($data['email']) && isset($data['password']) && !empty($data['password']) && isset($data['telp']) && !empty($data['telp'])) 
        {
            $model_response=$this->User->register_user($data);

            if($model_response == "E101"){
                $data_result['success'] = 0;
                $data_result['msg'] = "User already Exists";
            }else if($model_response == "E103"){
                $data_result['success'] = 0;
                $data_result['msg'] = "Record Not Inserted";
            }else{
                $data_result['success'] = 1;
                $data_result['msg'] = "Registration Successfull";
            }
        }
        else{
            $data_result['success'] = 0;
            $data_result['msg'] = "Please Check Your Request";
        }
        $this->response($data_result);
    }

	
}

?>