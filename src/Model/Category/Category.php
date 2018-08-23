<?php

namespace Fire\Model\Category;

use Fire\Model\Term\Term;
use Fire\Contracts\Model\Category\Category as CategoryContract;

class Category extends Term implements CategoryContract
{
    /**
     * @var Fire\Foundation\Collection
     */
    protected $posts;

    /**
     * Get posts
     *
     * @return Fire\Foundation\Collection
     */
    public function posts()
    {
        return $this->lazyLoad($this->posts);
    }

    /**
     * Set posts
     *
     * @param Fire\Foundation\Collection|Closure $posts
     * @return void
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
}
