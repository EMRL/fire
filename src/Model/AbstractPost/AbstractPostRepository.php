<?php

namespace Fire\Model\AbstractPost;

use Fire\Model\Repository;
use Fire\Foundation\Collection;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\AbstractPost\AbstractPost as AbstractPostContract;

class AbstractPostRepository extends Repository
{
    /**
     * @var string
     */
    protected $postType;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    protected $currentPost;

    /**
     * @var Fire\Foundation\Collection
     */
    protected $currentPosts;

    /**
     * @param string $postType
     */
    public function __construct($postType)
    {
        $this->postType = $postType;
    }

    /**
     * Return a post for the specified ID
     *
     * @param integer $id
     * @return Fire\Contracts\AbstractPost\AbstractPost
     */
    public function postOfId($id)
    {
        $post = get_post($id, ARRAY_A);

        if ($post && $post['post_type'] === $this->postType) {
            $post = $this->mapData($post);
        } else {
            $post = null;
        }

        return $post;
    }

    /**
     * Return a post for the specified slug
     *
     * @param string $slug
     * @return Fire\Contracts\AbstractPost\AbstractPost
     */
    public function postOfSlug($slug)
    {
        $post = get_page_by_path($slug, ARRAY_A, $this->postType);

        if ($post) {
            $post = $this->mapData($post);
        }

        return $post;
    }

    /**
     * Return a collection of posts
     *
     * @param Fire\Contracts\Foundation\Arrayable|array|null $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null)
    {
        if (is_null($args) || is_array($args)) {
            $defaults = $this->newParams();
            $defaults = ($defaults instanceof Arrayable) ? $defaults->toArray() : $defaults;
            $args = is_array($args) ? array_replace_recursive($defaults, $args) : $defaults;
        }

        $args = ($args instanceof Arrayable) ? $args->toArray() : $args;

        $posts = new Collection;

        foreach (get_posts($args) as $post) {
            $posts->push($this->postOfId($post->ID));
        }

        return $posts;
    }

    /**
     * Get a post older than the given date
     *
     * @param string|integer $date
     * @return Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    public function postOlderThan($date)
    {
        $args = $this->newParams()->add([
            'posts_per_page' => 1,

            'date_query' => [
                [
                    'before' => $date,
                    'inclusive' => false,
                ],
            ],
        ]);

        return $this->find($args)->first();
    }

    /**
     * Get a post newer than the given date
     *
     * @param string|integer $date
     * @return Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    public function postNewerThan($date)
    {
        $args = $this->newParams()->add([
            'posts_per_page' => 1,
            'order' => 'asc',

            'date_query' => [
                [
                    'after' => $date,
                    'inclusive' => false,
                ],
            ],
        ]);

        return $this->find($args)->first();
    }

    /**
     * Get posts by author or authors
     *
     * @param integer|array $id
     * @return Fire\Foundation\Collection
     */
    public function postsByAuthor($id)
    {
        $args = $this->newParams()->byAuthor($id);
        return $this->find($args);
    }

    /**
     * @return Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    public function currentPost()
    {
        return $this->currentPost;
    }

    /**
     * @param Fire\Contracts\Model\AbstractPost\AbstractPost $post
     */
    public function setCurrentPost(AbstractPostContract $post)
    {
        $this->currentPost = $post;
    }

    /**
     * @return Fire\Foundation\Collection
     */
    public function currentPosts()
    {
        return $this->currentPosts;
    }

    /**
     * @param Fire\Foundation\Collection $posts
     */
    public function setCurrentPosts($posts)
    {
        $this->currentPosts = $posts;
    }

    /**
     * Return a new params object
     *
     * @return Fire\Contracts\Foundation\Arrayable
     */
    public function newParams()
    {
        return new AbstractPostParams($this->postType);
    }

    /**
     * @param string $type
     */
    public function setPostType($type)
    {
        $this->postType = $type;
    }
}
