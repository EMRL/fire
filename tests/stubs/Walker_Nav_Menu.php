<?php

declare(strict_types=1);

abstract class Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = []): void
    {
        $output .= 'Start';
    }

    public function end_lvl(&$output, $depth = 0, $args = []): void
    {
        $output .= 'End';
    }
}
