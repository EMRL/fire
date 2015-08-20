<?php

namespace Fire\Contracts\Model\AbstractPost;

interface AbstractPost
{
    /**
     * Return the ID
     *
     * @return integer
     */
    public function id();

    /**
     * Set the ID
     *
     * @param string|integer $id
     */
    public function setId($id);

    /**
     * Get the author
     *
     * @return Fire\Contracts\Model\Identity\User
     */
    public function author();

    /**
     * Set the author
     *
     * @param Fire\Contracts\Model\Identity\User|Closure $user
     */
    public function setAuthor($user);

    /**
     * Get the formatted date
     *
     * @param  string  $format  http://php.net/date
     * @return string
     */
    public function date();

    /**
     * Set the date
     *
     * @param string  $date
     */
    public function setDate($date);

    /**
     * Get the content
     *
     * @return  string
     */
    public function content();

    /**
     * Set the content
     *
     * @param string  $content
     */
    public function setContent($content);

    /**
     * Get the title
     *
     * @return string
     */
    public function title();

    /**
     * Set the title
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Get the excerpt
     *
     * @return string
     */
    public function excerpt();

    /**
     * Set the excerpt
     *
     * @param string  $excerpt
     */
    public function setExcerpt($excerpt);

    /**
     * Get the status
     *
     * @return string
     */
    public function status();

    /**
     * Set the status
     *
     * @param string  $status
     */
    public function setStatus($status);

    /**
     * Get the password
     *
     * @return string
     */
    public function password();

    /**
     * Set the password
     *
     * @param string $password
     */
    public function setPassword($password);

    /**
     * Get the slug
     *
     * @return string
     */
    public function slug();

    /**
     * Set the slug
     *
     * @param string  $slug
     */
    public function setSlug($slug);

    /**
     * Get the parent post
     *
     * @return Fire\Contracts\Model\Post\Post
     */
    public function parent();

    /**
     * Set the parent post
     *
     * @param Fire\Contracts\Model\Post\Post|Closure  $parent
     */
    public function setParent($parent);

    /**
     * Get the type
     *
     * @return string
     */
    public function type();

    /**
     * Set the type
     *
     * @param string  $type
     */
    public function setType($type);
}
