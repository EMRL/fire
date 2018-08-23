<?php

namespace Fire\Model\AbstractPost;

use Closure;

abstract class AbstractPostPostType
{
    /**
     * Post type
     *
     * @var string
     */
    const TYPE = '';

    /**
     * Flag to set whether this is a custom or built-in post type
     *
     * @var boolean
     */
    const BUILTIN = false;

    /**
     * @var stdClass
     */
    protected $config;

    /**
     * Get the post type configuration
     *
     * @return stdClass
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * Register the post type
     *
     * @param array|callable $config
     * @return $this
     */
    protected function register($config)
    {
        add_action('init', function () use ($config) {
            if (is_callable($config)) {
                $config = call_user_func($config);
            }

            if (static::BUILTIN) {
                $this->registerBuiltin($config);
                return $this;
            }

            $singular = ucfirst(static::TYPE);
            $plural = $singular.'s';

            if (isset($config['labels'])) {
                $singular = isset($config['labels']['singular_name'])
                          ? $config['labels']['singular_name']
                          : $singular;

                $plural = isset($config['labels']['name'])
                        ? $config['labels']['name']
                        : $plural;
            }

            $defaults = [
                'labels' => [
                    'name' => _x($plural, static::TYPE.' general name'),
                    'singular_name' => _x($singular, static::TYPE.' singular name'),
                    'add_new_item' => __(sprintf('Add New %s', $singular), 'fire'),
                    'edit_item' => __(sprintf('Edit %s', $singular), 'fire'),
                    'new_item' => __(sprintf('New %s', $singular), 'fire'),
                    'view_item' => __(sprintf('View %s', $singular), 'fire'),
                    'search_items' => __(sprintf('Search %s', $plural), 'fire'),
                    'not_found' => __(sprintf('No %s found', strtolower($plural)), 'fire'),
                    'not_found_in_trash' => __(sprintf('No %s found in Trash', strtolower($plural)), 'fire'),
                    'parent_item_colon' => __(sprintf('Parent %s', $singular), 'fire'),
                ],
            ];

            $config = array_replace_recursive($defaults, $config);
            $config = apply_filters('fire/postType/config', $config, static::TYPE);
            $config = apply_filters(sprintf('fire/postType/%s/config', static::TYPE), $config);
            $this->config = register_post_type(static::TYPE, $config);
        });

        return $this;
    }

    /**
     * Set the title placeholder on post edit screen
     *
     * @param string $placeholder
     */
    protected function setTitlePlaceholder($placeholder)
    {
        add_filter('enter_title_here', function ($title, $post) use ($placeholder) {
            if ($post->post_type === static::TYPE) {
                $title = $placeholder;
            }

            return $title;
        }, null, 2);
    }

    /**
     * Modify the list table column headings
     *
     * Callback gets passed column array:
     *
     *     $callback(array(
     *         [column-key] => Heading Text
     *     ));
     *
     * @param callable $callback
     */
    protected function modifyColumnHeadings(callable $callback)
    {
        add_filter(sprintf('manage_%s_posts_columns', static::TYPE), $callback);
    }

    /**
     * Modify the list table sortable columns
     *
     * Callback gets passed numeric column array
     *
     *     $callback(array(
     *         [0] => 'column-key'
     *     ))
     *
     * @param callable $callback
     */
    protected function modifySortableColumns(callable $callback)
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TYPE), $callback);
    }

    /**
     * Modify the list table column content
     *
     * Callback gets passed column key and post ID
     *
     *     $callback(column-key, 12);
     *
     * @param callable $callback
     */
    protected function modifyColumns(callable $callback)
    {
        add_action(sprintf('manage_%s_posts_custom_column', static::TYPE), $callback, null, 2);
    }

    /**
     * Modify the WordPress query for this post type
     *
     * Callback gets passed the `WP_Query` object
     *
     *     $callback($wp_query);
     *
     * @param callable $callback
     */
    protected function modifyQuery(callable $callback)
    {
        add_action('pre_get_posts', function ($query) use ($callback) {
            if ($query->is_main_query() && $query->get('post_type') === static::TYPE) {
                $callback($query);
            }
        });
    }

    /**
     * Modify the post type link
     *
     * Callback gets passed the default URL and the post object
     *
     *    $callback($url, $post);
     *
     * @param callable $callback
     */
    protected function modifyPostUrl(callable $callback)
    {
        add_filter('post_type_link', function ($url, $post) use ($callback) {
            if ($post->post_type === static::TYPE) {
                $url = $callback($url, $post);
            }

            return $url;
        }, 10, 2);
    }

    /**
     * Modify the post type archive title
     *
     * If string is passed, it will set the archive title.
     * If a callable is passed, it gets passed the default title and the post type string
     *
     *    $callback($title, $type);
     *
     * @param mixed $value
     */
    protected function modifyArchiveTitle($value)
    {
        add_filter('post_type_archive_title', function ($title, $type) use ($value) {
            if ($type === static::TYPE) {
                $title = is_callable($value) ? $value($title, $type) : $value;
            }

            return $title;
        }, 10, 2);
    }

    /**
     * "Register" a built-in post type, this just adds our config to the default
     * already registered config
     *
     * @param array $config
     */
    protected function registerBuiltin($config)
    {
        global $wp_post_types;

        if ( ! isset($wp_post_types[static::TYPE])) {
            return;
        }

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $wp_post_types[static::TYPE]->$key->$k = $v;
                }
            } else {
                $wp_post_types[static::TYPE]->$key = $value;
            }
        }

        $this->config = $wp_post_types[static::TYPE];
    }
}
