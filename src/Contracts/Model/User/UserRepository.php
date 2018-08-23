<?php

namespace Fire\Contracts\Model\User;

interface UserRepository
{
    /**
     * Return a user of the specified ID
     *
     * @param integer $id
     * @return Fire\Contracts\Model\User\User
     */
    public function userOfId($id);

    /**
     * Return a user of the specified username
     *
     * @param string $username
     * @return Fire\Contracts\Model\User\User
     */
    public function userOfUsername($username);

    /**
     * Return a user of the specified email address
     *
     * @param string $email
     * @return Fire\Contracts\Model\User\User
     */
    public function userOfEmail($email);

    /**
     * Return a collection of users
     *
     * @param Fire\Contracts\Foundation\Arrayable|array|null $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = []);
}
