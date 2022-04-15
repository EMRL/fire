<?php

declare(strict_types=1);

namespace Fire\Query;

class ResolveAs404
{
    /** @var callable[] */
    protected readonly array $tests;

    protected bool $is404 = false;

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
        foreach ($this->tests as $test) {
            if ($test()) {
                $this->set404();
                break;
            }
        }
    }

    public function is404(): bool
    {
        return $this->is404;
    }

    protected function set404(): void
    {
        global $wp_query;

        $this->is404 = true;
        status_header(404);
        $wp_query->init();
        $wp_query->parse_query(['post' => 0]);
        $wp_query->set_404();
    }
}
