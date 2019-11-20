<?php

declare(strict_types=1);

namespace Fire\Menu;

use Walker_Nav_Menu;

class LevelWrapWalker extends Walker_Nav_Menu
{
    /** @var string $openTag */
    protected $openTag = '<div>';

    /** @var string $closeTag */
    protected $closeTag = '</div>';

    /** @var callable(callable,int,array):void $fn */
    protected $fn;

    public function setTags(string $openTag, string $closeTag): self
    {
        $this->openTag = $openTag;
        $this->closeTag = $closeTag;
        return $this;
    }

    public function setTagsFrom(callable $fn): self
    {
        $this->fn = $fn;
        return $this;
    }

    /**
     * @param string $output
     * @param int $depth
     * @param array $args
     */
    public function start_lvl(&$output, $depth = 0, $args = []): void
    {
        if ($this->fn) {
            ($this->fn)([$this, 'setTags'], $depth, $args);
        }

        $output .= $this->openTag;
        parent::start_lvl($output, $depth, $args);
    }

    /**
     * @param string $output
     * @param int $depth
     * @param array $args
     */
    public function end_lvl(&$output, $depth = 0, $args = []): void
    {
        if ($this->fn) {
            ($this->fn)([$this, 'setTags'], $depth, $args);
        }

        parent::end_lvl($output, $depth, $args);
        $output .= $this->closeTag;
    }
}
