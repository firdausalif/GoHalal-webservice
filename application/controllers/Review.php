<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Review extends REST_Controller {
	

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

	function index_post() {
        $data = array(
                    'iduser' => $this->post('iduser'),
                    'idmenu' => $this->post('idmenu'),
					'rate' => $this->post('rate'),
					'namauser' => $this->post('namauser'),
					'namamenu' => $this->post('namamenu'),
					'review' => $this->post('review'));
					
        $insert = $this->db->insert('review', $data);
		
        if ($insert) {
            $this->response(array(
                'success' => '1',
                'menu' => $data
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('success' => '0', REST_Controller::HTTP_BAD_GATEWAY));
        }
    } 

	
}

?>