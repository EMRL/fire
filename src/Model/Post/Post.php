<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPost;
use Fire\Contracts\Model\Post\Post as PostContract;

class Post extends AbstractPost implements PostContract
{
    protected $categories;

    protected $tags;

    public function categories()
    {
        return $this->lazyLoad($this->categories);
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function tags()
    {
        return $this->lazyLoad($this->tags);
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }
}
