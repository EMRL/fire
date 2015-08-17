<?php

namespace Fire\Contracts\Model\User;

interface User
{
    public function id();

    public function username();

    public function email();

    public function url();

    public function firstName();

    public function lastName();

    public function fullName();

    public function nickname();

    public function displayName();
}
