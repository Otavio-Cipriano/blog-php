<?php

namespace App\Middlewares;

class Auth
{
    public static function checkUser(): void
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $user = $_SESSION['user']?? [];
        if(empty($user)){
            header('Location: /login');
            exit();
        }
    }
}