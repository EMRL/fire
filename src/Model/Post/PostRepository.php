<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPostRepository;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class PostRepository extends AbstractPostRepository implements PostRepositoryContract
{
    protected $entityClass = 'Fire\Model\Post\Post';

    public function postsInCategory($id)
    {
        $args = $this->newParams()->inCategory($id);

        return $this->find($args);
    }

    public function postsTagged($id)
    {
        $args = $this->newParams()->tagged($id);

        return $this->find($args);
    }

    protected function newParams()
    {
        return new PostParams($this->postType);
    }
}
