<?php

use Fire\Container\Container;

if ( ! function_exists('add_hooks'))
{
    /**
     * Add function to multiple hooks at once
     * @param string    $hooks
     * @param callable  $callback
     * @param integer   $priority
     * @param integer   $accepted_args
     * @param string    $type
     */
    function add_hooks($hooks, $callback, $priority, $accepted_args, $type = 'filter')
    {
        $function = "add_$type";

        if ( ! is_array($hooks)) {
            $hooks = array_map('trim', preg_split('/[,\s]+/', $hooks));
        }

        foreach ($hooks as $hook) {
            $function($hook, $callback, $priority, $accepted_args);
        }
    }
}

if ( ! function_exists('add_actions'))
{
    /**
     * Add function to multiple actions at once
     * @param string    $actions
     * @param callable  $callback
     * @param integer   $priority
     * @param integer   $accepted_args
     */
    function add_actions($actions, $callback, $priority = NULL, $accepted_args = 1)
    {
        add_hooks($actions, $callback, $priority, $accepted_args, 'action');
    }
}

if ( ! function_exists('add_filters'))
{
    /**
     * Add function to multiple filters at once
     * @param string    $filters
     * @param callable  $callback
     * @param integer   $priority
     * @param integer   $accepted_args
     */
    function add_filters($filters, $callback, $priority = NULL, $accepted_args = 1)
    {
        add_hooks($filters, $callback, $priority, $accepted_args, 'filter');
    }
}

if ( ! function_exists('fire'))
{
    /**
     * Return instance of Fire
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return mixed|\Fire\Foundation\Fire
     */
    function fire($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}

if ( ! function_exists('currentUrl'))
{
    /**
     * Return the full current URL
     *
     * @return string
     */
    function currentUrl()
    {
        global $wp;
        return esc_url(add_query_arg($_GET, home_url($wp->request)));
    }
}
