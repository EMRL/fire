<?php

namespace Fire\Model\User;

use WP_User;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\User\User as UserContract;

class User extends WP_User implements EntityContract, UserContract, Arrayable
{
    protected $posts;

    protected $pages;

    protected $comments;

    public function id()
    {
        return $this->ID;
    }

    public function username()
    {
        return $this->user_login;
    }

    public function email()
    {
        return $this->user_email;
    }

    public function url()
    {
        return $this->user_url;
    }

    public function firstName()
    {
        return $this->first_name;
    }

    public function lastName()
    {
        return $this->last_name;
    }

    public function fullName()
    {
        return $this->firstName().' '.$this->lastName();
    }

    public function nickname()
    {
        return $this->nickname;
    }

    public function displayName()
    {
        return $this->display_name;
    }

    /**
     * Return posts belonging to user
     *
     * @return Fire\Foundation\Collection
     */
    public function posts()
    {
        return $this->lazyLoad($this->posts);
    }

    /**
     * Set posts belonging to user
     *
     * @param Fire\Foundation\Collection|Closure  $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Return pages belonging to user
     *
     * @return Fire\Foundation\Collection
     */
    public function pages()
    {
        return $this->lazyLoad($this->pages);
    }

    /**
     * Set pages belonging to user
     *
     * @param Fire\Foundation\Collection|Closure  $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Return comments belonging to user
     *
     * @return Fire\Foundation\Collection
     */
    public function comments()
    {
        return $this->lazyLoad($this->comments);
    }

    /**
     * Set comments belonging to user
     *
     * @param Fire\Foundation\Collection|Closure  $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get the URL of the author page
     *
     * @return string
     */
    public function pageUrl()
    {
        return get_author_posts_url($this->id());
    }

    /**
     * Alias to_array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->to_array();
    }

    /**
     * Resolve a value from a Closure
     *
     * @param  mixed  $property
     * @return mixed
     */
    protected function lazyLoad(& $property)
    {
        if ($property instanceof Closure) {
            return $this->$property = $property();
        }

        return $property;
    }
}
