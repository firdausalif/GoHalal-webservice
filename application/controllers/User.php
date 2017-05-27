<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
		$this->load->library('encryption');
    }

    //Menampilkan data users
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $gohalal = $this->db->get('user')->result();
        } else {
            $this->db->where('id', $id);
            $gohalal = $this->db->get('user')->result();
        }
        $this->response($gohalal, 200);
    }
	
    //Masukan function selanjutnya disini
		function index_post() {
        $data = array(
                    'username'=> $this->post('username'),
					'email'=> $this->post('email'),
					'password'=> $this->post('password'),
					'auth_key'=> $this->post('auth_key'),
					'refresh_token'=> $this->post('refresh_token'),
                    'telp'=> $this->post('telp'),
					'api_key'=> $this->post('api_key'),
					'last_login'=> $this->post('last_login'),
					'created'=> $this->post('created'),
					'last_ip'=> $this->post('last_ip')
					);
					
        $insert = $this->db->insert('user', $data);
        if ($insert) {
            $this->response(array('status' => 'success','massage' => 'Register Success'));
        } else {
            $this->response(array('status' => 'fail','massage' => 'Registeration Failed'));
        }
    }
}
?>