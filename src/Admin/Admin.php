<?php

namespace Fire\Admin;

class Admin
{
    public function __construct()
    {
        remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
    }
}