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
     * Get the post categories
     *
     * @return Fire\Foundation\Collection
     */
    public function categories()
    {
        return $this->lazyLoad($this->categories);
    }

    /**
     * Set the post categories
     *
     * @param Fire\Foundation\Collection|Closure  $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the post tags
     *
     * @return Fire\Foundation\Collection
     */
    public function tags()
    {
        return $this->lazyLoad($this->tags);
    }

    /**
     * Set the post tags
     *
     * @param Fire\Foundation\Collection|Closure  $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
}
