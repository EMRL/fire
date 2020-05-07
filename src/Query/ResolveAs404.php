<?php

declare(strict_types=1);

namespace Fire\Query;

use WP_Query;

class ResolveAs404
{
    /** @var callable[] $args */
    protected $tests = [];

    /** @var bool $is404 */
    protected $is404 = false;

    public function __construct(callable ...$tests)
    {
        $this->tests = $tests;
    }

    public function register(): self
    {
        add_action('wp', [$this, 'parse']);
        return $this;
    }

    public function parse(): void
    {
        global $wp_query;

        foreach ($this->tests as $test) {
            if ($test($wp_query)) {
                $this->set404($wp_query);
                break;
            }
        }
    }

    public function is404(): bool
    {
        return $this->is404;
    }

    protected function set404(WP_Query $query): void
    {
        $this->is404 = true;
        status_header(404);
        $query->init();
        $query->parse_query(['post' => 0]);
        $query->set_404();
    }
}
