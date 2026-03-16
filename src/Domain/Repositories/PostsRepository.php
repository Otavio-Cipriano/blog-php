<?php

namespace App\Domain\Repositories;

use App\Database\Connection;
use App\Domain\Models\Post;
use PDO;

class PostsRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function fetchMany(int $limit = 10, int $offset = 0, string $filter = 'recent'): ?array
    {
        try {
            $stmt = $this->pdo->prepare('select id, title, published_at from posts order by published_at desc limit :limit offset :offset');
            $stmt->execute([
                'limit' => $limit,
                'offset' => $offset
            ]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return Post::getPosts($posts);
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function create(Post $post): ?Post
    {
        try {
            $stmt = $this->pdo->prepare('insert into posts (title, content) values (:title, :content)');
            $stmt->execute([
                'title' => $post->title,
                'content' => $post->content
            ]);
            $id = $this->pdo->lastInsertId();
            return new Post($id, $post->title, $post->title, $post->publishedAt, $post->updatedAt);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function update(Post $post): bool
    {
        try {
            $stmt = $this->pdo->prepare('update posts set title = :title, content = :content where id = :id');
            $stmt->execute(
                [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content
                ]);
            if ($stmt->rowCount() < 1){
                return false;
            }

            return true;
        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

}