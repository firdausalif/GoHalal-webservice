<?php

/**
 * Created by PhpStorm.
 * User: reysd
 * Date: 5/27/2017
 * Time: 3:48 PM
 */
class Token
{
    public static function generateToken() {
        $token = hash_hmac('sha256', microtime(), uniqid());
        return $token;
    }

}