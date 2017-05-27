<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Restomenu extends REST_Controller {
	

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

	public function index_post(){
		
		$idresto = $this->post('idresto');
		
		if (isset($idresto) && !empty($idresto)) {
            $this->db->select('*');
            $this->db->where("idresto", $idresto);
            $this->db->from("restaurant_menu");
            $query = $this->db->get()->result();

            echo '{"menu":' . json_encode($query) . '}';
        }
				
    }

    /**
     *  Ini contoh get yang bener, post itu biasakan untuk nyimpen ke DB / proses seperti login
     */
    public function index_get() {
	    $idresto = $this->get('idresto');
	    if(isset($idresto) && empty($idresto)) {
            $this->db->select('*');
            $this->db->where("idresto", $idresto);
            $this->db->from("restaurant_menu");
            $data = $this->db->get()->result();
            $this->response(array(
                'success' => false,
                'menu' => $data
            ), REST_Controller::HTTP_OK);
        } else {
	        $this->response(array(
	            'success' => false,
                'message' => 'Not Found'
            ), REST_Controller::HTTP_NO_CONTENT);
        }
    }


}

?>