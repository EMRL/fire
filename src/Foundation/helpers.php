<?php

use Fire\Container\Container;

if ( ! function_exists('add_hooks')) {
    /**
     * Add function to multiple hooks at once
     *
     * @param string $hooks
     * @param callable $callback
     * @param integer $priority
     * @param integer $accepted_args
     * @param string $type
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

if ( ! function_exists('add_actions')) {
    /**
     * Add function to multiple actions at once
     *
     * @param string $actions
     * @param callable $callback
     * @param integer $priority
     * @param integer $accepted_args
     */
    function add_actions($actions, $callback, $priority = NULL, $accepted_args = 1)
    {
        add_hooks($actions, $callback, $priority, $accepted_args, 'action');
    }
}

if ( ! function_exists('add_filters')) {
    /**
     * Add function to multiple filters at once
     *
     * @param string $filters
     * @param callable $callback
     * @param integer $priority
     * @param integer $accepted_args
     */
    function add_filters($filters, $callback, $priority = NULL, $accepted_args = 1)
    {
        add_hooks($filters, $callback, $priority, $accepted_args, 'filter');
    }
}

if ( ! function_exists('fire')) {
    /**
     * Return instance of Fire
     *
     * @param string $make
     * @param array $parameters
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

if ( ! function_exists('current_url')) {
    /**
     * Return the full current URL
     *
     * @return string
     */
    function current_url()
    {
        global $wp;
        return esc_url(add_query_arg($_GET, home_url($wp->request)));
    }
}

if ( ! function_exists('currentUrl')) {
    /**
     * Return the full current URL
     *
     * @deprecated 2.3.0 Use `current_url` instead
     * @return string
     */
    function currentUrl()
    {
        return current_url();
    }
}

if ( ! function_exists('url')) {
    /**
     * Return a WordPress URL
     *
     * @param string $path
     * @return string
     */
    function url($path = null)
    {
        return home_url($path);
    }
}

if ( ! function_exists('option')) {
    /**
     * Get the value of an ACF option
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    function option($key, $default = null)
    {
        $value = null;

        if (function_exists('get_field')) {
            $value = get_field($key, 'option');
        }

        if (is_null($value) || $value === false || $value === '') {
            $value = get_option($key, $default);
        }

        return $value;
    }
}

if ( ! function_exists('site')) {
    /**
     * Get website info
     *
     * @param string $key
     * @param string $filter
     * @return mixed
     */
    function site($key, $filter = null)
    {
        return get_bloginfo($key, $filter);
    }
}

if ( ! function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if ( ! function_exists('d')) {
    /**
     * Debug variables
     *
     * @param mixed ...$args
     */
    function d()
    {
        array_map(function($x) { echo '<pre>'.print_r($x, true).'</pre>'; }, func_get_args());
    }
}

if ( ! function_exists('dd')) {
    /**
     * Debug variables and then die
     *
     * @param mixed ...$args
     */
    function dd()
    {
        array_map(function($x) { echo '<pre>'.print_r($x, true).'</pre>'; }, func_get_args()); die;
    }
}

if ( ! function_exists('dump')) {
    /**
     * var_dump variables
     *
     * @param mixed ...$args
     */
    function dump()
    {
        array_map(function($x) { echo '<pre>'; var_dump($x); echo '</pre>'; }, func_get_args()); die;
    }
}
