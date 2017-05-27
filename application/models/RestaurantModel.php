<?php

/**
 * Created by PhpStorm.
 * User: reysd
 * Date: 5/27/2017
 * Time: 1:52 PM
 */
class RestaurantModel extends CI_Model
{

    protected $searchColumn = array('idresto', 'nama', 'deskripsi', 'price', 'rate', 'image', 'idkategori','idflags');

    public function getRestaurant($id = '') {
        $this->db->select('*');
        if(empty($id)) {
            $result = $this->db->get('restaurant');
        } else {
            $this->db->where('id', $id);
            $result = $this->db->get('restaurant');
        }
        return $result->result_array();
    }

    public function getClosestRestaurant($location='') {

    }


    public function getRestoMenu($idresto='') {
        if(!empty($idresto)) {
            $this->db->select('*');
            $this->db->where('idresto', $idresto);
            $result = $this->db->get('restaurant_menu');
            return $result->num_rows() > 0 ? $result->result_array() : false;
        } else {
            return false;
        }
    }


    public function getMenu($id = '') {
        $this->db->select('*');
        if(!empty($id)) {
            $this->db->where('id', $id);
            $result = $this->db->get('restaurant_menu');
        } else {
            $result = $this->db->get('restaurant_menu');
        }

        return $result->num_rows() > 0 ? $result->result_array() : false;
    }

    /**
     * @param string $filter : array of field name to be searched
     * @return array of data or false if empty
     */
    public function searchMenu($filter = '') {
        $search = '';
        if(!empty($filter)) {
            $this->db->select("*");
            foreach ($filter as $key => $values) {
                if(in_array(strtolower($key), $this->searchColumn)) {
                    if($key == 'price') {
                        $price = explode('-',$values);
                        if(count($price) == 2) {
                            $this->db->where('price >= ', $price[0]);
                            $this->db->where('price <= ', $price[1]);
                        } elseif (count($price == 1)) {
                            $this->db->where('price >= ', $price[0]);
                        }
                    } else {
                        $this->db->like($key, $values);
                    }

                }
            }

            $result = $this->db->get('restaurant_menu');
            return $result->num_rows() > 0 ? $result->result_array() : false;
        }

        return false;
    }
}