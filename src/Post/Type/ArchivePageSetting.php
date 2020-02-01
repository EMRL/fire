<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use Closure;
use Fire\Post\Page;
use WP_Post;
use WP_Post_Type;

use function Fire\Post\page_id_for_type;

class ArchivePageSetting
{
    /** @var string GROUP */
    protected const GROUP = 'reading';

    /** @var string OPTION_NAME */
    public const OPTION_NAME = 'page_for_%s';

    /** @var string $type */
    protected $type;

    /** @var callable(WP_Post_Type):string $label */
    protected $label;

    /** @var string $key */
    protected $key;

    public function __construct(string $type, ?callable $label)
    {
        $this->type = $type;
        $this->label = $label ?: [$this, 'defaultLabel'];
        $this->key = static::optionName($type);
    }

    public static function optionName(string $type): string
    {
        return sprintf(static::OPTION_NAME, $type);
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
                "{$this->label()} page",
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

    public function slug(): Closure
    {
        return function (array $args): array {
            if ($id = page_id_for_type($this->type)) {
                if (!isset($args['rewrite'])) {
                    $args['rewrite'] = [];
                }

                $args['rewrite']['slug'] = get_post_field('post_name', $id);
            }

            return $args;
        };
    }

    public function permalinks(): Closure
    {
        return function (int $id, WP_Post $new, WP_Post $old): void {
            if (page_id_for_type($this->type) === $id && $new->post_name !== $old->post_name) {
                flush_rewrite_rules();
            }
        };
    }

    public function delete(): Closure
    {
        return function (int $id): void {
            if (page_id_for_type($this->type) === $id) {
                update_option($this->key, 0);
                flush_rewrite_rules();
            }
        };
    }

    public function states(): Closure
    {
        return function (array $states, WP_Post $post): array {
            $id = (int) get_option($this->key);

            if ($post->post_type === Page::TYPE && $post->ID === $id) {
                $states[$this->type] = "{$this->label()} Page";
            }

            return $states;
        };
    }

    public function archiveTitle(): Closure
    {
        return function (string $title): string {
            if ($id = page_id_for_type($this->type)) {
                $title = get_post_field('post_title', $id);
            }

            return $title;
        };
    }

    protected function defaultLabel(WP_Post_Type $type): string
    {
        return $type->label;
    }

    protected function label(): string
    {
        return ($this->label)(get_post_type_object($this->type));
    }
}
