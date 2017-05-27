<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller {
	

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
		$this->load->model('User');
    }

	public function index_post(){
		
		$data['username']	= $this->post('username');
		$data['password']	= $this->post('password');
        $data_result['success'] = 0;
        $data_result['msg'] = "Invalid Username or Password";
		
		if (isset($data['username']) && !empty($data['username']) && isset($data['password']) && !empty($data['password'])){
			$model_response=$this->User->login_user($data);
			
			if($model_response == "E101"){
				$data_result['success'] = 0;
                $data_result['msg'] = "User doesn't Exists";
			}else{
				$data_result['success'] = 1;
                $data_result['msg'] = "Login Successfull";
                $data_result['jwt_token'] = JWT::encode($model_response['auth_key'], $this->config->item('jwt_key'));
                $data_result['userdata'] = $model_response;
			}
		}
		
		$this->response($data_result, parent::HTTP_OK);
    }

    /**
     * Example authentication using JWT
     */
    public function auth_post() {
	    $jwt_token = $this->post('jwt_token');

        $auth = Authentication::tokenAuth($jwt_token);
	    if($auth) {
            $this->response(array('success' => 1, 'userdata' => $auth));
        } else {
            $this->response(array('success' => 0, 'message' => 'Not Authorized'));
        }

    }

	
}

?>