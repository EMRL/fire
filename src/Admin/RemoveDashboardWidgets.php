<?php

declare(strict_types=1);

namespace Fire\Admin;

final class RemoveDashboardWidgets
{
    /** @var string[] */
    protected readonly array $ids;

    public function __construct(string ...$ids)
    {
        $this->ids = $ids;
    }

    public function register(): self
    {
        add_action('wp_dashboard_setup', [$this, 'remove']);

        return $this;
    }

    public function remove(): void
    {
        foreach ($this->ids as $id) {
            remove_meta_box($id, 'dashboard', 'normal');
            remove_meta_box($id, 'dashboard', 'side');
        }
    }
}
