<?php

if ( ! function_exists('content'))
{
    function content()
    {
        return fire('template.layout')->content();
    }
}

if ( ! function_exists('head'))
{
    function head()
    {
        ob_start();
        wp_head();
        return ob_get_clean();
    }
}

if ( ! function_exists('foot'))
{
    function foot()
    {
        ob_start();
        wp_footer();
        return ob_get_clean();
    }
}

if ( ! function_exists('documentTitle'))
{
    function documentTitle($sep = null, $display = false, $seplocation = null)
    {
        return wp_title($sep, $display, $seplocation);
    }
}

if ( ! function_exists('documentClass'))
{
    function documentClass($extra = null)
    {
        ob_start();
        body_class($extra);
        return ob_get_clean();
    }
}

if ( ! function_exists('menu'))
{
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

if ( ! function_exists('menuAtLocation'))
{
    function menuAtLocation($location, $options = [])
    {
        $options['menu_location'] = $location;

        return menu($options);
    }
}

if ( ! function_exists('menuItems'))
{
    function menuItems($options = [])
    {
        $options['items_wrap'] = '%3$s';

        return menu($options);
    }
}

if ( ! function_exists('menuItemsAtLocation'))
{
    function menuItemsAtLocation($location, $options = [])
    {
        $options['menu_location'] = $location;

        return menuItems($options);
    }
}

if ( ! function_exists('menuObjectAtLocation'))
{
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
