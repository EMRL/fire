<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use Closure;
use Fire\Post\Page;
use Fire\Post\Type;
use WP_Post;

class ArchivePageSetting
{
    /** @var string GROUP */
    public const GROUP = 'reading';

    /** @var Type $type */
    protected $type;

    /** @var string $key */
    protected $key;

    public function __construct(Type $type)
    {
        $this->type = $type;
        $this->key = 'page_for_'.$type::TYPE;
    }

    public function register(): Closure
    {
        return function (): void {
            register_setting(static::GROUP, $this->key, [
                'type' => 'integer',
                'sanitize_callback' => 'intval',
                'default' => 0,
            ]);

            add_settings_field(
                $this->key,
                "{$this->type->config()->label} page",
                [$this, 'field'],
                static::GROUP,
                'default',
                ['label_for' => $this->key]
            );
        };
    }

    public function field(): void
    {
        wp_dropdown_pages([
            'name' => $this->key,
            'show_option_none' => __('&mdash; Select &mdash;'),
            'option_none_value' => 0,
            'selected' => get_option($this->key),
        ]);
    }

    public function states(): Closure
    {
        return function (array $states, WP_Post $post): array {
            $id = (int) get_option($this->key);

            if ($post->post_type === Page::TYPE && $post->ID === $id) {
                $states[$this->type::TYPE] = "{$this->type->config()->label} Page";
            }

            return $states;
        };
    }
}
