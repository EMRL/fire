<?php

namespace Fire\Model\Comment;

use Fire\Foundation\Params;

class CommentParams extends Params
{
    /**
     * Set param for comments for posts
     *
     * @param  integer|array  $id
     * @return $this
     */
    public function forPost($id)
    {
        return $this->add([
            'post__in' => (array) $id,
        ]);
    }

    /**
     * Set param for comments by user
     *
     * @param  integer|array  $id
     * @return $this
     */
    public function byUser($id)
    {
        return $this->add([
            'author__in' => (array) $id,
        ]);
    }
}
