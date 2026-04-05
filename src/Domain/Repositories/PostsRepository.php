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
            $stmt = $this->pdo->prepare('select id, title, slug, published_at from posts order by published_at desc limit :limit offset :offset');
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

    public function fetchOne(string $slug): Post|false
    {
        try {
            $stmt = $this->pdo->prepare('select * from posts where slug = :slug');
            $stmt->execute(['slug' => $slug]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Post(
                $post['id'],
                $post['title'],
                $post['content'],
                $post['slug'],
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
            $stmt = $this->pdo->prepare('insert into posts (title, content, slug) values (:title, :content, :slug)');
            $stmt->execute([
                'title' => $post->title,
                'content' => $post->content,
                'slug' => $post->slug
            ]);
            $id = $this->pdo->lastInsertId();
            return new Post($id, $post->title, $post->title, $post->slug, $post->publishedAt, $post->updatedAt);
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

    public function delete(string $slug)
    {
        try {
            $stmt = $this->pdo->prepare('delete from posts where slug = :slug');
            $stmt->execute(['slug' => $slug]);
            if ($stmt->rowCount() < 1){
                return false;
            }

            return true;

        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function checkIfExistsBySlug(string $slug): bool
    {
        try {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM posts WHERE slug = :slug');
            $stmt->execute(['slug' => $slug]);
            return $stmt->fetchColumn() > 0;

        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
}