<?php

if ( ! function_exists('template')) {
    /**
     * Render a template
     *
     * @param string $key
     * @param string $suffix
     * @param array $data
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
     *
     * @param string $key
     * @param string $suffix
     * @param array $data
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

if ( ! function_exists('document_title')) {
    /**
     * Wrapper for `wp_title`
     *
     * @param string $sep
     * @param boolean $display
     * @param string $seplocation
     * @return string
     */
    function document_title($sep = null, $display = false, $seplocation = null)
    {
        return wp_title($sep, $display, $seplocation);
    }
}

if ( ! function_exists('documentTitle')) {
    /**
     * Wrapper for `wp_title`
     *
     * @deprecated 2.3.0 Use `document_title` instead
     * @param string $sep
     * @param boolean $display
     * @param string $seplocation
     * @return string
     */
    function documentTitle($sep = null, $display = false, $seplocation = null)
    {
        return document_title($sep, $display, $seplocation);
    }
}

if ( ! function_exists('document_class')) {
    /**
     * Wrapper for `body_class`
     *
     * @param string $extra
     * @return string
     */
    function document_class($extra = null)
    {
        ob_start();
        body_class($extra);
        return ob_get_clean();
    }
}

if ( ! function_exists('documentClass')) {
    /**
     * Wrapper for `body_class`
     *
     * @deprecated 2.3.0 Use `document_class` instead
     * @param string $extra
     * @return string
     */
    function documentClass($extra = null)
    {
        return document_class($extra);
    }
}

if ( ! function_exists('menu')) {
    /**
     * Wrapper for `wp_nav_menu` with more sane defaults
     *
     * @param array $options
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

        if (($args['menu_class'] || $args['menu_id']) && ! isset($options['items_wrap'])) {
            if ($args['menu_class'] && $args['menu_id']) {
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

if ( ! function_exists('menu_at_location')) {
    /**
     * Get the menu for a location
     *
     * @param string $location
     * @param array $options
     * @return string
     */
    function menu_at_location($location, $options = [])
    {
        $options['theme_location'] = $location;
        return menu($options);
    }
}

if ( ! function_exists('menuAtLocation')) {
    /**
     * Get the menu for a location
     *
     * @deprecated 2.3.0 Use `menu_at_location` instead
     * @param string $location
     * @param array  $options
     * @return string
     */
    function menuAtLocation($location, $options = [])
    {
        return menu_at_location($location, $options);
    }
}

if ( ! function_exists('menu_items')) {
    /**
     * Get just the menu items without any wrapper elements
     *
     * @param array $options
     * @return string
     */
    function menu_items($options = [])
    {
        $options['items_wrap'] = '%3$s';
        return menu($options);
    }
}

if ( ! function_exists('menuItems')) {
    /**
     * Get just the menu items without any wrapper elements
     *
     * @deprecated 2.3.0 Use `menu_items` instead
     * @param array $options
     * @return string
     */
    function menuItems($options = [])
    {
        return menu_items($options);
    }
}

if ( ! function_exists('menu_items_at_location')) {
    /**
     * Get just the menu items from a location without any wrapper elements
     *
     * @param string $location
     * @param array $options
     * @return string
     */
    function menu_items_at_location($location, $options = [])
    {
        $options['theme_location'] = $location;
        return menu_items($options);
    }
}

if ( ! function_exists('menuItemsAtLocation')) {
    /**
     * Get just the menu items from a location without any wrapper elements
     *
     * @deprecated 2.3.0 Use `menu_items_at_location` instead
     * @param string $location
     * @param array $options
     * @return string
     */
    function menuItemsAtLocation($location, $options = [])
    {
        return menu_items_at_location($location, $options);
    }
}

if ( ! function_exists('menu_object'))
{
    /**
     * Get the menu object
     *
     * @param integer|string $id
     * @return string
     */
    function menu_object($id)
    {
        return wp_get_nav_menu_object($id);
    }
}

if ( ! function_exists('menuObject'))
{
    /**
     * Get the menu object
     *
     * @deprecated 2.3.0 Use `menu_object` instead
     * @param integer|string $id
     * @return string
     */
    function menuObject($id)
    {
        return menu_object($id);
    }
}

if ( ! function_exists('menu_object_at_location')) {
    /**
     * Get the menu object for a location
     *
     * @param string $location
     * @return stdClass
     */
    function menu_object_at_location($location)
    {
        $menus = wp_get_nav_menus();
        $locations = get_registered_nav_menus();
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

if ( ! function_exists('menuObjectAtLocation')) {
    /**
     * Get the menu object for a location
     *
     * @deprecated 2.3.0 Use `menu_object_at_location` instead
     * @param string $location
     * @return stdClass
     */
    function menuObjectAtLocation($location)
    {
        return menu_object_at_location($location);
    }
}

if ( ! function_exists('limit_words'))
{
    /**
     * Limit a string to certain number of words
     *
     * @param string $str
     * @param integer $limit
     * @param string $end
     * @return string
     */
    function limit_words($str, $limit = 100, $end = null)
    {
        $limit = (int) $limit;
        $end = (is_null($end)) ? '…' : $end;

        if (trim($str) === '') {
            return $str;
        }

        if ($limit <= 0) {
            return $end;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $str, $matches);
        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end);
    }
}

if ( ! function_exists('limitWords'))
{
    /**
     * Limit a string to certain number of words
     *
     * @deprecated 2.3.0 Use `limit_words` instead
     * @param string $str
     * @param integer $limit
     * @param string $end
     * @return string
     */
    function limitWords($str, $limit = 100, $end = null)
    {
        return limit_words($str, $limit, $end);
    }
}

if ( ! function_exists('limit_chars'))
{
    /**
     * Limit a string to a certain number of characters, optionally only splitting at full words
     *
     * @param string $str
     * @param integer $limit
     * @param string $end
     * @param boolean $preserveWords
     * @return string
     */
    function limit_chars($str, $limit = 100, $end = null, $preserveWords = false)
    {
        $end = (is_null($end)) ? '…' : $end;

        $limit = (int) $limit;

        if (trim($str) === '' || strlen($str) <= $limit) {
            return $str;
        }

        if ($limit <= 0) {
            return $end;
        }

        if ($preserveWords === false) {
            return rtrim(substr($str, 0, $limit)).$end;
        }

        // Don't preserve words. The limit is considered the top limit.
        // No strings with a length longer than $limit should be returned.
        if ( ! preg_match('/^.{0,'.$limit.'}\s/us', $str, $matches)) {
            return $end;
        }

        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end);
    }
}

if ( ! function_exists('limitChars'))
{
    /**
     * Limit a string to a certain number of characters, optionally only splitting at full words
     *
     * @deprecated 2.3.0 Use `limit_chars` instead
     * @param string $str
     * @param integer $limit
     * @param string $end
     * @param boolean $preserveWords
     * @return string
     */
    function limitChars($str, $limit = 100, $end = null, $preserveWords = false)
    {
        return limit_chars($str, $limit, $end, $preserveWords);
    }
}
