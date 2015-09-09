<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPostRepository;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class PostRepository extends AbstractPostRepository implements PostRepositoryContract
{
    protected $entityClass = 'Fire\Model\Post\Post';

    /**
     * Get posts in category or categories
     *
     * @param  integer|array  $id
     * @return Fire\Foundation\Collection
     */
    public function postsInCategory($id)
    {
        $args = $this->newParams()->inCategory($id);

        return $this->find($args);
    }

    /**
     * Get posts tagged with this ID or IDs
     *
     * @param  integer|array  $id
     * @return Fire\Foundation\Collection
     */
    public function postsTagged($id)
    {
        $args = $this->newParams()->tagged($id);

        return $this->find($args);
    }

    public function newParams()
    {
        return new PostParams($this->postType);
    }
}
