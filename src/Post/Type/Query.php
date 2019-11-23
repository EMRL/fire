<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use Closure;
use WP_Query;

class Query extends Hook
{
    public function register(): Hook
    {
        add_action('pre_get_posts', [$this, 'run']);
        return $this;
    }

    public function run(WP_Query $query): void
    {
        if ($query->is_main_query() && $this->isType($query->get('post_type'))) {
            $this->fn($query);
        }
    }

    public static function set(array $data): Closure
    {
        return function (WP_Query $query) use ($data): void {
            foreach ($data as $key => $value) {
                $query->set($key, $value);
            }
        };
    }
}
