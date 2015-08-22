<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPost;
use Fire\Contracts\Model\Post\Post as PostContract;

class Post extends AbstractPost implements PostContract
{
    /**
     * @var Fire\Foundation\Collection
     */
    protected $categories;

    /**
     * @var Fire\Foundation\Collection
     */
    protected $tags;

    /**
     * Get the post's categories
     *
     * @return Fire\Foundation\Collection
     */
    public function categories()
    {
        return $this->lazyLoad($this->categories);
    }

    /**
     * Set the post's categories
     *
     * @param Fire\Foundation\Collection|Closure  $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the post's tags
     *
     * @return Fire\Foundation\Collection
     */
    public function tags()
    {
        return $this->lazyLoad($this->tags);
    }

    /**
     * Set the post's tags
     *
     * @param Fire\Foundation\Collection|Closure  $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
}
