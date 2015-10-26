<?php

namespace Fire\Model\Term;

abstract class TermTaxonomy
{
    /**
     * Taxonomy name
     *
     * @var string
     */
    const NAME = '';

    /**
     * Flag to set whether this is a custom or built-in taxonomy
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
     * Register the taxonomy
     *
     * @param  string|array    $postTypes
     * @param  array|callable  $config
     * @return $this
     */
    protected function register($postTypes, $config)
    {
        add_action('init', function () use ($postTypes, $config) {
            global $wp_taxonomies;

            if (is_callable($config)) {
                $config = call_user_func($config);
            }

            if (static::BUILTIN) {
                $this->registerBuiltin($config);
                return $this;
            }

            $singular = ucfirst(static::NAME);
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
                    'name'                       => _x($plural, static::NAME.' general name'),
                    'singular_name'              => _x($singular, static::NAME.' singular name'),
                    'all_items'                  => __(sprintf('All %s', $plural), 'fire'),
                    'edit_item'                  => __(sprintf('Edit %s', $singular), 'fire'),
                    'view_item'                  => __(sprintf('View %s', $singular), 'fire'),
                    'update_item'                => __(sprintf('Update %s', $singular), 'fire'),
                    'add_new_item'               => __(sprintf('Add New %s', $singular), 'fire'),
                    'new_item_name'              => __(sprintf('New %s Name', $singular), 'fire'),
                    'parent_item'                => __(sprintf('Parent %s', $singular), 'fire'),
                    'parent_item_colon'          => __(sprintf('Parent %s:', $singular), 'fire'),
                    'search_items'               => __(sprintf('Search %s', $plural), 'fire'),
                    'popular_items'              => __(sprintf('Popular %s', $plural), 'fire'),
                    'separate_items_with_commas' => __(sprintf('Separate %s with commas', strtolower($plural)), 'fire'),
                    'add_or_remove_items'        => __(sprintf('Add or remove %s', strtolower($plural)), 'fire'),
                    'choose_from_most_used'      => __(sprintf('Choose from the most used %s', strtolower($plural)), 'fire'),
                    'not_found'                  => __(sprintf('No %s found', strtolower($plural)), 'fire'),
                ],
            ];

            $config = array_replace_recursive($defaults, $config);
            $config = apply_filters('fire/taxonomy/config', $config, static::NAME);
            $config = apply_filters(sprintf('fire/taxonomy/%s/config', static::NAME), $config);

            register_taxonomy(static::NAME, $postTypes, $config);

            $this->config = $wp_taxonomies[static::NAME];
        });

        return $this;
    }

    /**
     * Modify the list able column headings
     *
     * Callback gets passed column array:
     *
     *     $callback(array(
     *         [column-key] => Heading Text
     *     ));
     *
     * @param callable  $callback
     */
    protected function modifyColumnHeadings(callable $callback)
    {
        add_filter(sprintf('manage_edit-%s_columns', static::NAME), $callback);
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
     * @param callable  $callback
     */
    protected function modifySortableColumns(callable $callback)
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::NAME), $callback);
    }

    /**
     * Modify the list table column content
     *
     * Callback gets passed content, column key, and post ID
     *
     *     $callback($content, column-key, 12);
     *
     * @param callable  $callback
     */
    protected function modifyColumns(callable $callback)
    {
        add_filter(sprintf('manage_%s_custom_column', static::NAME), $callback, null, 3);
    }

    /**
     * "Register" a built-in taxonomy, this just adds our config to the default
     * already registered config
     *
     * @param  array  $config
     */
    protected function registerBuiltin($config)
    {
        global $wp_taxonomies;

        if ( ! isset($wp_taxonomies[static::NAME])) {
            return;
        }

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v)
                {
                    $wp_taxonomies[static::NAME]->$key->$k = $v;
                }
            } else {
                $wp_taxonomies[static::NAME]->$key = $value;
            }
        }

        $this->config = $wp_taxonomies[static::NAME];
    }
}
