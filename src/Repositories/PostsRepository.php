<?php

namespace App\Repositories;

use App\Database\Connection;
use PDO;
use App\Domain\Models\Post;

class PostsRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function fetchMany(int $limit = 10, int $offset = 0): ?array
    {
        try {
            $stmt = $this->pdo->prepare('select id, title, published_at from posts limit :limit offset :offset');
            $stmt->execute([
                'limit' => $limit,
                'offset' => $offset
            ]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return Post::getPosts($posts);
        }catch (\PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }

    public function getNumberPosts()
    {
        try {
            $stmt = $this->pdo->prepare('select count(*) from posts');
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch (\PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }

    public function fetchOne(int $id): Post|false
    {
        try {
            $stmt = $this->pdo->prepare('select * from posts where id = :id');
            $stmt->execute(['id' => $id]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Post($post['id'],
                        $post['title'],
                        $post['content'],
                        $post['published_at'],
                        $post['updated_at']);
        }catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

}