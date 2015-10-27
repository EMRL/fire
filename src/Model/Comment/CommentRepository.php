<?php

namespace Fire\Model\Comment;

use Fire\Model\Repository;
use Fire\Foundation\Collection;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\Comment\CommentRepository as CommentRepositoryContract;

class CommentRepository extends Repository implements CommentRepositoryContract
{
    protected $entityClass = 'Fire\Model\Comment\Comment';

    public function commentOfId($id)
    {
        $comment = get_comment($id, ARRAY_A);

        if ($comment) {
            $comment = $this->mapData($comment);
        }

        return $comment;
    }

    /**
     * Return collection of comments for specific post
     *
     * @param  integer  $id
     * @return Fire\Foundation\Collection
     */
    public function commentsForPost($id)
    {
        $args = $this->newParams()->forPost($id);

        return $this->find($args);
    }

    /**
     * Return collection of comments for specific user
     *
     * @param  integer  $id
     * @return Fire\Foundation\Collection
     */
    public function commentsByUser($id)
    {
        $args = $this->newParams()->byUser($id);

        return $this->find($args);
    }

    public function find($args = null)
    {
        if (is_null($args) or is_array($args)) {
            $defaults = $this->newParams();
            $defaults = ($defaults instanceof Arrayable) ? $defaults->toArray() : $defaults;
            $args     = is_array($args) ? array_replace_recursive($defaults, $args) : $defaults;
        }

        $args = ($args instanceof Arrayable) ? $args->toArray() : $args;

        $comments = new Collection;

        foreach (get_comments($args) as $comment) {
            $comments->push($this->commentOfId($comment->comment_ID));
        }

        return $comments;
    }

    public function newParams()
    {
        return new CommentParams;
    }
}
