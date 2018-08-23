<?php

namespace Fire\Contracts\Model\Comment;

interface CommentRepository
{
    /**
     * Return a comment of the specified ID
     *
     * @param integer $id
     * @return Fire\Contracts\Model\Comment\Comment
     */
    public function commentOfId($id);

    /**
     * Return a collection of comments
     *
     * @param Fire\Contracts\Foundation\Arrayable|array|null $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = []);
}
