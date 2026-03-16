<?php

namespace App\Middlewares;

class Auth
{
    public static function checkUser(): void
    {
        session_start();
        $user = $_SESSION['user']?? [];
        if(empty($user)){
            header('Location: /login');
            exit();
        }
    }
}