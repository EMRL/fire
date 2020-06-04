<?php

declare(strict_types=1);

class WP_Query
{
    protected static int $globalPost = -1;

    protected array $posts = [];

    protected int $count = 0;

    protected int $current = -1;

    public string $post;

    public function __construct(array $posts)
    {
        $this->posts = $posts;
        $this->count = count($posts);
    }

    public function have_posts(): bool
    {
        return $this->current + 1 < $this->count;
    }

    public function the_post(): void
    {
        ++$this->current;
        $this->post = $this->posts[$this->current];
        static::$globalPost = $this->current;
    }

    public function reset_postdata(): void
    {
        static::$globalPost = $this->current;
    }

    public function rewind_posts(): void
    {
        $this->current = -1;
        $this->post = $this->posts[0];
    }

    public function current(): int
    {
        return $this->current;
    }

    public static function globalPost(): int
    {
        return static::$globalPost;
    }

    public static function setGlobalPost(int $post): void
    {
        static::$globalPost = $post;
    }
}
