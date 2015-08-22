<?php

namespace Fire\Contracts\Model\User;

interface User
{
    /**
     * Get the user's ID
     *
     * @return interger
     */
    public function id();

    /**
     * Get the user's username
     *
     * @return string
     */
    public function username();

    /**
     * Get the user's email address
     *
     * @return string
     */
    public function email();

    /**
     * Get the user's website URL
     *
     * @return string
     */
    public function url();

    /**
     * Get the user's first name
     *
     * @return string
     */
    public function firstName();

    /**
     * Get the user's last name
     *
     * @return string
     */
    public function lastName();

    /**
     * Get the user's full name
     *
     * @return string
     */
    public function fullName();

    /**
     * Get the user's nickname
     *
     * @return string
     */
    public function nickname();

    /**
     * Get the user's display name
     *
     * @return string
     */
    public function displayName();
}
