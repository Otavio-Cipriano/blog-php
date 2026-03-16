<?php

namespace App\Domain\Models;

class Post
{
    public protected(set) ?int $id;
    public protected(set) string $title;
    public protected(set) ?string $content;
    public protected(set) ?string $slug;
    public protected(set) ?string $publishedAt;
    public protected(set) ?string $updatedAt;

    /**
     * @param int|null $id
     * @param string $title
     * @param ?string $content
     * @param ?string $slug
     * @param ?string $publishedAt
     * @param string|null $updatedAt
     */
    public function __construct(?int $id, string $title, ?string $content, ?string $slug, ?string $publishedAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->slug = $slug;
        $this->publishedAt = $publishedAt;
        $this->updatedAt = $updatedAt;
    }

    public static function getPosts(array $array): array
    {
        return array_map(function ($post) {
            return new Post($post['id'],
                $post['title'],
                $post['content']?? null,
                $post['slug']?? null,
                $post['published_at'],
                $post['updated_at']?? null);
        }, $array);
    }

    public static function generateSlug(string $title): string
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
        $slug = strtolower($title);
        //Pega tudo que não seja alfanumerico e troca por -
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
        return trim($slug, '-');
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => $this->publishedAt,
            'updated_at' => $this->updatedAt
            ];
    }

}