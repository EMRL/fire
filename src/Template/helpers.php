<?php

if ( ! function_exists('template')) {
    /**
     * Render a template
     * @param  string  $key
     * @param  string  $suffix
     * @param  array   $data
     * @return string
     */
    function template($key, $suffix = null, $data = [])
    {
        return fire('template')->render($key, $suffix, $data);
    }
}

if ( ! function_exists('partial')) {
    /**
     * Render a template partial
     * @param  string  $key
     * @param  string  $suffix
     * @param  array   $data
     * @return string
     */
    function partial($key, $suffix = null, $data = [])
    {
        return fire('template')->partial($key, $suffix, $data);
    }
}

if ( ! function_exists('content')) {
    /**
     * Returns the template for the current request
     *
     * @return string
     */
    function content()
    {
        return fire('template.layout')->content();
    }
}

if ( ! function_exists('head')) {
    /**
     * Wrapper for `wp_head`
     *
     * @return string
     */
    function head()
    {
        ob_start();
        wp_head();
        return ob_get_clean();
    }
}

if ( ! function_exists('foot')) {
    /**
     * Wrapper for `wp_footer`
     *
     * @return string
     */
    function foot()
    {
        ob_start();
        wp_footer();
        return ob_get_clean();
    }
}

if ( ! function_exists('documentTitle')) {
    /**
     * Wrapper for `wp_title`
     * @param  string   $sep
     * @param  boolean  $display
     * @param  string   $seplocation
     * @return string
     */
    function documentTitle($sep = null, $display = false, $seplocation = null)
    {
        return wp_title($sep, $display, $seplocation);
    }
}

if ( ! function_exists('documentClass')) {
    /**
     * Wrapper for `body_class`
     *
     * @param  string  $extra
     * @return string
     */
    function documentClass($extra = null)
    {
        ob_start();
        body_class($extra);
        return ob_get_clean();
    }
}

if ( ! function_exists('menu')) {
    /**
     * Wrapper for `wp_nav_menu` with more sane defaults
     *
     * @param  array  $options
     * @return string
     */
    function menu($options = [])
    {
        $defaults = [
            'class'       => '', // Alias for menu_class
            'id'          => '', // Alias for menu_id
            'menu_class'  => '',
            'menu_id'     => '',
            'container'   => false,
            'fallback_cb' => false,
            'items_wrap'  => '<ul>%3$s</ul>',
            'echo'        => false,
        ];

        $args = array_merge($defaults, $options);

        if ($args['class']) {
            $args['menu_class'] = $args['class'];
            unset($args['class']);
        }

        if ($args['id']) {
            $args['menu_id'] = $args['id'];
            unset($args['id']);
        }

        if (($args['menu_class'] or $args['menu_id']) and ! isset($options['items_wrap'])) {
            if ($args['menu_class'] and $args['menu_id']) {
                $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
            } elseif ($args['menu_class']) {
                $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
            } else {
                $args['items_wrap'] = '<ul id="%1$s">%3$s</ul>';
            }
        }

        return wp_nav_menu($args);
    }
}

if ( ! function_exists('menuAtLocation')) {
    /**
     * Get the menu for a location
     *
     * @param  string  $location
     * @param  array   $options
     * @return string
     */
    function menuAtLocation($location, $options = [])
    {
        $options['menu_location'] = $location;

        return menu($options);
    }
}

if ( ! function_exists('menuItems')) {
    /**
     * Get just the menu items without any wrapper elements
     *
     * @param  array  $options
     * @return string
     */
    function menuItems($options = [])
    {
        $options['items_wrap'] = '%3$s';

        return menu($options);
    }
}

if ( ! function_exists('menuItemsAtLocation')) {
    /**
     * Get just the menu items from a location without any wrapper elements
     * @param  string  $location
     * @param  array   $options
     * @return string
     */
    function menuItemsAtLocation($location, $options = [])
    {
        $options['menu_location'] = $location;

        return menuItems($options);
    }
}

if ( ! function_exists('menuObject'))
{
    /**
     * Get the menu object
     *
     * @param  integer|string  $id
     * @return string
     */
    function menuObject($id)
    {
        return wp_get_nav_menu_object($id);
    }
}

if ( ! function_exists('menuObjectAtLocation')) {
    /**
     * Get the menu object for a location
     *
     * @param  string  $location
     * @return stdClass
     */
    function menuObjectAtLocation($location)
    {
        $menus         = wp_get_nav_menus();
        $locations     = get_registered_nav_menus();
        $menuLocations = get_nav_menu_locations();

        if (isset($menuLocations[$location])) {
            foreach ($menus as $menu) {
                if ((int) $menu->term_id === (int) $menuLocations[$location]) {
                    return wp_get_nav_menu_object($menu->term_id);
                }
            }
        }

        return false;
    }
}
