<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Restaurant extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data restaurant
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $restaurant = $this->db->get('restaurant')->result();
        } else {
            $this->db->where('id', $id);
            $restaurant = $this->db->get('restaurant')->result();
        }
        
		echo '{"restaurant":'.json_encode($restaurant).'}';
    }
	
	//Mengirim atau menambah data restaurant baru
	function index_post() {
        $data = array(
                    'nama' => $this->post('nama'),
                    'deskripsi' => $this->post('deskripsi'),
					'alamat' => $this->post('alamat'),
					'langlat' => $this->post('langlat'),
					'rate' => $this->post('rate'),
					'image' => $this->post('image'),
					'telp' => $this->post('telp'),
					'email' => $this->post('email'));
					
        $insert = $this->db->insert('restaurant', $data);
		
        if ($insert) {
            $this->response(array('success' => '1', 200));
        } else {
            $this->response(array('success' => '0', 502));
        }
    }

}
?>