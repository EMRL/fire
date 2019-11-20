<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class ArchiveTitle extends Hook
{
    public function register(): Hook
    {
        add_filter('post_type_archive_title', [$this, 'run'], 10, 2);
        return $this;
    }

    public function run(string $title, string $type): string {
        if ($this->isType($type)) {
            $title = $this->fn($title);
        }

        return $title;
    }
}
