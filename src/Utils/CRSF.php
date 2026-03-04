<?php

namespace App\Utils;

class CRSF
{
    public static function createToken()
    {
        $token = md5(time());
        session_start();
        $_SESSION['token'] = $token;

        return "<input name='token' value='$token' type='hidden'/>";
    }

    public static function validateToken($token)
    {
        return isset($_SESSION['token']) && $_SESSION['token'] == $token;
    }
}