<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Menu extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data restaurant_menu
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $restaurant_menu = $this->db->get('restaurant_menu')->result();
        } else {
            $this->db->where('id', $id);
            $restaurant_menu = $this->db->get('restaurant_menu')->result();
        }
		echo '{"menu":'.json_encode($restaurant_menu).'}';
    }
	
	//Mengirim atau menambah data restaurant baru
	function index_post() {
        $data = array(
                    'idresto' => $this->post('idresto'),
                    'nama' => $this->post('nama'),
					'deskripsi' => $this->post('deskripsi'),
					'rate' => $this->post('rate'),
					'price' => $this->post('price'));
					
        $insert = $this->db->insert('restaurant_menu', $data);
		
        if ($insert) {
            $this->response(array('success' => '1', 200));
        } else {
            $this->response(array('success' => '0', 502));
        }
    }

}
?>