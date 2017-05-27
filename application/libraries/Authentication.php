<?php

/**
 * Created by PhpStorm.
 * User: reysd
 * Date: 5/26/2017
 * Time: 9:22 PM
 */
class Authentication
{

    public static $CI;

    function __construct()
    {
        self::$CI =& get_instance();
        self::$CI->load->model('User');
    }

    public static  function tokenAuth($token) {
        $decoded = JWT::decode($token, self::$CI->config->item('jwt_key'));
        if($decoded != false) {
            return $decoded;
        } else {
            return false;
        }
    }

    public static function stdAuth($username,$pass) {
        return true;
    }

}