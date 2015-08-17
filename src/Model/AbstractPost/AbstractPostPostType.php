<?php

namespace Fire\Model\AbstractPost;

use Closure;

abstract class AbstractPostPostType
{
    const TYPE = '';

    const BUILTIN = false;

    protected $config;

    public function config()
    {
        return $this->config;
    }

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
            $plural   = $singular.'s';

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
                    'name'               => _x($plural, static::TYPE.' general name'),
                    'singular_name'      => _x($singular, static::TYPE.' singular name'),
                    'add_new_item'       => __(sprintf('Add New %s', $singular), 'fire'),
                    'edit_item'          => __(sprintf('Edit %s', $singular), 'fire'),
                    'new_item'           => __(sprintf('New %s', $singular), 'fire'),
                    'view_item'          => __(sprintf('View %s', $singular), 'fire'),
                    'search_items'       => __(sprintf('Search %s', $plural), 'fire'),
                    'not_found'          => __(sprintf('No %s found', strtolower($plural)), 'fire'),
                    'not_found_in_trash' => __(sprintf('No %s found in Trash', strtolower($plural)), 'fire'),
                    'parent_item_colon'  => __(sprintf('Parent %s', $singular), 'fire'),
                ],
            ];

            $config = array_replace_recursive($defaults, $config);
            $config = apply_filters('fire/postType/config', $config, static::TYPE);
            $config = apply_filters(sprintf('fire/postType/%s/config', static::TYPE), $config);

            $this->config = register_post_type(static::TYPE, $config);
        });

        return $this;
    }

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
     * Callback gets passed column array:
     *
     *     $callback(array(
     *         [column-key] => Heading Text
     *     ));
     */
    protected function modifyColumnHeadings(callable $callback)
    {
        add_filter(sprintf('manage_%s_posts_columns', static::TYPE), $callback);
    }

    /**
     * Callback gets passed numeric column array
     *
     *     $callback(array(
     *         [0] => 'column-key'
     *     ))
     */
    protected function modifySortableColumns(callable $callback)
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TYPE), $callback);
    }

    /**
     * Callback gets passed column key and post ID
     *
     *     $callback(column-key, 12);
     */
    protected function modifyColumns(callable $callback)
    {
        add_action(sprintf('manage_%s_posts_custom_column', static::TYPE), $callback, null, 2);
    }

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
