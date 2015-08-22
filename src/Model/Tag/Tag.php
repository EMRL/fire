<?php

namespace Fire\Model\Tag;

use Fire\Model\Term\Term;
use Fire\Contracts\Model\Tag\Tag as TagContract;

class Tag extends Term implements TagContract
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
     * @param  Fire\Foundation\Collection|Closure  $posts
     * @return void
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
}
