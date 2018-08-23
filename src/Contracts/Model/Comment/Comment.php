<?php

namespace Fire\Contracts\Model\Comment;

interface Comment
{
    /**
     * Get the comment ID
     *
     * @return integer
     */
    public function id();

    /**
     * Set the comment ID
     *
     * @param integer $id
     */
    public function setId($id);

    /**
     * Get the comment post ID
     *
     * @return integer
     */
    public function postId();

    /**
     * Set the comment post ID
     *
     * @param integer $id
     */
    public function setPostId($id);

    /**
     * Get the comment post
     *
     * @return Fire\Contracts\Model\AbstractPost\AbstractPost
     */
    public function post();

    /**
     * Set the comment post
     *
     * @param Fire\Contracts\Model\AbstractPost\AbstractPost|Closure $post
     */
    public function setPost($post);

    /**
     * Get the author name
     *
     * @return string
     */
    public function authorName();

    /**
     * Set the author name
     *
     * @param string $name
     */
    public function setAuthorName($name);

    /**
     * Get the author email
     *
     * @return string
     */
    public function authorEmail();

    /**
     * Set the author email
     *
     * @param string $email
     */
    public function setAuthorEmail($email);

    /**
     * Get the author URL
     *
     * @return string
     */
    public function authorUrl();

    /**
     * Set the author URL
     *
     * @param string $url
     */
    public function setAuthorUrl($url);

    /**
     * Get the author IP address
     *
     * @return string
     */
    public function authorIp();

    /**
     * Set the author IP address
     *
     * @param string $ip
     */
    public function setAuthorIp($ip);

    /**
     * Get the comment date
     *
     * @return string
     */
    public function date();

    /**
     * Set the comment date
     *
     * @param string $date
     */
    public function setDate($date);

    /**
     * Get the comment content
     *
     * @return string
     */
    public function content();

    /**
     * Set the comment content
     *
     * @param string $content
     */
    public function setContent($content);

    /**
     * Get comment status
     *
     * @return integer|string
     */
    public function status();

    /**
     * Set comment status
     *
     * @param integer|string $status
     */
    public function setStatus($status);

    /**
     * Get the comment user agent
     *
     * @return string
     */
    public function userAgent();

    /**
     * Set the comment user agent
     *
     * @param string $agent
     */
    public function setUserAgent($agent);

    /**
     * Get the comment type
     *
     * @return string
     */
    public function type();

    /**
     * Set the comment type
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Get the parent ID
     *
     * @return integer
     */
    public function parentId();

    /**
     * Set the parent ID
     *
     * @param integer $id
     */
    public function setParentId($id);

    /**
     * Get the parent
     *
     * @return Fire\Contracts\Model\Comment\Comment
     */
    public function parent();

    /**
     * Set the parent
     *
     * @param Fire\Contracts\Model\Comment\Comment|Closure $parent
     */
    public function setParent($parent);

    /**
     * Get the registered user ID, if applicable
     *
     * @return integer
     */
    public function userId();

    /**
     * Set the registered user ID
     *
     * @param integer $id
     */
    public function setUserId($id);

    /**
     * Get the registered user, if applicable
     *
     * @return Fire\Contracts\Model\User\User
     */
    public function user();

    /**
     * Set the registered user
     *
     * @param Fire\Contracts\Model\User\User|Closure $user
     */
    public function setUser($user);
}
