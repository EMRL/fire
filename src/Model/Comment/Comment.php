<?php

namespace Fire\Model\Comment;

use Fire\Model\Entity;
use Fire\Contracts\Model\Comment\Comment as CommentContract;

class Comment extends Entity implements CommentContract
{
    protected $id;

    protected $postId;

    protected $post;

    protected $authorName;

    protected $authorEmail;

    protected $authorUrl;

    protected $authorIp;

    protected $date;

    protected $content;

    protected $status;

    protected $userAgent;

    protected $type;

    protected $parentId;

    protected $parent;

    protected $userId;

    protected $user;

    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function postId()
    {
        return $this->postId;
    }

    public function setPostId($id)
    {
        $this->postId = $id;
    }

    public function post()
    {
        return $this->lazyLoad($this->post);
    }

    public function setPost($post)
    {
        $this->post = $post;
    }

    public function authorName()
    {
        return $this->authorName;
    }

    public function setAuthorName($name)
    {
        $this->authorName = $name;
    }

    public function authorEmail()
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail($email)
    {
        $this->authorEmail = $email;
    }

    public function authorUrl()
    {
        return $this->authorUrl;
    }

    public function setAuthorUrl($url)
    {
        $this->authorUrl = $url;
    }

    public function authorIp()
    {
        return $this->authorIp;
    }

    public function setAuthorIp($ip)
    {
        $this->authorIp = $ip;
    }

    public function date($format = 'F j, Y')
    {
        if ( ! $format) {
            $date = $this->date;
        } else {
            $date = date($format, strtotime($this->date));
        }

        return $date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function content()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function status()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function userAgent()
    {
        return $this->userAgent;
    }

    public function setUserAgent($agent)
    {
        $this->userAgent = $agent;
    }

    public function type()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function parent()
    {
        return $this->lazyLoad($this->parent);
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function setUserId($id)
    {
        $this->userId = $id;
    }

    public function user()
    {
        return $this->lazyLoad($this->user);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Return the URL to the comment
     *
     * @return string
     */
    public function url()
    {
        return get_comment_link($this->id());
    }

    /**
     * Test if comment is approved
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->status() == 1;
    }

    /**
     * Test if comment is spam
     *
     * @return boolean
     */
    public function isSpam()
    {
        return $this->status() === 'spam';
    }

    /**
     * Test is comment is of a type or types
     * @param  string|array  $type
     * @return boolean
     */
    public function isType($type)
    {
        return in_array($this->type(), (array) $type);
    }
}
