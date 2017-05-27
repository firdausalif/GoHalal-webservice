<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Restaurant extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('RestaurantModel');
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
        if($this->post()) {
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

    /*
     * Dibikin kaya gini semua 1 controller aja
     * Use : /restaurant/menus + ( ?id=id or ?nama=nama&price=10000-200000&search
     */
    public function menus_get() {

        $idresto = $this->get('idresto');
        $id = $this->get('id');
        $result = false;
        $search = $this->get('search');
        if(!is_null($search)) {
            $filter = $this->get();
            $result = $this->RestaurantModel->searchMenu($filter);
        } else {
            if(isset($id) && !empty($id)) {
                $result = $this->RestaurantModel->getMenu($id);
            } else {
                if(isset($idresto) && !empty($idresto)) {
                    $result = $this->RestaurantModel->getRestoMenu($idresto);
                } else {
                    $result = $this->RestaurantModel->getMenu();
                }
            }
        }


        if($result) {
            $this->response(array('success' => 1, 'menu' => $result ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('success' => 0, 'message' => 'Data Not Foud'), REST_Controller::HTTP_NOT_FOUND);
        }
    }



}
?>