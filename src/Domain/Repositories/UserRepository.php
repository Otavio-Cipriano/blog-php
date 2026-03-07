<?php

namespace App\Domain\Repositories;

use App\Database\Connection;
use App\Domain\Models\User;
use PDO;

class UserRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function fetchOneByUsername(string $username): ?User
    {
        try {
            $stmt =$this->pdo->prepare('select * from users where username = :username');
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$user) return null;
            return new User($user['id'], $user['username'], $user['password']);
        }catch (\PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }
}