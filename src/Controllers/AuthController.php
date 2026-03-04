<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Utils\CRSF;

class AuthController
{

    private static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function login()
    {
        self::initSession();
        if (isset($_SESSION['user'])) {
            header('Location: /admin');
            exit();
        }

        $errors = $_SESSION['errors']?? [];
        unset($_SESSION['errors']);
        $csrf = CRSF::createToken();
        var_dump($errors);
        include __DIR__ . '/../Pages/login.php';
    }

    public static function authenticate()
    {
        self::initSession();
        $errors = $_SESSION['errors'] ?? [];
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$token || !CRSF::validateToken($token)){
            $errors['token'] = 'Token Inválido';
        }
        if (!$username) {
            $errors['username'] = 'Username Inválido!';
        }
        if (!$password) {
            $errors['password'] = 'Password Inválida!';
        }


        if (empty($errors)) {
            $userRepo = new UserRepository();
            $user = $userRepo->fetchOneByUsername($username);

            if ($user) {
                $errors['test'] = $user->verifyPassword($password);
                if($user->verifyPassword($password)){
                    $_SESSION['user'] = get_object_vars($user);
                    header('Location: /admin');
                    exit();
                }

                $errors['username'] = "Username ou Password incorretas";
                $errors['password'] = "Username ou Password incorretas";
            }
        }

        $_SESSION['errors'] = $errors;
        header('Location: /login');
        exit();
    }

    public static function logout()
    {
        self::initSession();
        if($_SESSION['user']){
            unset($_SESSION['user']);
            header('Location: /');
            exit();
        }
    }
}