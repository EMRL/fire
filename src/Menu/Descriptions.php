<?php

declare(strict_types=1);

namespace Fire\Menu;

use stdClass;
use WP_Post;

class Descriptions
{
    protected array $keys = ['before', 'link_before', 'link_after', 'after'];

    public function register(): self
    {
        add_filter('wp_nav_menu_args', [$this, 'args']);
        add_filter('nav_menu_item_args', [$this, 'item'], 10, 2);
        return $this;
    }

    /**
     * @param array<string,mixed> $args
     */
    public function args(array $args): array
    {
        // Keep copy of original values
        foreach ($this->keys as $key) {
            $args['__'.$key] = $args[$key];
        }

        // Add default descriptions format if missing
        if (!isset($args['descriptions'])) {
            $args['descriptions'] = '<div>%s</div>';
        }

        return $args;
    }

    public function item(stdClass $args, WP_Post $item): stdClass
    {
        // Reset to original value
        foreach ($this->keys as $key) {
            $args->$key = $args->{'__'.$key};
        }

        // Format description
        if ($desc = $item->description) {
            $desc = sprintf($args->descriptions, do_shortcode($desc));
        }

        // Insert description into args if applicable
        foreach ($this->keys as $key) {
            $args->$key = sprintf($args->$key, $desc);
        }

        return $args;
    }
}
