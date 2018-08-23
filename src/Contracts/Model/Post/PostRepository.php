<?php

namespace Fire\Contracts\Model\Post;

interface PostRepository
{
    /**
     * Return a post of the specified ID
     *
     * @param integer $id
     * @return Fire\Contracts\Post\Post
     */
    public function postOfId($id);

    /**
     * Return a post of the specified slug
     *
     * @param string $slug
     * @return Fire\Contracts\Post\Post
     */
    public function postOfSlug($slug);

    /**
     * Return a collection of posts
     *
     * @param Fire\Contracts\Foundation\Arrayable|array|null $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null);
}
