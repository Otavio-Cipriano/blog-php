<?php

namespace App\Controllers;

class AuthController
{
    public static function auth()
    {
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location: /login');
            exit();
        }

        include __DIR__ . '/../Pages/admin.php';
    }

    public static function login()
    {
        session_start();
        if(isset($_SESSION['user'])){
           header('Location: /admin');
           exit();
        }

        include __DIR__ . '/../Pages/login.php';
    }

    public static function loginPost()
    {
        session_start();
        $errors = $_SESSION['errors'] ?? [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

            if(!$username){
                $errors['username'] = 'Username Inválido!';
            }
            if(!$password){
                $errors['password'] = 'Password Inválida!';
            }

            if(empty($errors)){
                
            }

            //Check if user exists
            //Check if password is right
        }
    }
}