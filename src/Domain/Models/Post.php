<?php

namespace App\Domain\Models;

class Post
{
    public protected(set) ?int $id;
    public protected(set) string $title;
    public protected(set) ?string $content;
    public protected(set) ?string $publishedAt;
    public protected(set) ?string $updatedAt;

    /**
     * @param int|null $id
     * @param string $title
     * @param ?string $content
     * @param string $publishedAt
     * @param string|null $updatedAt
     */
    public function __construct(?int $id, string $title, ?string $content, string $publishedAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->publishedAt = $publishedAt;
        $this->updatedAt = $updatedAt;
    }

    public static function getPosts(array $array): array
    {
        return array_map(function ($post) {
            return new Post($post['id'],
                $post['title'],
                $post['content']?? null,
                $post['published_at'],
                $post['updated_at']?? null);
        }, $array);
    }

}